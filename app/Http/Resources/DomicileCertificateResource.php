<?php

namespace App\Http\Resources;

use App\Models\CoverLetter;
use App\Models\DomicileCertificateHistory;
use App\Models\Resident;
use App\Models\User;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DomicileCertificateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'cover_letter_id'     => CoverLetterResource::collection(CoverLetter::where('id', $this->cover_letter_id)->get()),
            'request_number'      => $this->request_number,
            'user_id'             => UserResource::collection(User::where('id', $this->user_id)->get()),
            'resident_id'         => ResidentResource::collection(Resident::where('id', $this->resident_id)->get()),
            'name'                => $this->name,
            'resident_number'     => $this->resident_number,
            'place_of_birth'      => $this->place_of_birth,
            'date_of_birth'       => $this->date_of_birth,
            'gender'              => $this->gender,
            'marital_status'      => $this->marital_status,
            'religion'            => $this->religion,
            'work_id'             => WorkResource::collection(Work::where('id', $this->work_id)->get()),
            'address'             => $this->address,
            'validity_period'     => $this->validity_period,
            'cover_letter_number' => $this->cover_letter_number,
            'created_at' => Carbon::parse($this->created_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
            'updated_at' => Carbon::parse($this->updated_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
            'history' => DomicileCertificateHistory::where('certificate_id', $this->id)->with(['approver.employee', 'approver.employee.rank'])->get(),
            'resident' => Resident::where('resident_number', $this->resident_number)->with(['work'])->get()
        ];
    }
}
