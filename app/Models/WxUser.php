<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class WxUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'open_id', 'nickname', 'gender', 'city', 'province', 'country', 'avatar_url', 'union_id'
    ];

    /**
     * RelationShips
     */

    /**
     * One weixin user belong to one user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
