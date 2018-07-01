<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class CreateLocationRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        return Auth::user()->checkRole('super');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'name'          => 'required|bail|alpha_num|unique:locations,name',
            'accountable'   => 'required|bail|string',
            'CIF'           => 'required|bail|string',
            'email'         => 'required|bail|email',
            'address'       => 'required|bail|string',
            'city'          => 'required|bail|string',
            'CP'            => 'required|bail|numeric',
		];
	}

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'accountable' => 'responsable',
            'CIF' => 'cif',
            'email'=>'email',
            'address'=>'dirección',
            'city'=>'ciudad',
            'CP'=>'código postal'

        ];
    }


}
