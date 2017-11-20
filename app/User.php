<?php

namespace App;

use App\Models\WxUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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

}
