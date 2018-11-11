<?php namespace DreamConfig\FrontUser;

use App;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use Illuminate\Foundation\AliasLoader;
//use October\Rain\Auth\Manager;
use Auth;


class Plugin extends PluginBase
{

	public function register()
    {
        $alias = AliasLoader::getInstance();
        $alias->alias('Auth', 'DreamConfig\FrontUser\Facades\Auth');

        App::singleton('user.auth', function() {
            return \DreamConfig\FrontUser\Classes\AuthManager::instance();
        });

    }

    public function registerComponents()
    {
    	return ['DreamConfig\FrontUser\Components\Account' => 'account'];
    }

    public function registerSettings()
    {
    }

    public function registerMailTemplates()
    {
        return [
            'dreamconfig.frontuser::mail.welcome'
        ];
    }

}
