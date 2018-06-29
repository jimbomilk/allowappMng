<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateRightholderRequest extends Request {

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
            'person_id'  => 'required',
            'name'      => 'required|bail|string|',
            'phone'     => 'required|bail|numeric',
            'email'     => 'required|bail|email',
            'documentId' => 'required|bail|alpha_num',

        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre del tutor',
            'phone' => 'teléfono',
            'documentId' => 'documento de identidad',
            'person_id' => 'nombre del alumno'
        ];
    }

}
