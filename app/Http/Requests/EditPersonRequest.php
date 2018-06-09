<?php namespace App\Http\Requests;



class EditPersonRequest extends Request {


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
            'name'      => 'required|bail|alpha_dash',
            'photo'      => 'required',
            'email'     => 'required_if:minor,0',
            'documentId'     => 'required_if:minor,0'
        ];
    }


    public function attributes()
    {
        return [
            'name' => 'nombre',
            'photo' => 'foto',

        ];
    }

    public function messages(){
        return ['required_if'          => 'El campo :attribute es obligatorio para mayores de 16 años.'];
    }

}
