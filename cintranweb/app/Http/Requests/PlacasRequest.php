<?php

namespace cintran\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlacasRequest extends FormRequest
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
        return [    'id' => 'required|numeric',
                    'latitude' => 'max:50',
                    'longitude' => 'max:50',
                    'altura' => 'nullable|numeric',
                    'tempo_transmissao' => 'nullable|numeric',
                    'velocidade_via' => 'nullable|numeric',
                    'esquerda' => 'nullable|numeric',
                    'frente' => 'nullable|numeric',
                    'direita' => 'nullable|numeric'
        ];
    }

    public function messages(){
        return [
            'required' => 'O :attribute é obrigatório',
            'numeric' => ':attribute precisa ser um número'

        ];
    }

}
