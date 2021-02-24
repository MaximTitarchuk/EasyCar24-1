<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class SpecialsSaveRequest extends Request {

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
					"date_from" 	=> "required|date|date_format:d.m.Y H:i:s",
					"date_to" 		=> "required|date|date_format:d.m.Y H:i:s|after:date_from",
					"sum_from" 		=> "required|integer|min:1|max:15000",
					"sum_to" 		=> "required|integer|min:1|max:15000",
					"percent"		=> "required|integer|min:1|max:100",
					"content"		=> "required|string|max:65536",
				];
			case "put":
				return [
					"id"			=> "required|exists:specials,id",
					"date_from" 	=> "required|date|date_format:d.m.Y H:i:s",
					"date_to" 		=> "required|date|date_format:d.m.Y H:i:s|after:date_from",
					"sum_from" 		=> "required|integer|min:1|max:15000",
					"sum_to" 		=> "required|integer|min:1|max:15000",
					"percent"		=> "required|integer|min:1|max:100",
					"content"		=> "required|string|max:65536",
				];
		}

	}
        
	public function attributes()
	{
		return[
			"id" 			=> "ID акции",
			"date_from" 	=> "Начало диапазона",
			"date_to" 		=> "Окончание диапазона",
			"sum_from" 		=> "От суммы",
			"sum_to"		=> "До суммы",
			"percent"		=> "Процент",
			"content"		=> "Описание"
		];
	}

}
