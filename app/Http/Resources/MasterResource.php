<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'company' => $this->company,
            'itemtype' => $this->itemtype,
            'code' => $this->code,
            'label' => $this->label,
            'itemgroup' => $this->itemgroup,
            'itemunit' => $this->itemunit,
            'active' => $this->active,
        ];
    }
}
