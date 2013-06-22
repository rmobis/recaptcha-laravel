# Laravel Recaptcha

A reCAPTCHA library with out of the box Laravel integration. This is merely a wrap for [romainneutron/ReCaptcha][1], as to add Laravel integration, therefore, all methods present in the `Neutron/ReCaptcha\ReCaptcha` class are also available here.


## Installation

The best way to install the package is through Composer.

**composer.json**
```json
"require": {
	"rmobis/recaptcha": "0.1.*"
}
```

**app/config/app.php**
```php
// Providers
'Rmobis\Recaptcha\RecaptchaServiceProvider'
```
...
```php
// Aliases
'Recaptcha' => 'Rmobis\Recaptcha\Facade',
```


## Configuration

This is where you'll set up your public and private keys, as well as your [customization options][2]. To export the configuration file, do:

````
php artisan config:publish rmobis/recaptcha
````


## Features

### Laravelish Syntax

This allows you to use the Recaptcha class in the same way you use all Laravel classes, keeping your code shining and awesome. For instance, if you were to manually check if a given request was correctly made, this is how you'd do it.

````php
$challenge = Input::get('recaptcha_challenge_field');
$response = Input::get('recaptcha_response_field');

if (Recaptcha::check($challenge, $response)) {
    // reCAPTCHA verified
} else {
    // reCAPTCHA failed
}
````


### Validation Rule

This gives you a new validation rule, just like the other ones, which allows you to easily validate all your forms with reCAPTCHA. Simply add it to your validation rules array, and it'll do the magic.

````php
$validator = Validator::make(array(
	'recaptcha_response_field' => Input::all(),
	// ...
), array(
	'recaptcha_response_field' => 'recaptcha',
	// ...
));

if ($validator->passes()) {
	// reCAPTCHA verified
} else {
	// reCAPTCHA failed
}
````


### Form Macro

Gives you an easy way to quickly output all the code needed to output the reCAPTCHA widget. Optionally, you can pass an `$options` array, to override and extend the default options, set in the configuration file.

````php
Form::recaptcha(array('theme' => 'clean'))
````
Generates:
````html
<script type="text/javascript">
	var RecaptchaOptions = {"theme":"clean"};
</script>

<script type="text/javascript" src="//www.google.com/recaptcha/api/challenge?k=publicKeyHere"></script>

<noscript>
	<iframe src="//www.google.com/recaptcha/api/noscript?k=publicKeyHere" height="300" width="500" frameborder="0"></iframe><br>
	<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
	<input type="hidden" name="recaptcha_response_field" value="manual_challenge">
</noscript>
````

  [1]: https://github.com/romainneutron/ReCaptcha
  [2]: https://developers.google.com/recaptcha/docs/customization