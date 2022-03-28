<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IncomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type_name' => $this->type_name,
            'type_expense' => $this->type_expense,
            //'user' => $this->user->name,
            'category' => $this->category->name,
            'amount' => $this->amount,
            //'bank_type' => $this->bank->name,
            'duration' => $this->duration,
            'date' => $this->date,
            'time' => $this->time,
            'Note' => $this->Note,
            'created_at' => $this->created_at,
        ];
    }
}
