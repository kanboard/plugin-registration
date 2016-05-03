<?php

namespace Kanboard\Plugin\Registration\Validator;

use SimpleValidator\Validator;
use SimpleValidator\Validators;
use Kanboard\Validator\UserValidator;

/**
 * Registration Validator
 *
 * @package  validator
 * @author   Frederic Guillot
 */
class RegistrationValidator extends UserValidator
{
    /**
     * Validate user creation
     *
     * @access public
     * @param  array   $values           Form values
     * @return array   $valid, $errors   [0] = Success or not, [1] = List of errors
     */
    public function validateCreation(array $values)
    {
        $domains = $this->config->get('registration_email_domain', '');

        $rules = array(
            new Validators\Required('username', t('The username is required')),
            new Validators\Required('email', t('The email is required')),
        );

        $v = new Validator($values, array_merge($rules, $this->commonValidationRules(), $this->commonPasswordValidationRules()));
        $result = $v->execute();
        $errors = $v->getErrors();

        if ($result && $domains !== '' && !$this->validateDomainRestriction($values, $domains)) {
            $result = false;
            $errors = array('email' => array(t('You are not allowed to register')));
        }

        return array(
            $result,
            $errors,
        );
    }

    /**
     * Validate domain restriction
     *
     * @access private
     * @param  array  $values
     * @param  string $domains
     * @return bool
     */
    private function validateDomainRestriction(array $values, $domains)
    {
        foreach (explode(',', $domains) as $domain) {
            $domain = trim($domain);

            if (strpos($values['email'], $domain) > 0) {
                return true;
            }
        }

        return false;
    }
}
