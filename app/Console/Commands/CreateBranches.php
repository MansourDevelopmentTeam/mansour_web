<?php

namespace App\Console\Commands;

use App\Trolley\Locations\District;
use App\Trolley\Users\User;
use Illuminate\Console\Command;

class CreateBranches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:branches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $districts = District::with("area")->get();

        $count = $districts->count();
        foreach ($districts as $key => $district) {

            $this->info("district {$key} of {$count}");
            $this->info("creating {$district->name}");
            $user = User::firstOrCreate(["name" => $district->name], ["type" => 3]);
            $user->active = 1;
            $user->save();

            $user->addresses()->create(["address" => $district->name]);

            // store deliverer profile
            $deliverer_profile = $user->delivererProfile()->create(["city_id" => $district->area->city_id, "area_id" => $district->area_id]);
            $deliverer_profile->status = 3;
            $deliverer_profile->save();

            $deliverer_profile->districts()->attach($district->id);
        }
    }
}
