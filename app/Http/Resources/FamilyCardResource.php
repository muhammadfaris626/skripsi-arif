<?php

namespace App\Http\Resources;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyCardResource extends JsonResource
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
            'family_number' => $this->family_number,
            'name' => $this->name,
            'address' => $this->address,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'province_id' => ProvinceResource::collection(Province::where('id', $this->province_id)->get()),
            'regency_id' => RegencyResource::collection(Regency::where('id', $this->regency_id)->get()),
            'district_id' => DistrictResource::collection(District::where('id', $this->district_id)->get()),
            'village_id' => VillageResource::collection(Village::where('id', $this->village_id)->get()),
            'postal_code' => $this->postal_code,
            'created_at' => Carbon::parse($this->created_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
            'updated_at' => Carbon::parse($this->updated_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
        ];
    }
}
