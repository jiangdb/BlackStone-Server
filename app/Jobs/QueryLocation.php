<?php

namespace App\Jobs;

use App\Models\Device;
use App\Services\BadiduMapService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class QueryLocation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $device = null;

    /**
     * Create a new job instance.
     *
     * @param Device $device
     */
    public function __construct(Device $device)
    {
        $this->device = $device;
    }

    /**
     * Execute the job.
     *
     * @param BadiduMapService $service
     */
    public function handle(BadiduMapService $service)
    {
        Log::debug('QueryLocation: handle');
        if (!empty($this->device) && !empty($this->device->ip_address)) {
            $location = $service->queryLocationByIp($this->device->ip_address);
            if (!empty($location)) {
                if ($location->status == 0) {
                    $this->device->address = $location->address;
                    $this->device->street_num = $location->content->address_detail->street_number;
                    $this->device->street = $location->content->address_detail->street;
                    $this->device->district = $location->content->address_detail->district;
                    $this->device->city = $location->content->address_detail->city;
                    $this->device->province = $location->content->address_detail->province;
                    $this->device->longitude = $location->content->point->x;
                    $this->device->latitude = $location->content->point->y;
                    $this->device->save();
                }else{
                    Log::error('QueryLocaltion: error with status '.$location->status);
                }
            }
        }
    }
}
