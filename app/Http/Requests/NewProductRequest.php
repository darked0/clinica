<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//use Illuminate\Validation\Rule;

// Aggiunti per response JSON
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class NewProductRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        // Nella form non mettiamo restrizioni d'uso su base utente
        // Gestiamo l'autorizzazione ad un altro livello
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'name' => 'required|max:25',
            'catId' => 'required',
            'descShort' => 'required|max:30',
            'image' => 'file|mimes:jpeg,png|max:1024',
            'price' => 'required|numeric|min:0',
            'discountPerc' => 'required|integer|min:0|max:100',
            'discounted' => 'required',
            'descLong' => 'required|max:2500'
        ];
    }

        /**
     * Override: response in formato JSON
    */
    protected function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(response($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }

}
