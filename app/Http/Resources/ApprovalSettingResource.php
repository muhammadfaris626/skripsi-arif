<?php

namespace App\Http\Resources;

use App\Models\CertificateCategory;
use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalSettingResource extends JsonResource
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
            'certificate_category_id' => CertificateCategoryResource::collection(CertificateCategory::where('id', $this->certificate_category_id)->get()),
            'position_id' => PositionResource::collection(Position::where('id', $this->position_id)->get()),
            'step' => $this->step,
            'approver_1' => PositionResource::collection(Position::where('id', $this->approver_1)->get()),
            'approver_2' => PositionResource::collection(Position::where('id', $this->approver_2)->get()),
            'approver_3' => PositionResource::collection(Position::where('id', $this->approver_3)->get()),
            'approver_4' => PositionResource::collection(Position::where('id', $this->approver_4)->get()),
            'approver_5' => PositionResource::collection(Position::where('id', $this->approver_5)->get()),
            'created_at' => Carbon::parse($this->created_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
            'updated_at' => Carbon::parse($this->updated_at)->isoFormat('D MMMM YYYY HH:mm:ss'),
        ];
    }
}
