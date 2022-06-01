<?php

namespace Database\Seeders;

use App\Models\Pages\Page;
use App\Models\Payment\PaymentCredential;
use App\Models\Payment\PaymentMethod;
use Illuminate\Database\Seeder;

class Pages extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $paymentMethods = config('pages');
        foreach ($paymentMethods as $configName => $configMethod) {
            $method = Page::firstOrCreate([
                'slug' => $configName
            ], [
                'title_en' => $configMethod['title_en'],
                'title_ar' => $configMethod['title_ar'],
                'content_ar' => $configMethod['content_ar'],
                'content_en' => $configMethod['content_en'],
                'image_en' => $configMethod['image_en'],
                'image_ar' => $configMethod['image_ar'],
                'active' => $configMethod['active'],
            ]);
            $this->command->info("{$configName} -> seeded");
        }
    }
}
