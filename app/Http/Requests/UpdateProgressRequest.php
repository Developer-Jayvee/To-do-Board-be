<?php

namespace App\Http\Requests;

use App\Models\Categories;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProgressRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            "previous" => [
                'required',
                'integer',
                fn(string $attribute , int $value , Closure $fail) => $this->categoryChecker($attribute,$value,$fail)
            ],
            "next" => [
                'required',
                'integer',
                fn(string $attribute , int $value , Closure $fail) => $this->categoryChecker($attribute,$value,$fail)
            ]
        ];
    }
    /**
     * categoryChecker
     *
     * @param  mixed $attribute
     * @param  mixed $value
     * @param  mixed $fail
     * @return void
     */
    private function categoryChecker(string $attribute , int $value , Closure $fail)
    {
        $isCategoryExist = Categories::find($value);
        if(!$isCategoryExist){
            $fail("Invalid category");
        }
    }
}
