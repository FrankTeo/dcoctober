<?php

namespace DreamConfig\FrontUser\Components;

use Lang;
use Auth;
use Mail;
use Event;
use Flash;
use Input;
use Request;
use Redirect;
use Validator;
use ValidationException;
use ApplicationException;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Exception;
use DreamConfig\FrontUser\Models\User as UserModel;
use Session;

class Account extends ComponentBase
{
	public function componentDetails()
    {
        return [
            'name' => 'frontuser Account',
            'description' => 'include function of login register logout mail-send & information-change'
        ];
    }

    public function onLogout()
    {

        $this->unsetUserSession();

        return \Redirect::to('/');
    }
 
	public function onLogin()
    {
        try {
            $data = post();
            $rules = [];

            if (!array_key_exists('login', $data)) {
                $data['login'] = post('email');
            }

            $credentials = [
                'login'    => array_get($data, 'login'),
                'password' => array_get($data, 'password')
            ];

            $user = Auth::authenticate($credentials, true);

            if (!$user) {
                Auth::logout();
                throw new Exception(sprintf("user %s does not login successfully!", $user->email));
            }

            $this->userSession($user);

            return \Redirect::to('/');
        }
        catch (Exception $ex) {
            if (Request::ajax()) throw $ex;
            else Flash::error($ex->getMessage());
        }
    }
    
    public function onRegister()
    {
        try {
            
            $data = post();
            $rules = [
                'email'    => 'required|email|between:6,50|unique:dreamconfig_frontuser_users,email',
                'password' => 'required|between:4,20|confirmed'
            ];


            $validation = Validator::make($data, $rules);
            if ($validation->fails()) {
                throw new ValidationException($validation);
            }
           
            $user = Auth::register($data, true, true);

            $this->sendConfirmationEmail($user);

            Auth::login($user);

            $this->userSession($user);
            return \Redirect::to('/');
        }
        catch (Exception $ex) {
            if (Request::ajax()) throw $ex;
            else Flash::error($ex->getMessage());
        }
    }

    protected function sendConfirmationEmail($user)
    {
       
        $data = [
            'name' => $user->name ?? 'there'
        ];

        Mail::send('dreamconfig.frontuser::mail.welcome', $data, function($message) use ($user) {
            $message->to($user->email, $user->name);
        });
    }


    public function userSession($user)
    {
        Session::put('user', $user->email);
    }

    public function unsetUserSession()
    {
        Session::forget('user');
    }

    public function onUpdate()
    {
        $email = array_get(post(), 'email');
        if (!$user = Auth::findUserByLogin($email)) {
            return;
        }

        $user->fill(post());
        $user->save();

        return \Redirect::to('/');
    }

    public function user()
    {
        if (!Auth::check()) {
            return null;
        }

        return Auth::getUser();
    }
  
}
