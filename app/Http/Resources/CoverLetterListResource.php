<?php

namespace App\Http\Resources;

use App\Models\CoverLetter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoverLetterListResource extends JsonResource
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
            'certificate_id' => CoverLetterResource::collection(CoverLetter::where('id', $this->certificate_id)->get()),
            'file_name' => $this->file_name,
            'file_upload' => $this->file_upload
        ];
    }
}
