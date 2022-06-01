<?php


namespace App\Models\Repositories;


use App\Http\Resources\Customer\Menu\CategoryLinkResource;
use App\Models\Products\Category;
use Illuminate\Database\Eloquent\Model;

class MenuRepository
{
    public function generateMenu()
    {
        $categories = Category::parents()->active()->with([
            'groups' => function ($q) {
                $q->where('active', 1)->orderBy('order');
            },
            'groups.subcategories' => function ($q) {
                $q->where('active', 1)->orderBy('order');
            },
        ])->get();

        $homeLink = new Category;
        $homeLink->name = "Home";
        $homeLink->name_ar = "الرئيسية";
        $homeLink->rawLink = "/";

        $dealsLink = new Category;
        $dealsLink->name = "Deals";
        $dealsLink->name_ar = "العروض";
        $dealsLink->rawLink = "/products/deals";

        $categories->prepend($homeLink);
        $categories->push($dealsLink);

        $menu = [
            "menu_background_color"      => "#000000",
            "drop_menu_background_color" => "#ffffff",
            "level1_text_color"          => "#ffffff",
            "level1_hover_color"         => config('app.web_brand_color'),
            "level2_text_color"          => config('app.web_brand_color'),
            "level2_hover_color"         => "#000000",
            "level3_text_color"          => "#000000",
            "level3_hover_color"         => config('app.web_brand_color'),
            "level1"                     => [],
        ];

        $categoriesResource = CategoryLinkResource::collection($categories);
        return collect($menu)->put('level1', $categoriesResource);
    }

}