<?php

namespace App\Http\Resources\Customer\Menu;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryLinkResource extends JsonResource
{
    public static $style;
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "link"                           => $this->id ? $this->link : $this->rawLink,
            "name"                           => $this->name,
            "name_en"                        => $this->name,
            "name_ar"                        => $this->name_ar,
            "image"                          => null,
            "levels_length"                  => $this->id ? 3 : 1,
            "level1_image"                   => false,
            "level2_image"                   => false,
            "level3_image"                   => false,
            "level3_items_spacing"           => self::$style['level3_items_spacing'] ?? "20",
            "level3_items_spacing_metric"    => self::$style['level3_items_spacing_metric'] ?? "px",
            "menu_padding"                   => self::$style['menu_padding'] ?? "2",
            "menu_padding_metric"            => self::$style['menu_padding_metric'] ?? "rem",
            "level1_image_dimentions"        => self::$style['level1_image_dimentions'] ?? "300",
            "level1_image_dimentions_metric" => self::$style['level1_image_dimentions_metric'] ?? "px",
            "menu_fixed_width"               => self::$style['menu_fixed_width'] ?? "99",
            "menu_fixed_width_metric"        => self::$style['menu_fixed_width_metric'] ?? "%",
            "fixed_width"                    => self::$style['fixed_width'] ?? "30",
            "fixed_width_metric"             => self::$style['fixed_width_metric'] ?? "%",
            "order"                          => self::$style['order'] ?? 1000,
            "level2"                         => GroupLinkResource::collection($this->groups),
        ];
    }

    public static function setMenuStyle($style = null)
    {
        self::$style = $style;
    }
}
