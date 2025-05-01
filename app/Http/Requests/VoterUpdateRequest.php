<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoterUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $voter = $this->route('voter');
        $userId = \App\Models\Voter::find($voter)?->user_id;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:8',
        ];
    }
}
