<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id', 'bean_category', 'bean_weight', 'water_ratio', 'water_weight', 'work_time', 'rating', 'flavor',
        'feeling','thumbnail','views','likes','unlikes','started_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['started_at'];

    /**
     * Relationships
     */

    /**
     * work belong to user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * work belong to device
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device() {
        return $this->belongsTo(Device::class);
    }

    /**
     * work has many procedures
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function procedures() {
        return $this->hasMany(WorkProcedure::class);
    }

}
