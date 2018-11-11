<?php namespace DreamConfig\FrontUser\Classes;

use October\Rain\Auth\Manager as RainAuthManager;

class AuthManager extends RainAuthManager
{
    protected static $instance;

    protected $sessionKey = 'user_auth';

    protected $userModel = 'DreamConfig\FrontUser\Models\User';


    public function authenticate(array $credentials, $remember = true)
    {
        $loginName = $this->createUserModel()->getLoginName();
        $loginCredentialKey = isset($credentials[$loginName]) ? $loginName : 'login';

        if (empty($credentials[$loginCredentialKey])) {
            throw new AuthException(sprintf('The "%s" attribute is required.', $loginCredentialKey));
        }

        if (empty($credentials['password'])) {
            throw new AuthException('The password attribute is required.');
        }

        if ($loginCredentialKey !== $loginName) {
            $credentials[$loginName] = $credentials[$loginCredentialKey];
            unset($credentials[$loginCredentialKey]);
        }

        try {
            $user = $this->findUserByCredentials($credentials);
        }
        catch (AuthException $ex) {
            throw $ex;
        }
        
        $user->clearResetPassword();
        $this->login($user, $remember);

        return $this->user;
    }

}
