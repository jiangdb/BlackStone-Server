<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id', 'bean_category', 'bean_weight', 'water_ratio', 'water_weight', 'grand_size', 'temperature',
        'work_time', 'rating', 'flavor', 'accessories', 'feeling','thumbnail','views','likes','unlikes','data',
        'started_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['started_at','deleted_at'];

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

    public function getFormattedWorkTimeAttribute()
    {
        return gmdate('i:s', $this->work_time);
    }

    public function getScaleNumberAttribute()
    {
        $data = json_decode($this->data);
        return $data[0][1] ? 2:1;
    }

    public function getDatasAttribute()
    {
        return json_decode($this->data);
    }

    public function getLastDataAttribute()
    {
        $datas = json_decode($this->data);
        if (!$datas) return [null,null,null];
        return end($datas);
    }

    public function getPresetWaterWeightAttribute()
    {
        return $this->bean_weight * $this->water_ratio;
    }

    public function getRealWaterRatioAttribute()
    {
        $datas = json_decode($this->data);
        if (!$datas) return 0;

        $last = end($datas);

        return $last[1] ? $last[1] / $this->bean_weight : $last[2] / $this->bean_weight;
    }
}
