<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkProcedure extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time_in_ms', 'extract_weight', 'water_weight'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relationships
     */

    /**
     * Belong to work
     */
    public function work(){
        return $this->belongsTo(Work::class);
    }

}
