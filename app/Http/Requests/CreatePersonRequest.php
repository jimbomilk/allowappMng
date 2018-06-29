<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreatePersonRequest extends Request {

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
		return [
            'group_id'      => 'required',
            'name'          => 'required|bail|string',
            'photo'         => 'required|bail|image',
            'phone'         => 'required_if:minor,0',
            'email'         => 'required_if:minor,0',
            'documentId'    => 'required_if:minor,0',
		];
	}


    public function attributes()
    {
        return [
            'name' => 'nombre',
            'photo' => 'foto',
            'phone' => 'teléfono',
            'group_id' => 'clase'

        ];
    }

    public function messages(){
        return ['required_if'          => 'El campo :attribute es obligatorio para mayores de 16 años.'];
    }

}
