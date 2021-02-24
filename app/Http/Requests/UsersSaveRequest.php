<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Users;

class UsersSaveRequest extends Request {

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
					"is_active" 	=> "required|boolean",
					"name" 			=> "string|max:255",
					"email" 		=> "email",
					"phone" 		=> "required|regex:/^\([0-9]{3}\) [0-9]{3}\-[0-9]{4}$/i",
					"system_user_id"=> "exists:system_users,id"
				];
			case "put":
				return [
					"id"			=> "required|exists:users,id",
					"is_active" 	=> "required|boolean",
					"name" 			=> "string|max:255",
					"email" 		=> "email",
					"phone" 		=> "required|regex:/^\([0-9]{3}\) [0-9]{3}\-[0-9]{4}$/i",
					"system_user_id"=> "exists:system_users,id"
				];
		}

	}
        
	public function attributes()
	{
		return[
			"is_active" 	=> "Активность",
			"name" 			=> "Имя",
			"email" 		=> "Email",
			"phone" 		=> "Телефон",
			"system_user_id"=> "Промоутер",
		];
	}

}
