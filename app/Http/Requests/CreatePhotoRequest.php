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
            'group_id'      => 'required',
            'consent_id'    => 'required',
            'label'         => 'required|bail|string',
            'origen'        => 'required|bail|image',
        ];
    }

    public function attributes()
    {
        return [
            'group_id'      => 'grupo',
            'consent_id'    => 'ámbito legal',
            'label'         => 'etiqueta',
            'origen'        => 'imágen'
        ];
    }

}
