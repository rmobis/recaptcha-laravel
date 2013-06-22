<?php namespace Rmobis\Recaptcha;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class Facade extends IlluminateFacade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'recaptcha'; }

    /**
     * Quick method to check answer, without having to pass the client's IP
     *
     * @param  string  $challenge
     * @param  string  $response
     * @return boolean
     */
    public static function check($challenge, $response) {
        return self::checkAnswer(app('request')->getClientIp(), $challenge, $response)->isValid();
    }

}