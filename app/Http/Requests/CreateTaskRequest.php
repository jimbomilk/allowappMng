<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class CreateTaskRequest extends Request {

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
            'description'   => 'required|bail|string',
            'group_id'      => 'required',
            'priority'      => 'numeric|max:20|min:1'
		];
	}

    public function attributes()
    {
        return [
            'description'   => 'descripción',
            'group_id'      => 'grupo',
        ];
    }


}
