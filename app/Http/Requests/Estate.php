<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Estate extends FormRequest
{
    protected $action = 'create';

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
    public function rules(): array
    {
        $rules = [
            'estate.name' => 'required|string|min:6',
            'estate.url' => 'required|string|url',
            'estate.selector_all' => 'required|string',
            'estate.selector_name' => 'required|string',
            'estate.selector_each' => 'required|string',
            'estate.selector_photo' => 'required|string',
            'estate.selector_price' => 'required|string',
            'estate.selector_link'=> 'required|string',
            'estate.selector_description' => 'required|string'
        ];

        if ($this->action === 'edit') {
            $rules = array_merge($rules, ['estate.id' => 'required|exists:App\Models\House\Estate,id']);
        }

        return $rules;
    }

    /**
     * @return $this
     */
    public function actionIsCreate()
    {
        $this->action = 'create';
        return $this;
    }

    /**
     * @return $this
     */
    public function actionIsEdit()
    {
        $this->action = 'edit';
        return $this;
    }
}
