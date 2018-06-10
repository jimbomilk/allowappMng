<?php namespace App\Http\Requests;



class EditUserRequest extends Request {


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
            'name'      => 'required',
            'email'     => 'required|unique:users,email,'.$this->user, //busca en la tabla users el campo email pero excluyendo el del propio usuario.
            'password'  => 'required'
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
