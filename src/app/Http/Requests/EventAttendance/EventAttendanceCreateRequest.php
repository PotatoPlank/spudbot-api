<?php

namespace App\Http\Requests\EventAttendance;

class EventAttendanceCreateRequest extends EventAttendanceRequest
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
            'member' => ['required', 'uuid', 'exists:App\Models\Member,external_id'],
            'status' => ['string', 'required'],
            'no_show' => ['boolean', 'required'],
        ];
    }
}
