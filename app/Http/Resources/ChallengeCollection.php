<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ChallengeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data = $this->collection->map(function($practice, $index){
            return [
                'score' => $practice->score,
                'avatar' => $practice->user->wx_user->avatar_url,
                'nickname' => $practice->user->wx_user->nickname
            ];
        });

        return [
            'status' => 'success',
            'data' => $data,
        ];
    }
}
