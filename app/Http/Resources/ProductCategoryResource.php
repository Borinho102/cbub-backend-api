<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'image' => $this->image,
            'description' => $this->whenHas('description'),
            'tags' => $this->whenHas('tags'),
            'parent' => $this->whenLoaded('parent', fn () => $this::make($this->parent)),
            'children' => $this->whenLoaded('children', fn () => $this::collection($this->children)),
        ];
    }
}
