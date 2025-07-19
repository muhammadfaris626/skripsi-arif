<?php

namespace App\Http\Resources;

use App\Models\FamilyCard;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BirthCertificateResource extends JsonResource
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
            'gender' => $this->gender,
            'religion' => $this->religion,
            'place_of_birth' => $this->place_of_birth,
            'date_of_birth' => $this->date_of_birth,
            'time_of_birth' => $this->time_of_birth,
            'family_card_id' => FamilyCardResource::collection(FamilyCard::where('id', $this->family_card_id)->get()),
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'address' => $this->address,
            'child_from' => $this->child_from,
            'give_birth_in' => $this->give_birth_in,
            'birth_location' => $this->birth_location,
            'weight' => $this->weight,
            'birth_certificate' => $this->birth_certificate,
            'created_at' => Carbon::parse($this->created_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
            'updated_at' => Carbon::parse($this->updated_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
        ];
    }
}
