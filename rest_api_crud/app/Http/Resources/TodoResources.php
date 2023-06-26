<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Filtro de dados para repassar apenas as informações relevantes
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'done' => $this->done,
            'due_date' => $this->due_date
        ];
    }
}
