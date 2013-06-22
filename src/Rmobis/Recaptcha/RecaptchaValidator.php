<?php namespace Rmobis\Recaptcha;

use Rmobis\Recaptcha\Facade as Recaptcha;
use Illuminate\Validation\Validator;

class RecaptchaValidator extends Validator {

	public function validateRecaptcha($attribute, $value) {
		$data = $this->getData();

		return Recaptcha::check($data['recaptcha_challenge_field'], $value);
	}

}