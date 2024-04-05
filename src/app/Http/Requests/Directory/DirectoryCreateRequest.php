<?php

namespace App\Http\Requests\Directory;

class DirectoryCreateRequest extends DirectoryRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'directory_channel' => ['required', 'uuid', 'exists:App\Models\Channel,external_id'],
            'forum_channel' => ['required', 'uuid', 'exists:App\Models\Channel,external_id'],
        ];
    }
}
