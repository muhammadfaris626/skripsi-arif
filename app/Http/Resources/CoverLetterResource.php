<?php

namespace App\Http\Resources;

use App\Models\CertificateCategory;
use App\Models\CoverLetterHistory;
use App\Models\Resident;
use App\Models\User;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoverLetterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                      => $this->id,
            'request_number'          => $this->request_number,
            'resident_id'             => ResidentResource::collection(Resident::where('id', $this->resident_id)->get()),
            'user_id'                 => UserResource::collection(User::where('id', $this->user_id)->get()),
            'name'                    => $this->name,
            'place_of_birth'          => $this->place_of_birth,
            'date_of_birth'           => $this->date_of_birth,
            'gender'                  => $this->gender,
            'religion'                => $this->religion,
            'work_id'                 => WorkResource::collection(Work::where('id', $this->work_id)->get()),
            'address'                 => $this->address,
            'resident_number'         => $this->resident_number,
            'family_number'           => $this->family_number,
            'certificate_category_id' => CertificateCategoryResource::collection(CertificateCategory::where('id', $this->certificate_category_id)->get()),
            'status'                  => $this->status,
            'created_at'              => Carbon::parse($this->created_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
            'updated_at'              => Carbon::parse($this->updated_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
            'history'                 => CoverLetterHistory::where('certificate_id', $this->id)->with(['approver.employee', 'approver.employee.rank'])->get()
        ];
    }
}
