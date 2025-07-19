<?php

namespace App\Http\Resources;

use App\Models\BusinessCertificateHistory;
use App\Models\CoverLetter;
use App\Models\Resident;
use App\Models\User;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessCertificateResource extends JsonResource
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
            'cover_letter_id' => CoverLetterResource::collection(CoverLetter::where('id', $this->cover_letter_id)->get()),
            'request_number' => $this->request_number,
            'user_id' => UserResource::collection(User::where('id', $this->user_id)->get()),
            'resident_id' => ResidentResource::collection(Resident::where('id', $this->resident_id)->get()),
            'name' => $this->name,
            'resident_number' => $this->resident_number,
            'place_of_birth' => $this->place_of_birth,
            'date_of_birth' => $this->date_of_birth,
            'religion' => $this->religion,
            'gender' => $this->gender,
            'work_id' => WorkResource::collection(Work::where('id', $this->work_id)->get()),
            'address' => $this->address,
            'business_name' => $this->business_name,
            'business_address' => $this->business_address,
            'long_term' => $this->long_term,
            'validity_period' => $this->validity_period,
            'description' => $this->description,
            'created_at' => Carbon::parse($this->created_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
            'updated_at' => Carbon::parse($this->updated_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
            'history' => BusinessCertificateHistory::where('certificate_id', $this->id)->with(['approver.employee', 'approver.employee.rank'])->get()
        ];
    }
}
