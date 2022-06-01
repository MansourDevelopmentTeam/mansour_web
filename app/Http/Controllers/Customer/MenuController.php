<?php

namespace App\Http\Controllers\Customer;


use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\CategoryWithGroupsResource;
use App\Http\Resources\Customer\Menu\CategoryLinkResource;
use App\Models\Configuration;
use App\Models\Products\Category;
use App\Models\Repositories\CategoriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class MenuController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $menu = Configuration::getValueByKey('menu');
        $menu = json_decode($menu, true);
        if ($this->mustInjectCategories($menu)->status) {
            $categoriesKeyIndex = $this->mustInjectCategories($menu)->index;
            $generatedCategories = $this->getCategoriesMenu($menu['level1'][$categoriesKeyIndex]);
            $this->injectCategories($menu, $generatedCategories, $categoriesKeyIndex);
        }
        return $this->jsonResponse("Success", $menu);
    }

    /**
     * Check if menu must be injected with auto generated links to categories
     *
     * @param array $menu
     * @return object
     */
    private function mustInjectCategories(array $menu): object
    {
        $result['status'] = false;
        $result['index'] = null;
        for ($i = 0; $i < count($menu['level1']); $i++) {
            $linkObject = $menu['level1'][$i];
            $injectCategoriesKeyExists = array_key_exists('auto_category', $linkObject);
            if ($injectCategoriesKeyExists && $linkObject['auto_category']) {
                $result['status'] = $linkObject['auto_category'];
                $result['index'] = $i;
                break;
            }
        }
        return (object)$result;
    }

    /**
     * Get categories link items
     *
     * @return array
     */
    private function getCategoriesMenu($style = null) : array
    {
        $categories = Category::parents()->active()->with([
            'groups' => function ($q) {
                $q->where('active', 1)->orderBy('order');
            },
            'groups.subcategories' => function ($q) {
                $q->where('active', 1)->orderBy('order');
            },
        ])->get();

        CategoryLinkResource::setMenuStyle($style);
        return CategoryLinkResource::collection($categories)->resolve();
    }

    /**
     * Replace 'auto_category' flag with the generated categor links
     *
     * @param $menu
     * @param $injectedCategories
     * @param $index
     */
    private function injectCategories(&$menu, $injectedCategories, $index)
    {
        $itemsBeforeCategory = array_slice($menu['level1'], 0, $index);
        $itemsAfterCategory = array_slice($menu['level1'], $index + 1);
        $menu['level1'] = array_merge($itemsBeforeCategory, $injectedCategories, $itemsAfterCategory);
    }

}
