<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:30'],
            'price' => ['required', 'numeric', 'min:1' ],
            'frequency' => ['required', 'numeric', 'min:1', 'max:12'],
            'first_payment_day' => ['required','date'],
            'url' => ['url', 'nullable'],
            'memo' => ['string','max:200', 'nullable']
        ];
    }
}
