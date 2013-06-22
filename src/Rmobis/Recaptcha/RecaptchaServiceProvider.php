<?php namespace Rmobis\Recaptcha;

use Neutron\ReCaptcha\ReCaptcha as NeutronRecaptcha;
use Rmobis\Recaptcha\Facade as Recaptcha;
use Illuminate\Support\ServiceProvider;

class RecaptchaServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot() {
		$this->package('rmobis/recaptcha');

		$this->registerRecaptcha();
		$this->registerFormMacro();
		$this->registerValidator();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() { }

	/**
     * Register the Recaptcha Facade
	 *
	 * @return void
	 */
	public function registerRecaptcha() {
		$this->app['recaptcha'] = $this->app->share(function ($app) {
			$config = $app['config'];

			return NeutronRecaptcha::create($config->get('recaptcha::public_key'), $config->get('recaptcha::private_key'));
		});
	}

	/**
     * Register the form macro
	 *
	 * @return void
	 */
	public function registerFormMacro() {
		$app = $this->app;

		$app['form']->macro('recaptcha', function ($options = array()) use ($app) {
			$config = $app['config'];

			$viewData = array(
				'public_key' => $config->get('recaptcha::public_key'),
				'options'    => array_merge($options, $config->get('recaptcha::options')),
			);

			return $app['view']->make('recaptcha::recaptcha', $viewData);
		});
	}

	/**
     * Register the validation recaptcha rule
	 *
	 * @return void
	 */
	public function registerValidator() {
		$validator = $this->app['validator'];

		$validator->resolver(function ($attribute, $value, $parameters, $messages) {
			return new RecaptchaValidator($attribute, $value, $parameters, $messages);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
		return array();
	}

}