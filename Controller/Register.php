<?php

namespace Kanboard\Plugin\Registration\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Notification\MailNotification;

/**
 * Register Controller
 *
 * @package  controller
 * @author   Frederic Guillot
 */
class Register extends BaseController
{
    /**
     * Activate user account
     *
     * @access public
     */
    public function activate()
    {
        $token = $this->request->getStringParam('token');
        $user_id = $this->request->getIntegerParam('user_id');

        if ($this->userMetadataModel->get($user_id, 'registration_token') === $token) {
            $this->userModel->update(array('id' => $user_id, 'is_active' => 1));
            $this->userMetadataModel->remove($user_id, 'registration_token');
        }

        $this->response->redirect($this->helper->url->to('auth', 'login'));
    }

    /**
     * Display the form to create a new user
     *
     * @access public
     * @param array $values
     * @param array $errors
     */
    public function create(array $values = array(), array $errors = array())
    {
        $this->response->html($this->helper->layout->app('Registration:register/create', array(
            'timezones' => $this->timezoneModel->getTimezones(true),
            'languages' => $this->languageModel->getLanguages(true),
            'errors' => $errors,
            'values' => $values,
            'title' => t('Sign up'),
            'no_layout' => true,
        )));
    }

    /**
     * Validate and save a new user
     *
     * @access public
     */
    public function save()
    {
        $values = $this->request->getValues();
        list($valid, $errors) = $this->registrationValidator->validateCreation($values);

        if ($valid) {
            $values['is_active'] = 0;
            $user_id = $this->userModel->create($values);

            if ($user_id !== false) {
                $this->postCreation($values, $user_id);
                return $this->response->redirect($this->helper->url->to('auth', 'login'));
            } else {
                $errors = array('username' => array(t('Unable to create your account')));
            }
        }

        return $this->create($values, $errors);
    }

    /**
     * Create token and send email
     *
     * @access private
     * @param  array   $values
     * @param  integer $user_id
     */
    private function postCreation(array $values, $user_id)
    {
        $token = $this->token->getToken();
        $this->userMetadataModel->save($user_id, array('registration_token' => $token));

        if (! empty($values['notifications_enabled'])) {
            $this->userNotificationTypeModel->saveSelectedTypes($user_id, array(MailNotification::TYPE));
        }

        $values['id'] = $user_id;

        $this->emailClient->send(
            $values['email'],
            $values['name'] ?: $values['username'],
            e('Email verification'),
            $this->template->render('Registration:email/verification', array('user' => $values, 'token' => $token))
        );
    }
}
