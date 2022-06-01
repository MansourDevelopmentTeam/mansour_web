<?php 

namespace App\Models\Repositories;

use App\Models\Products\Category;

/**
* 
*/
class CategoriesRepository
{
	
	public function getMainCategories()
	{
		return Category::with("subCategories", "creator","subCategories.group")->whereNull("parent_id")->get();
	}
	public function getActiveCategories()
	{
		return Category::with(["subCategories" => function ($q)
		{
			$q->where("active", 1);
		}, "mainCategoryGroups" => function ($q) {
			$q->where("active", 1);
		}, "mainCategoryGroups.sub_categories"])->whereNull("parent_id")->where("active", 1)->orderBy("order", "ASC")->get();
	}
	public function getCategoryById($id)
	{
		return Category::with("subCategories", "creator")->findOrFail($id);
	}
}
