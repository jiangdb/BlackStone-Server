<?php

namespace App;

use App\Models\Work;
use App\Models\WxUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const PLATFORM_WEIXIN = 'wx_user';

    static public $support_platforms = [
        self::PLATFORM_WEIXIN => 'Wei Xin',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * RelationShips
     */

    /**
     * One user has one weixin user
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wx_user()
    {
        return $this->hasOne(WxUser::class);
    }

    /**
     * One user has many works
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function works()
    {
        return $this->hasMany(Work::class);
    }

    /**
     * Accessors functions
     */
    public function getDisplayPlatformsAttribute($value)
    {
        $platforms = collect(explode(';', $this->platforms));
        $display = $platforms->map(function($item, $key){
            if ($item) {
                return self::$support_platforms[$item];
            }
        });
        return $display->implode(',');
    }


    /**
     * Other public functions
     */
    public function hasPlatform($platform)
    {
        $platforms = collect(explode(';', $this->platforms));
        return $platforms->contains($platform);
    }

}
