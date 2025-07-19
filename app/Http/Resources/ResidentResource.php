<?php

namespace App\Http\Resources;

use App\Models\Education;
use App\Models\FamilyCard;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResidentResource extends JsonResource
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
            'family_card_id' => FamilyCardResource::collection(FamilyCard::where('id', $this->family_card_id)->get()),
            'resident_name' => $this->resident_name,
            'resident_number' => $this->resident_number,
            'gender' => $this->gender,
            'place_of_birth' => $this->place_of_birth,
            'date_of_birth' => $this->date_of_birth,
            'religion' => $this->religion,
            'education_id' => EducationResource::collection(Education::where('id', $this->education_id)->get()),
            'work_id' => WorkResource::collection(Work::where('id', $this->work_id)->get()),
            'blood_group' => $this->blood_group,
            'marital_status' => $this->marital_status,
            'wedding_date' => $this->wedding_date,
            'relationship_status' => $this->relationship_status,
            'citizenship' => $this->citizenship,
            'paspor_number' => $this->paspor_number,
            'kitap_number' => $this->kitap_number,
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'phone_number' => $this->phone_number,
            'created_at' => Carbon::parse($this->created_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
            'updated_at' => Carbon::parse($this->updated_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
        ];
    }
}
