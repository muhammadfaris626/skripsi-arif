<?php

namespace App\Http\Resources;

use App\Models\BusinessCertificate;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessCertificateHistoryResource extends JsonResource
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
            'certificate_id' => new BusinessCertificateResource(BusinessCertificate::find($this->certificate_id)),
            'approval_category' => $this->approval_category,
            'step' => $this->step,
            // 'approver_id' => EmployeeResource::collection(Employee::where('id', $this->approver_id)->get()),
            'status' => $this->status,
            'is_active' => $this->is_active
        ];
    }
}
