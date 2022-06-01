<?php

namespace App\Console\Commands;

use App\Models\Products\Product;
use Illuminate\Console\Command;
use Spatie\Browsershot\Browsershot;
use Spatie\Crawler\Crawler;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate sitemap using spatie\'s sitemap package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();


    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // adding our own browsershot to add the noSandbox option to chrome, since it is run by the root user in docker container
        $browserShot = (new Browsershot())->noSandbox()->ignoreHttpsErrors();
        $path = public_path('sitemap.xml');
        resolve('url')->forceRootUrl(config('app.website_url'));
        $sitemap = SitemapGenerator::create(config('app.website_url'))
            ->configureCrawler(function (Crawler $crawler) use ($browserShot){
                $crawler->setBrowsershot($browserShot);
            })
            ->hasCrawled(function (Url $url){
                // overwriting the base nginx url in our sitemap. Without this the url display in the xml will look something like this: https://nginx/uri
                $uri = implode('/', $url->segments());
                $url->setUrl(config('app.website_url') . '/' . $uri);
                return $url;
            })
            ->getSitemap()
            // adding the base slug routes
            ->add(Url::create('/')->setPriority(0.9))
            ->add(Url::create('/pages/about')->setPriority(0.9))
            ->add(Url::create('/pages/contact')->setPriority(0.9))
            ->add(Url::create('/pages/term-condition')->setPriority(0.9))
            ->add(Url::create('/pages/privacy-policy')->setPriority(0.9))
            ->add(Url::create('/pages/sales')->setPriority(0.9))
            ->add(Url::create('/products')->setPriority(0.9));

        // for some reasons laravel sitemap can only detect static pages. This is a workaround to add slug routes
        $courses = Product::all();
        $courses->each(function ($product) use (&$sitemap){
            $productName = str_replace(' ', '-', $product->name);
            $sitemap->add("/products/{$productName}/{$product->id}");
        });
        $sitemap->writeToFile($path);
    }
}
