<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'body' => $this->body,
            'user_name' => $this->user->name,
            'user_avatar' => 'https://avatars0.githubusercontent.com/u/33205904?s=400&u=388b4a2754a037d598d2bec4e42a7da102427768&v=4'
        ];
    }
}
