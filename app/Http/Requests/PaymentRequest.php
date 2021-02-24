<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PaymentRequest extends Request {

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
                "phone"         => "required|regex:/^[0-9]{10}$/i|exists:users,phone",
                "sum"           => "required|numeric|min:0.1|max:14999",
            ];
            
            return $rules;
	}

        public function messages() {
            return [
                'phone.required'        => 'Поле "Телефон" должно быть заполнено',
                'phone.regex'           => 'Поле "Телефон" заполненно некорректно',
		'phone.exist'		=> 'Пользователь с таким телефоном не зарегистрирован',
                'sum.required'          => 'Поле "Сумма" должно быть заполнено',
                'sum.integer'        	=> 'Поле "Сумма" должно быть числом',
                'sum.min'           	=> 'Поле "Сумма" должно быть больше 0 рублей',
                'sum.max'           	=> 'Поле "Сумма" не должно превышать 14999 рублей',
            ];
        }


}
