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
            'name'      => 'required|alpha_dash',
            'email'     => 'email|required|unique:users,email', //busca en la tabla users el campo email
            'phone'  => 'numeric|required',
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
