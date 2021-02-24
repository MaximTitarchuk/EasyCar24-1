<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Users;

class UsersBalanceRequest extends Request {

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
                "id"        => "required|exists:users,id",
				"balance"	=> "required|integer|max:15000"
            ];
            
            return $rules;
	}
        
        public function attributes()
        {
            return[
                "id"     	=> "ID записи",
				"balance"	=> "Баланс"
            ];
        }

}
