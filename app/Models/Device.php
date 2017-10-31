<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_number', 'serial_number', 'fw_version', 'ip_address', 'latitude', 'longitude'
    ];

}
