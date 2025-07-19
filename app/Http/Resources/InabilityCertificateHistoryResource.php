<?php

namespace App\Http\Resources;

use App\Models\CertificateCategory;
use App\Models\InabilityCertificate;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InabilityCertificateHistoryResource extends JsonResource
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
            'certificate_id' => new InabilityCertificateResource(InabilityCertificate::find($this->certificate_id)),
            'certificate_category_id' => CertificateCategoryResource::collection(CertificateCategory::where('id', $this->certificate_category_id)->get()),
            'step' => $this->step,
            'approver_id' => PositionResource::collection(Position::where('id', $this->approver_id)->get()),
            'status' => $this->status,
            'is_active' => $this->is_active,
            'description' => $this->description
        ];
    }
}
