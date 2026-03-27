<?php

namespace App\Http\Requests;

use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketsRequest extends FormRequest
{
    use ResponseTrait;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'label_id' => [
                'required',
                // function(string $attribute , mixed $value , Closure $fail){

                // }
            ],
            'expiration_date' => 'date'
        ];
    }

    public function messages()
    {
        return [
            'expiration_date.date' => 'Invalid date and time format'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        $this->requestFailedResponse($validator);
    }

}
