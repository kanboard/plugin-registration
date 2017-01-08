<?php

namespace Kanboard\Plugin\Registration;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Security\Role;
use Kanboard\Core\Translator;

class Plugin extends Base
{
    public function initialize()
    {
        $this->applicationAccessMap->add('Register', '*', Role::APP_PUBLIC);
        $this->route->addRoute('/signup', 'Register', 'create', 'Registration');
        $this->route->addRoute('/signup/activate/:user_id/:token', 'Register', 'activate', 'Registration');

        $this->template->hook->attach('template:config:application', 'Registration:config/application');
        $this->template->hook->attach('template:auth:login-form:after', 'Registration:auth/login');
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getClasses()
    {
        return array(
            'Plugin\Registration\Validator' => array('RegistrationValidator'),
        );
    }

    public function getPluginName()
    {
        return 'Self-Registration';
    }

    public function getPluginDescription()
    {
        return t('Allow people to sign up themselves on Kanboard');
    }

    public function getPluginAuthor()
    {
        return 'Frédéric Guillot';
    }

    public function getPluginVersion()
    {
        return '1.0.6';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-registration';
    }

    public function getCompatibleVersion()
    {
        return '>=1.0.37';
    }
}
