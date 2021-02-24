<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Users;

class SystemUsersSaveRequest extends Request {

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
		switch (strtolower($this->method)) {
			case "post":
				return [
					"is_admin" 		=> "required|boolean",
					"email" 		=> "required|email|unique:system_users,email",
					"phone" 		=> "required_if:is_admin,0|regex:/^\([0-9]{3}\) [0-9]{3}\-[0-9]{4}$/i",
					"password" 		=> "required|min:6",
				];
			case "put":
				return [
					"id"			=> "required|exists:system_users,id",
					"is_admin" 		=> "required|boolean",
					"email" 		=> "required|email|unique:system_users,email,".$this->request->get("id"),
					"phone" 		=> "required_if:is_admin,0|regex:/^\([0-9]{3}\) [0-9]{3}\-[0-9]{4}$/i",
					"password" 		=> "min:6",
				];
		}

	}
        
	public function attributes()
	{
		return[
			"is_admin"     	=> "Флаг администратора",
			"email"      	=> "Email",
			"phone"      	=> "Телефон",
			"password"      => "Пароль",
		];
	}

}
