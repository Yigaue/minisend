<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmailResource extends JsonResource
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
            'id' => $this->id,
            'alias' => $this->alias,
            'subject' => $this->subject,
            'text_content' => $this->text_content,
            'create_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'attachments' => $this->attachments
        ];
    }
}
