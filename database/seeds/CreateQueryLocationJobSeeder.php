<?php

use App\Jobs\QueryLocation;
use App\Models\Device;
use Illuminate\Database\Seeder;

class CreateQueryLocationJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $devices = Device::whereNotNull('ip_address')->whereNull('address')->get();
        foreach ($devices as $device) {
            QueryLocation::dispatch($device);
        }
    }
}
