<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreatePhotoRequest extends Request {

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
            'label'      => 'required|bail|alpha_dash',
            'origen'      => 'required|bail|image',
        ];
    }

    public function attributes()
    {
        return [
            'label' => 'etiqueta',
            'origen' => 'imágen'
        ];
    }

}
