<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarketplaceRequest extends FormRequest
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
            'discord_id' => ['string'],
            'name' => ['string'],
            'member' => ['uuid', 'exists:App\Models\Member,external_id'],
            'last_status' => ['string',],
            'tags' => ['string',],
        ];
    }
}
