<?php

namespace cintran\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncidentesRequest extends FormRequest
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
        return [    'placa_id' => 'required|numeric',
                    'tipo' => 'required|numeric',
                    'resolvido' => 'nullable'
        ];
    }

    public function messages(){
        return [
            'required' => 'O :attribute é obrigatório',
            'numeric' => ':attribute precisa ser um número'

        ];
    }
}
