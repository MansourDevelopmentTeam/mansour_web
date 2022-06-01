<?php

namespace App\Models\Products;

use App\Models\Payment\Promo;
use App\Models\Payment\Promotion\PromotionConditions;
use App\Models\Payment\Promotion\PromotionTargets;
use App\Models\Payment\Promotion\Promotion;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    const TYPE_CATEGORY = 1;
    const TYPE_SUBCATEGORY = 2;
    const TYPE_BRANDS = 3;
    const TYPE_PRODUCTS = 4;
    const TYPE_TAGS = 5;
    const TYPE_CUSTOM = 6;

    public static $validation = [
        "name_en"        => "required|string",
        "name_ar"        => "required|string",
        "description_en" => "required|string",
        "description_ar" => "required|string",
        "active"         => "sometimes|nullable|in:0,1",
    ];

    protected $fillable = [
        "name_en",
        "name_ar",
        "description_en",
        "description_ar",
        "type",
        "active",
        // "image_ar",
        // "image_en",
        "list_method",
        "condition_type"
    ];

    protected $casts = [
        'active' => 'integer',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, ListItems::class, 'list_id', 'item_id');
    }

    public function availableProducts()
    {
        return $this->belongsToMany(Product::class, ListItems::class, 'list_id', 'item_id')
            ->whereHas('productVariants', function ($query) {
                $query->where('active', 1);
            });
    }

    public function listItems()
    {
        return $this->hasMany(ListItems::class, 'list_id', 'id');
    }

    public function promos()
    {
        return $this->hasMany(Promo::class, "list_id");
    }

    public function tenProducts()
    {
        return $this->belongsToMany(Product::class, ListItems::class, 'list_id', 'item_id')->active()->orderBy("order", "ASC")->take(10);
    }

    public function getName()
    {
        if (request()->header('lang') == 2) {
            return $this->name_ar ?: $this->name_en;
        }
        return $this->name_en;
    }

    public function getDescription()
    {
        if (request()->header('lang') == 2) {
            return $this->description_ar ?: $this->description_en;
        }
        return $this->description_en;
    }

    public function getImage()
    {
        if (request()->header('lang') == 2) {
            return $this->image_ar ?: $this->image_en;
        }
        return $this->image_en;
    }

    public function activePromotion()
    {
        $id = $this->getOriginal('id');

        return Promotion::whereHas('conditions', function ($query) use ($id){
                $query->where('item_type', PromotionConditions::ITEM_TYPES['lists'])->Where('item_id', $id);
            })
            ->orWhereHas('targets', function ($query) use ($id){
                $query->where('item_type', PromotionTargets::ITEM_TYPES['lists'])->where('item_id', $id);
            })
            ->active()->first();
    }

    public function manualProductLists($items)
    {
        // type 1 =  category
        // type 2 =  subcategory
        // type 3 =  brands
        // type 4 =  products
        // type 5 =  tags

        foreach ($items as $item) {
            $query = Product::query();
            $query->when($item['type'] == 1, function ($query) use ($item) {
                $query->whereHas('category', function ($query) use ($item) {
                    $query->WhereIn('categories.parent_id', $item['items']);
                });
            });
            $query->when($item['type'] == 2, function ($query) use ($item) {
                $query->WhereIn('category_id', $item['items']);
            });
            $query->when($item['type'] == 3, function ($query) use ($item) {
                $query->WhereIn('brand_id', $item['items']);
            });
            $query->when($item['type'] == 4, function ($query) use ($item) {
                $query->WhereIn('id', $item['items']);
            });
            $query->when($item['type'] == 5, function ($query) use ($item) {
                $query->whereHas('tags', function ($query) use ($item) {
                    $query->WhereIn('tags.id', $item['items']);
                });
            });
            $products = $query->pluck('id')->toArray();
            if (is_array($item['items'])) {
                foreach ($item['items'] as $row) {
                    $rulesData = [
                        'type'    => $item['type'],
                        'list_id' => $this->id,
                        'item_id' => $row,
                    ];
                    ListRules::updateOrCreate($rulesData);
                }
            } else {
                $rulesData = [
                    'type'    => $item['type'],
                    'list_id' => $this->id,
                    'item_id' => $item['items'],
                ];
                ListRules::updateOrCreate($rulesData);
            }


            foreach ($products as $product) {
                $data = [
                    'list_id' => $this->id,
                    'item_id' => $product,
                ];
                ListItems::updateOrCreate($data);
            }
        }
    }

    public function sync()
    {
        $lists = $this->where('condition_type', 1)->get();
        foreach ($lists as $list) {
            $listItems = ListItems::where('list_id', $list->id)->delete();
            $listRules = $list->listRules()->get();
            $this->conditionProductLists($listRules, $list->condition_type, $list->id);
        }
    }

    public function listRules()
    {
        return $this->hasMany(ListRules::class, 'list_id', 'id');
    }

    public function conditionProductLists($rules, $condition_type, $listID)
    {
        $condition = [
            'LIKE', //0
            '=',  //1
            '!=', //2
            '>', //3
            '<', //4
            '<=', //5
            '>=' //6
        ];
        $strings = ['sku', 'title', 'name', 'name_ar']; //0
        $integers = ['price', 'discount_price', 'stock']; //1
        $identifiers = ['category_id', 'brand_id'];  //2
        $date = ['date']; //3
        $relations = ['tags', 'sub_category_id']; //4
        $query = Product::query();
        $query->when($condition_type == 1, function ($q) use ($rules, $condition, $strings, $integers, $identifiers, $date, $relations, $listID) {
            foreach ($rules as $rule) {
                $rule['value'] = filter_var($rule['value'], FILTER_SANITIZE_STRING);
                in_array($rule['field'], $strings) ? $type = 0 : '';
                in_array($rule['field'], $integers) ? $type = 1 : '';
                in_array($rule['field'], $identifiers) ? $type = 2 : '';
                in_array($rule['field'], $date) ? $type = 3 : '';
                in_array($rule['field'], $relations) ? $type = 4 : '';

                if (isset($condition[$rule['condition']]) && isset($type)) {
                    $q->when($type == 0, function ($q) use ($rule, $condition) {
                        if ($rule['field'] == 'title') {
                            $q->where('name', $condition[$rule['condition']], $condition[$rule['condition']] == 0 ? "%{$rule['value']}%" : $rule['value']);
                            $q->orWhere('name_ar', $condition[$rule['condition']], $condition[$rule['condition']] == 0 ? "%{$rule['value']}%" : $rule['value']);
                        } else {
                            $q->where($rule['field'], $condition[$rule['condition']], $condition[$rule['condition']] == 0 ? "%{$rule['value']}%" : $rule['value']);
                        }
                    });

                    $q->when($type == 1, function ($q) use ($rule, $condition) {
                        $q->where($rule['field'], $condition[$rule['condition']], $rule['value']);
                    });

                    $q->when($type == 2, function ($q) use ($rule, $condition) {
                        $q->where($rule['field'], $condition[$rule['condition']], $rule['value']);
                    });

                    $q->when($type == 3, function ($q) use ($rule, $condition) {
                        $q->whereDate('created_at', $condition[$rule['condition']], $rule['value']);
                    });

                    $q->when($type == 4, function ($q) use ($rule, $condition) {
                        if ($rule['field'] == 'tags') {
                            $q->whereHas('tags', function ($q) use ($rule, $condition) {
                                $q->where('tags.id', $condition[$rule['condition']], $rule['value']);
                            });
                        } elseif ($rule['field'] == 'sub_category_id') {
                            $q->whereHas('category', function ($q) use ($rule, $condition) {
                                $q->where('categories.parent_id', $condition[$rule['condition']], $rule['value']);
                            });
                        }

                    });
                }
                $rulesData = [
                    'field'     => $rule['field'],
                    'condition' => $rule['condition'],
                    'value'     => $rule['value'],
                    'list_id'   => $listID,
                ];
                ListRules::updateOrCreate($rulesData);
            }
            return $q;
        });
        $query->when($condition_type == 0, function ($q) use ($rules, $condition, $strings, $integers, $identifiers, $date, $relations, $listID) {
            foreach ($rules as $rule) {
                $rule['value'] = filter_var($rule['value'], FILTER_SANITIZE_STRING);
                in_array($rule['field'], $strings) ? $type = 0 : '';
                in_array($rule['field'], $integers) ? $type = 1 : '';
                in_array($rule['field'], $identifiers) ? $type = 2 : '';
                in_array($rule['field'], $date) ? $type = 3 : '';
                in_array($rule['field'], $relations) ? $type = 4 : '';

                if (isset($condition[$rule['condition']]) && isset($type)) {
                    $q->when($type == 0, function ($q) use ($rule, $condition) {
                        if ($rule['field'] == 'title') {
                            $q->orWhere('name', $condition[$rule['condition']], $condition[$rule['condition']] == 0 ? "%{$rule['value']}%" : $rule['value']);
                            $q->orWhere('name_ar', $condition[$rule['condition']], $condition[$rule['condition']] == 0 ? "%{$rule['value']}%" : $rule['value']);
                        } else {
                            $q->orWhere($rule['field'], $condition[$rule['condition']], $condition[$rule['condition']] == 0 ? "%{$rule['value']}%" : $rule['value']);
                        }
                    });

                    $q->when($type == 1, function ($q) use ($rule, $condition) {
                        $q->orWhere($rule['field'], $condition[$rule['condition']], $rule['value']);
                    });

                    $q->when($type == 2, function ($q) use ($rule, $condition) {
                        $q->orWhere($rule['field'], $condition[$rule['condition']], $rule['value']);
                    });

                    $q->when($type == 3, function ($q) use ($rule, $condition) {
                        $q->orWhereDate('created_at', $condition[$rule['condition']], $rule['value']);
                    });

                    $q->when($type == 4, function ($q) use ($rule, $condition) {
                        if ($rule['field'] == 'tags') {
                            $q->orWhereHas('tags', function ($q) use ($rule, $condition) {
                                $q->orWhere('tags.id', $condition[$rule['condition']], $rule['value']);
                            });
                        } elseif ($rule['field'] == 'sub_category_id') {
                            $q->orWhereHas('category', function ($q) use ($rule, $condition) {
                                $q->orWhere('categories.parent_id', $condition[$rule['condition']], $rule['value']);
                            });
                        }

                    });
                }
                $rulesData = [
                    'field'     => $rule['field'],
                    'condition' => $rule['condition'],
                    'value'     => $rule['value'],
                    'list_id'   => $listID,
                ];
                ListRules::updateOrCreate($rulesData);
            }
            return $q;
        });
        $products = $query->pluck('id')->toArray();

        if (isset($products) && is_array($products)) {
            foreach ($products as $product) {
                $data = [
                    'list_id' => $listID,
                    'item_id' => $product,
                ];
                ListItems::updateOrCreate($data);
            }
        }
    }
}
