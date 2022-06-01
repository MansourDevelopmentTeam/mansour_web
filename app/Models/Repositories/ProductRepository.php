<?php

namespace App\Models\Repositories;

use App\Models\Home\Section;
use App\Models\Payment\Promotion\Promotion;
use App\Models\Payment\Promotion\PromotionConditions;
use App\Models\Payment\Promotion\PromotionTargets;
use Illuminate\Http\Request;
use App\Models\Payment\Promo;
use App\Models\Products\Brand;
use App\Models\Products\Group;
use App\Models\Products\Product;
use App\Models\Products\Category;
use App\Models\Products\ListItems;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Query\Builder;
use App\Models\Products\Sort\SorterBuilder;

/**
*
*/
class ProductRepository
{

	public function getAllProducts()
	{
		return Product::MainProduct()->available()->all();
	}

	public function getAllProductsPaginated()
	{
		return Product::MainProduct()->available()->paginate(10)->orderBy("order", "ASC")->items();
	}

	public function getProductsByCategory($category_id)
	{
		return Product::MainProduct()->available()->where("category_id", $category_id)->where("active", 1)->orderBy("order", "ASC")->paginate(10)->items();
	}

	public function getProductsByCategoryCount($category_id)
	{
		return Product::MainProduct()->available()->where("category_id", $category_id)->where("active", 1)->orderBy("order", "ASC")->paginate(10)->total();
	}

    public function getProductsOptionsValues($products)
    {
        $valuesWithOption = $products->pluck('productOptionValuesForFilter')->flatten(1)->unique('id')->where('option.appear_in_search', 1);
        $values = collect();
        $options = collect();
        foreach ($valuesWithOption as $val) {
            if (!$values->where('id', $val->id)->first()) {
                $values->push($val);
                if ($option = $options->where('id', $val->option->id)->first()) {
                    $option['values'] = collect($option['values'])->push(collect($val)->except('option'));
                    continue;
                }
                $option = collect($val->option)->put('values', [collect($val)->except('option')]);
                $options->push($option);
            }
        }
        return $options;
    }

    public function fullSearch(Request $request)
    {
        $query = Product::query()->MainProduct()->with("availableProductVariants.images","productVariantOptions", "productVariants", "productOptionValuesForFilter.option","productVariantValues",'ProductOptionValues','brand','category','category.parent','category.group','tags','lists')->select("*", DB::raw("COALESCE(discount_price, price) AS final_price"))->active();
        $price_from = isset($request) && is_numeric($request->price_from) ? $request->price_from : null;
        $price_to = isset($request) && is_numeric($request->price_to) ? $request->price_to : null;

        $query->whereHas("productVariants", function ($q) {
            $q->where("active", 1);
        });

        if ($request->q) {
            $tnt = Product::tnt();
            $tnt->fuzziness = true;
            $tnt->fuzzy_distance = 1;
            $res = $tnt->search($request->q);

            $query->where(function ($q) use ($res, $request) {
                return $q->whereIn("id", $res["ids"])->orWhere("sku", "LIKE", "%{$request->q}%")->orWhere("name", "LIKE", "%{$request->q}%")->orWhere("name_ar", "LIKE", "%{$request->q}%");
            });
        }

        $query->when($request->brand_ids, function ($q) use ($request) {
            $q->whereIn("brand_id", $request->brand_ids);
        });

        $query->when($price_from, function ($q) use ($price_from) {
            $q->whereHas('productVariants', function ($q) use ($price_from) {
                $q->whereRaw("COALESCE(discount_price, price) >= ". ($price_from * 100));  //
            });
        });

        $query->when($price_to, function ($q) use ($price_to) {
            $q->whereHas('productVariants', function ($q) use ($price_to) {
                $q->whereRaw("COALESCE(discount_price, price) <= ". ($price_to * 100));
            });
        });


        $query->when($request->category_id, function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('parent_id', $request->category_id);
                })->orWhereHas('optionalSubCategory', function ($q) use ($request) {
                    $q->where('parent_id', $request->category_id);
                });
            });
        });
        $query->when($request->sub_categories, function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                $query->whereIn('category_id', $request->sub_categories)
                    ->orWhereIn('optional_sub_category_id', $request->sub_categories);
            });
        });
        $query->when($request->group_id, function ($q) use ($request) {
            $q->whereHas('category.group', function ($q) use ($request) {
                $q->whereIn('groups.id', $request->group_id);
            });
        });
        $query->when($request->rate, function ($q) use ($request) {
            $q->where('rate', '>=', $request->rate);
        });

        //$query->when($request->options_values_ids, function ($q) use ($request) {
        //    $q->whereHas('optionValues', function ($q) use ($request) {
        //        $q->whereIn('option_values.id', $request->options_values_ids);
        //    });
        //});

        $query->when($request->promotions, function ($q) {
            $listsArray = Promotion::active()->pluck('list_id')->toArray();

            $promotions = Promotion::active()
                ->whereHas('conditions', function ($q) {
                    $q->where('item_type', PromotionConditions::ITEM_TYPES['lists']);
                })->whereHas('targets', function ($q) {
                    $q->where('item_type', PromotionTargets::ITEM_TYPES['lists']);
                })
                ->with('conditions', 'targets')
                ->get();

            $lists1 = $promotions->pluck('conditions')->flatten()->pluck('item_id');
            $lists2 = $promotions->pluck('targets')->flatten()->pluck('item_id');

            $listsPromotionsArray = $lists1->merge($lists2)->unique()->toArray();

            $q->whereHas('lists', function ($q) use ($listsPromotionsArray) {
                $q->whereIn('lists.id', $listsPromotionsArray);
            })->orWhere(function ($q) {
                $now = date('Y-m-d');
                $q->whereNotNull('discount_price');
                // $q->where('reservation_from', '>=', $now);
                // $q->where('reservation_from', '<=', $to);
                // $q->whereBetween(, []);
            });
        });


        $query->when($request->tags_ids, function ($q) use ($request) {
            $q->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('tags.id', $request->tags_ids);
            });
        });

        // $query->when($request->option_ids, function ($q) use ($request) {
        //     $q->whereHas('allOptions', function ($q) use ($request) {
        //         $q->whereIn('options.id', $request->option_ids);
        //     });
        // });

        // $query->when($request->options_values_ids, function ($q) use ($request) {
        //     $q->whereHas('productOptionValuesForFilter', function ($q) use ($request) {
        //         $q->whereIn('option_values.id', $request->options_values_ids);
        //     });
        // });

        $query->when($request->list_ids, function ($q) use ($request) {
            $list = ListItems::whereIn('list_id',$request->list_ids)->pluck('item_id')->toArray();
            $uniqueItemsIDS = array_unique($list);
            $q->whereIn("id", $uniqueItemsIDS);
        });

        $query->when(!$request->q || $request->q == null || empty($request->q), function ($q) use ($request) {
            // $q->available();
            // $q->orderBy("order", "ASC");
        });

        if ($request->sort) {
            $sorter = SorterBuilder::build();
            $query = $sorter->sort($query, $request->sort);
            return $query->get();
            // $query->when($request->sort, function ($q) use ($request) {
            //     $sorter = SorterBuilder::build();
            //     $query = $sorter->sort($q, $request->sort);
            //     return $query->get();
            // });
        } else {
            if ($request->q) {
                if (count($res["ids"])) {
                    $ids = implode(", ", $res["ids"]);
                    $query->orderByRaw("FIELD(id, {$ids})");
                }
            } else {
                $query->orderBy("order", "DESC");
            }
        }

        if ($request->q || $request->q != null || !empty($request->q)) {
            $products = $query->get();
        } else {
            // $products = $query->get()->sortByDesc('variants_stock_count');
            $products = $query->get();
        }

        // $products = $query->get();

        return $products;
    }

    /**
     * Full search products
     *
     * @deprecated v1
     * @param Request $request
     * @return Collection
     */
    public function fullSearchVariants(Request $request)
    {
        // DEPRECATED
        $query = Product::query()
                        ->variantProduct()
                        ->with([
                            "parent",
                            "availableProductVariants.images",
                            "productVariantOptions",
                            "productVariants",
                            "productOptionValuesForFilter.option",
                            "productVariantValues",
                            'ProductOptionValues',
                            'brand',
                            'category',
                            'category.parent',
                            'category.group',
                            'tags',
                            'lists'
                        ])
                        ->select([
                            "*",
                            DB::raw("COALESCE(discount_price, price) AS final_price"),
                            DB::raw("stock > 0 as in_stock")
                        ])->activeParent();


        $price_from = isset($request) && is_numeric($request->price_from) ? $request->price_from : null;
        $price_to = isset($request) && is_numeric($request->price_to) ? $request->price_to : null;

        if ($request->q) {
            $tnt = Product::tnt();
            $tnt->fuzziness = true;
            $tnt->fuzzy_distance = 1;
            $res = $tnt->search($request->q);
            $query->where(function ($q) use ($res, $request) {
                return $q->whereIn("id", $res["ids"])->orWhere("sku", "LIKE", "%{$request->q}%")->orWhere("name", "LIKE", "%{$request->q}%")->orWhere("name_ar", "LIKE", "%{$request->q}%");
            });
        }

        $query->when($request->brand_ids, function ($q) use ($request) {
            $q->whereIn("brand_id", $request->brand_ids);
        });

        $query->when($price_from, function ($q) use ($price_from) {
            $q->whereRaw("COALESCE(discount_price, price) >= ". ($price_from * 100));  //
        });

        $query->when($price_to, function ($q) use ($price_to) {
            $q->whereRaw("COALESCE(discount_price, price) <= ". ($price_to * 100));
        });
        if ($request->in_stock !== null) {
            if ($request->in_stock) {
                $query->where('stock', '>', 0);
            } else {
                $query->where('stock', '<', 1);
            }
        }

        $query->when($request->category_id, function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('parent_id', $request->category_id);
                })->orWhereHas('optionalSubCategory', function ($q) use ($request) {
                    $q->where('parent_id', $request->category_id);
                });
            });
        });
        $query->when($request->sub_categories, function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                $query->whereIn('category_id', $request->sub_categories)
                    ->orWhereIn('optional_sub_category_id', $request->sub_categories);
            });
        });
        $query->when($request->group_id, function ($q) use ($request) {
            $q->where(function ($q) use ($request) {
                $q->whereHas('category', function ($q) use ($request) {
                    $q->whereHas('group', function ($q) use ($request) {
                        $q->whereIn('groups.id', $request->group_id);
                    });
                })->orWhereHas("optionalSubCategory", function ($q) use ($request) {
                    $q->whereHas('group', function ($q) use ($request) {
                        $q->whereIn('groups.id', $request->group_id);
                    });
                });
            });
        });
        $query->when($request->rate, function ($q) use ($request) {
            $q->where('rate', '>=', $request->rate);
        });
        $query->when($request->promotions, function ($q) {
            $q->where(function ($q2) {
                $q2->whereHas('parent', function ($q2) {
                    $q2->whereHas('lists', function ($q3) {
                        $promotions = Promotion::active()
                            ->whereHas('conditions', function ($q) {
                                $q->where('item_type', PromotionConditions::ITEM_TYPES['lists']);
                            })->whereHas('targets', function ($q) {
                                $q->where('item_type', PromotionTargets::ITEM_TYPES['lists']);
                            })
                            ->with('conditions', 'targets')
                            ->get();

                        $lists1 = $promotions->pluck('conditions')->flatten()->pluck('item_id');
                        $lists2 = $promotions->pluck('targets')->flatten()->pluck('item_id');

                        $listsPromotionsArray = $lists1->merge($lists2)->unique()->toArray();

                        $listsPromosArray = Promo::active()->whereDate('expiration_date', '<=', now())->pluck('list_id')->toArray();
        
                        $listsArray = array_merge(array_filter($listsPromotionsArray), array_filter($listsPromosArray));
        
                        $q3->whereIn('lists.id', $listsArray);
                        // ->orWhereIn('lists.id', $listsArray)
                        // ->orWhereHas("promos", function ($q4) {
                        //     $q4->where("active", 1)->where("expiration_date", ">", now());
                        // });
                    })
                    ->orWhere("type", 2)->orWhere(function ($q) {
                        $q->where("preorder", 1)
                        ->where("preorder_start_date", "<", now())
                        ->where("preorder_end_date", ">", now());
                    });
                })
                ->orWhere(function ($q3) {
                    $q3->whereNotNull('discount_price');
                })
                ->orWhere("type", 2)
                ->orWhere("preorder", 1);
            });
        });

        $query->when($request->tags_ids, function ($q) use ($request) {
            $q->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('tags.id', $request->tags_ids);
            });
        });

        $query->when($request->list_ids, function ($q) use ($request) {
            $list = ListItems::whereIn('list_id',$request->list_ids)->pluck('item_id')->toArray();
            $uniqueItemsIDS = array_unique($list);
            $q->whereIn("parent_id", $uniqueItemsIDS);
        });

        if ($request->sort) {
            $sorter = SorterBuilder::build();
            $query = $sorter->sort($query, $request->sort);
            return $query->get();
            // $query->when($request->sort, function ($q) use ($request) {
            //     $sorter = SorterBuilder::build();
            //     $query = $sorter->sort($q, $request->sort);
            //     return $query->get();
            // });
        } else {
            if ($request->q) {
                if (count($res["ids"])) {
                    $ids = implode(", ", $res["ids"]);
                    $query->orderByRaw("FIELD(id, {$ids})");
                }
            } else {
                $query->orderBy("in_stock", "DESC")->orderBy("order", "DESC");
            }
        }

        // if($request->q || $request->q != null || !empty($request->q)){
        //     $products = $query->get();
        // }else{
        //     $products = $query->orderBy("in_stock", "DESC")->orderBy("order", "ASC")->get();
        // }

        $products = $query->get();

        return $products;
    }
    /**
     * Search in main products
     *
     * @return Collection
     */
    public function searchMainProducts()
    {
        $products = Product::query()
                        ->MainProduct()
                        ->with([
                            "availableProductVariants.images",
                            "productVariantOptions",
                            "productVariantValues",
                            'ProductOptionValues',
                            'brand',
                            'category',
                            'category.parent',
                            'category.group',
                            'tags'
                            ])
                            ->select([
                                "*",
                                DB::raw("COALESCE(discount_price, price) AS final_price"),
                                DB::raw("stock > 0 as in_stock")
                            ])->active();

        return $this->searchQuery($products);
    }

    /**
     * Search in variant products
     *
     * @return Collection
     */
    public function searchVariantProducts()
    {
        $products = Product::query()
                        ->variantProduct()
                        ->with([
                            "parent",
                            "availableProductVariants.images",
                            "productVariantOptions",
                            "productVariants",
                            "productOptionValuesForFilter.option",
                            "productVariantValues",
                            'ProductOptionValues',
                            'brand',
                            'category',
                            'category.parent',
                            'category.group',
                            'tags',
                            'lists'
                        ])
                        ->select([
                            "*",
                            DB::raw("COALESCE(discount_price, price) AS final_price"),
                            DB::raw("stock > 0 as in_stock")
                        ])->activeParent();

        return $this->searchQuery($products);
    }

    /**
     * Get groups from products
     *
     * @param [type] $products
     * @return Collection
     */
    public function getProductGroups($products)
    {
        $category_ids = $products->pluck("category_id")->toArray();

        return Group::whereHas('active_sub_categories', function ($query) use ($category_ids) {
                return $query->whereIn('categories.id', $category_ids)->where('parent_id', '!=', null);
        })->with(['active_sub_categories' => function ($q) use ($category_ids) {
			return $q->whereIn('categories.id', $category_ids)->where('parent_id', '!=', null);
        }])->get();
    }

    /**
     * Get brands from products
     *
     * @param [type] $products
     * @return Collection
     */
    public function getProductBrands($products)
    {
        $brand_ids = $products->pluck("brand_id")->toArray();
        return Brand::whereIn("id", $brand_ids)->orderBy("name", "ASC")->get();
    }
    /**
     * Search filter query
     *
     * @param Builder $products
     * @return Product
     */
    private function searchQuery($products)
    {
        // Search by price LOW filter
        if (request()->get('price_from')) {
            $price_from = (int) request()->get('price_from');
            $products->whereRaw("COALESCE(discount_price, price) >= ". ($price_from * 100));
        }
        // Search by price HIGH filter
        if (request()->get('price_to')) {
            $price_to = (int) request()->get('price_to');
            $products->whereRaw("COALESCE(discount_price, price) <= ". ($price_to * 100));
        }
        // Search by brands
        if (request()->get('brand_ids')) {
            $products->whereIn("brand_id", request()->get('brand_ids'));
        }
        // Search by categories
        if (request()->get('category_id')) {
            $products->where(function ($query) {
                $query->whereHas('category', function ($q) {
                    $q->where('parent_id', request()->get('category_id'));
                })->orWhereHas('optionalSubCategory', function ($q) {
                    $q->where('parent_id', request()->get('category_id'));
                });
            });
        }
        //Search by sub categories
        if (request()->get('sub_categories')) {
            $products->where(function ($q) {
                $q->whereIn('category_id', request()->get('sub_categories'))
                    ->orWhereIn('optional_sub_category_id', request()->get('sub_categories'));
            });
        }
        // Search by group
        if (request()->get('group_id')) {
            $products->where(function ($q) {
                $q->whereHas('category.group', function ($q) {
                    $q->whereIn('groups.id', request()->get('group_id'));
                })->orWhereHas("optionalSubCategory.group", function ($q) {
                    $q->whereIn('groups.id', request()->get('group_id'));
                });
            });
        }
        // Search by rate
        if (request()->get('rate')) {
            $products->where('rate', '>=', request()->get('rate'));
        }
        // Search by promotions OR promo
        if (request()->get('promotions')) {
            $products->where(function ($q) {
                $q->whereHas('parent', function ($q) {
                    $q->whereHas('lists', function ($q) {
                        $promotions = Promotion::active()
                            ->whereHas('conditions', function ($q) {
                                $q->where('item_type', PromotionConditions::ITEM_TYPES['lists']);
                            })->whereHas('targets', function ($q) {
                                $q->where('item_type', PromotionTargets::ITEM_TYPES['lists']);
                            })
                            ->with('conditions', 'targets')
                            ->get();

                        $lists1 = $promotions->pluck('conditions')->flatten()->pluck('item_id');
                        $lists2 = $promotions->pluck('targets')->flatten()->pluck('item_id');

                        $listsPromotionsArray = $lists1->merge($lists2)->unique()->toArray();


                        $listsPromosArray = Promo::activeNow()->pluck('list_id')->toArray();
                        $listsArray = array_merge(array_filter($listsPromotionsArray), array_filter($listsPromosArray));
        
                        $q->whereIn('lists.id', $listsArray);
                    })
                    ->orWhere("type", 2)
                    ->orWhere(function ($q) {
                        $q->activePreOrder();
                    });
                })
                ->orWhere(function ($q) {
                    $q->activeDiscount();
                })
                ->orWhere("type", 2);
            });
        }
        // Search by tags
        if (request()->get('tags_ids')) {
            $products->whereHas('tags', function ($q) {
                $q->whereIn('tags.id', request()->get('tags_ids'));
            });
        }
        // Search by stock
        if (request()->get('in_stock') && request()->get('in_stock') !== null) {
            if (request()->get('in_stock')) {
                $products->where('stock', '>', 0);
            } else {
                $products->where('stock', '<', 1);
            }
        }
        // Search by lists
        if (request()->get('list_ids')) {
            $listIds = ListItems::whereIn('list_id', request()->get('list_ids'))->pluck('item_id')->unique()->toArray();
            $columnName = config('constants.products') == "main" ? "id" : "parent_id";
            $products->whereIn($columnName, $listIds);
        }
        // Search by words
        if (request()->get('q')) {
            $tnt = Product::tnt();
            $tnt->fuzziness = true;
            $tnt->fuzzy_distance = 1;
            $word = request()->get('q');
            $res = $tnt->search($word);
            if (config('constants.products') == "main") {
                $products->whereIn("id", $res["ids"])->orWhereHas("productVariants", function ($q) use ($word) {
                    $q->where("sku", "LIKE", "{$word}%");
                });
            } else {
                $products->where(function ($q) use ($res, $word) {
                    return $q->whereIn("id", $res["ids"])->orWhere("sku", "LIKE", "%{$word}%");
                });
            }
        }
        // Sort
        if (request()->get('sort')) {
            $sorter = SorterBuilder::build();
            $products = $sorter->sort($products, request()->get('sort'));
        } else {
            if (request()->get('q') && count($res["ids"])) {
                $ids = implode(", ", $res["ids"]);
                $products->orderByRaw("FIELD(id, {$ids})");
            } else {
                $products->orderBy("in_stock", "DESC")->orderBy("order", "DESC");
            }
        }

        // dd($products->toSql());
        return $products->get();
    }

    public function searchProducts($query)
	{
        $tnt = Product::tnt();
        $tnt->fuzziness = true;
        $res = $tnt->search($query);

        $products = Product::MainProduct()->available()->with("category.parent")->active()->where(function ($q) use ($query, $res) {
			$q->where(function ($qu) use ($query) {
				$qu->where("name", "LIKE", "%{$query}%")->orWhere("description", "LIKE", "%{$query}%")->orWhere("description_ar", "LIKE", "%{$query}%")->orWhere("name_ar", "LIKE", "%{$query}%");
			})->orWhereHas("category", function ($qu) use ($query) {
				$qu->where("name", "LIKE", "%${query}%")->orWhere("description", "LIKE", "%{$query}%");
			})->orWhereHas("brand", function ($qu) use ($query) {
				$qu->where("name", "LIKE", "%${query}%");
			})->orWhereIn("id", $res["ids"]);
		})->limit(100)->orderBy("order", "ASC")->get();

		return $products;
	}

	public function getProductById($id)
	{
		return Product::with("productVariantOptions", "productVariants.productVariantOptions", "productVariants.images", "category.parent")->findOrFail($id);
	}

    /**
     * Get ten products by section
     *
     * @param Section $section
     * @return Collection
     */
    public function getTenProductBySection($section)
    {
        if (config('constants.products') == "main") {
            $query = $section->load(['list.tenProducts' => function ($query) {
                    $query->whereNull('parent_id')->whereHas('productVariants', function ($q) {
                        $q->select(DB::raw('SUM(stock) as variant_sum_stock'))
                            ->havingRaw('variant_sum_stock > 0');
                    });
            }]);
            $products = $query->list->tenProducts;
        } else {
            $products = $section->TenProductsVariant();
        }
        return $products;
    }
    /**
     * Get most bought products
     *
     * @return void
     */
	public function getMostBought()
	{
		return $this->productQuery()
                    ->orderBy("orders_count", "DESC")
                    ->limit(10)
                    ->get();
	}
    /**
     * Get most latest recent products
     *
     * @return void
     */
	public function getMostRecent()
	{
		return $this->productQuery()
                    ->orderBy("created_at", "DESC")
                    ->limit(10)
                    ->get();
	}

    /**
     * Get discounted products
     *
     * @return void
     */
	public function getDiscounted()
	{
		return $this->productQuery()
                    ->orderBy("created_at", "DESC")
                    ->where("discount_price", ">", 0)
                    ->orderBy("discount_price", "DESC")
                    ->limit(10)
                    ->get();
	}
    
    private function productQuery()
    {
        $products = Product::query();
        
        if (config('constants.products') == "main") {
            $products = $products->with("lists.activePromotion", "category.parent", "category.group", "productVariants.productVariantOptions", "productVariants.images")
                                ->mainProduct()
                                ->active();
        } else {
            $products = $products->with("lists.activePromotion", "category.parent", "category.group")
                                ->variantProduct()
                                ->activeParent();
        }
        return $products;
    }

	public function getSimilarProducts($product)
	{
		$category = $product->category;
        $price = null;
		if ($vProduct = optional($product->productVariants)->first()) {
            $price = $vProduct->discount_price ?? $vProduct->price;
        }

        $products = Product::active()->variantProduct()->whereHas('parent', function ($q) use ($category) {
            return $q->where('category_id', $category->id);
        })->with("productVariantOptions", "productVariants.productVariantOptions", "productVariants.images", "category.parent");
        !$price ?: $products->select('*', DB::raw("ABS((if(discount_price is null, price, discount_price) / 100) - {$price}) AS similar_price"))->orderBy('similar_price')->havingRaw('similar_price is not null');
        $products = $products->where("id", "!=", $product->id)->orderBy("order", "ASC")->take(10)->get();
		return $products;
	}
    public function getFbSheet($fileName)
    {
        $products = Product::whereNotNull('parent_id')->with("category.parent", "brand","parent")->get();
        return Excel::create($fileName, function ($excel) use ($products) {
            $excel->sheet('report', function ($sheet) use ($products) {
                $headingArray = ["id", "title", "description", "availability", "condition", "brand", "price", "sale_price", "link", "image_link"];
                $sheet->row(1, array_merge($headingArray));
                $rowNum = 0;
                foreach ($products as $key => $product) {
                    $brand_name = optional($product->parent)->brand ? optional($product->parent)->brand->name : "";
                    $mainProductsArray = [
                        $product->sku,
                        $product->name,
                        "Description: {$product->description}",
                        $product->stock > 0 ? "In Stock" : "Out of Stock",
                        "New",
                        $brand_name,
                        "{$product->price} EGP",
                        $product->discount_price ? "{$product->discount_price} EGP" : '',
                        config('app.website_url') . "/product/{$product->id}",
                        $product->image,
                    ];
                    $sheet->row($rowNum + 2, $mainProductsArray);
                    $rowNum++;
                }
            });
        });
    }
}
