<?php

namespace App\Http\Requests;

use App\Http\Controllers\CrudController;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $instance = new CrudController::$available_models[$this->route('model')]();
        return $instance->store_rules;
    }
}
