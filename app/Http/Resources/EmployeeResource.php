<?php

namespace App\Http\Resources;

use App\Models\Education;
use App\Models\Position;
use App\Models\Rank;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'employee_number' => $this->employee_number,
            'name' => $this->name,
            'gender' => $this->gender,
            'address' => $this->address,
            'phone' => $this->phone,
            'effective_date' => $this->effective_date,
            'tanggal_mulai_kerja' => Carbon::parse($this->effective_date)->isoFormat('D MMMM YYYY'),
            'position_id' => PositionResource::collection(Position::where('id', $this->position_id)->get()),
            'rank_id' => RankResource::collection(Rank::where('id', $this->rank_id)->get()),
            'employee_status' => $this->employee_status,
            'blood_group' => $this->blood_group,
            'education_id' => EducationResource::collection(Education::where('id', $this->education_id)->get()),
            'created_at' => Carbon::parse($this->created_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
            'updated_at' => Carbon::parse($this->updated_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
        ];
    }
}
