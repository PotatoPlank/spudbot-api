<?php

namespace App\Http\Requests\EventAttendance;

use Illuminate\Foundation\Http\FormRequest;

class EventAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'member' => ['uuid', 'exists:App\Models\Member,external_id',],
            'status' => ['string',],
            'no_show' => ['boolean',],
        ];
    }
}
