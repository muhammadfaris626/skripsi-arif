<?php

namespace App\Http\Resources;

use App\Models\Regency;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
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
            'regency_id' => RegencyResource::collection(Regency::where('id', $this->regency_id)->get()),
            'name' => $this->name,
            'created_at' => Carbon::parse($this->created_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
            'updated_at' => Carbon::parse($this->updated_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
        ];
    }
}
