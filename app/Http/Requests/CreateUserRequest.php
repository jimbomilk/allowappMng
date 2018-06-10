<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateUserRequest extends Request {

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
            'name'      => 'required|bail|string',
            'email'     => 'required|bail|email|unique:users,email', //busca en la tabla users el campo email
            'phone'     => 'required|bail|numeric',
            'password'  => 'required',
		];
	}

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'phone' => 'teléfono',
        ];
    }

}
