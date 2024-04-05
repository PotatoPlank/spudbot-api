<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'guild' => ['uuid', 'exists:App\Models\Guild,external_id',],
            'channel' => ['string',],
            'native_id' => ['string',],
            'sesh_id' => ['string',],
            'guild_discord_id' => ['string',],
        ];
    }
}
