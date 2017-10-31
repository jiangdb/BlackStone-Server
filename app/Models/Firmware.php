<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Firmware extends Model
{
    use SoftDeletes;

    protected $table = 'firmwares';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_number', 'version', 'version_code', 'path', 'md5'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public static function transVersionCode($version)
    {
        $v = explode('.',$version);
        $code = 0;
        foreach ($v as $item) {
            $code = $code*100 + intval($item);
        }
        return $code;
    }

}
