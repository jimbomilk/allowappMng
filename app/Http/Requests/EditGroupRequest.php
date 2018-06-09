<?php namespace App\Http\Requests;



class EditGroupRequest extends Request {


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

        ];
    }
    public function attributes()
    {
        return [
            'name' => 'clase',
        ];
    }
}
