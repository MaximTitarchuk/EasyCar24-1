<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Users;

class SpecialsGetInfoRequest extends Request {

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
            $rules = [
                "id"         => "required|exists:specials,id",
            ];
            
            return $rules;
	}
        
        public function attributes()
        {
            return[
                "id"     	=> "ID записи",
            ];
        }

}
