<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DrinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {

        return [
            "id" => $this->id,
            "drink" => $this->drink,
            "amount" => $this->amount,
            "price" => $this->price,
            "type" => $this->type->type,
            "package" => $this->package->package
        ];
    }
}
