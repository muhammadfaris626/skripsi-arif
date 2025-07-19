<?php

namespace App\Http\Resources;

use App\Models\MarriageCertificateHistory;
use App\Models\User;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarriageCertificateResource extends JsonResource
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
            'request_number' => $this->request_number,
            'user_id' => UserResource::collection(User::where('id', $this->user_id)->get()),
            'name' => $this->name,
            'place_of_birth' => $this->place_of_birth,
            'date_of_birth' => $this->date_of_birth,
            'work_id' => WorkResource::collection(Work::where('id', $this->work_id)->get()),
            'couple_name' => $this->couple_name,
            'partner_address' => $this->partner_address,
            'guardian_name' => $this->guardian_name,
            'wedding_date' => $this->wedding_date,
            'name_of_the_chief' => $this->name_of_the_chief,
            'bride_price' => $this->bride_price,
            'witness_name' => $this->witness_name,
            'created_at' => Carbon::parse($this->created_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
            'updated_at' => Carbon::parse($this->updated_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
            'history' => MarriageCertificateHistory::where('certificate_id', $this->id)->with('approver')->get()
        ];
    }
}
