<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Users;

class SystemUsersRequest extends Request {

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
                "email"         => "required|email|max:255|unique:system_users,email".($this->route()->hasParameter("id")? ",".$this->route("id"): ""),
                "pass"          => "min:4|confirmed".(!$this->route()->hasParameter("id")? "|required": ""),
            ];
            
            return $rules;
	}
        
        public function attributes()
        {
            return[
                "email"     => "Email",
                "pass"      => "Пароль",
            ];
        }

}
