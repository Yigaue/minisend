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
        $formatedDate = \Carbon\Carbon::parse($this->created_at)->format('d M');
        return [
            'id' => $this->id,
            'alias' => $this->alias,
            'from' => $this->from,
            'subject' => $this->subject,
            'content' => $this->content,
            'formated_date' => $formatedDate,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'attachments' => $this->attachments,
        ];
    }
}
