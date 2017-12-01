<?php

use Kanboard\Plugin\Registration\Validator\RegistrationValidator;

class RegistrationValidatorTest extends Base
{
    public function testWithoutDomainRestriction()
    {
        $validator = new RegistrationValidator($this->container);
        list($result,) = $validator->validateCreation(array(
            'username' => 'test',
            'email' => 'test@localhost',
            'password' => 'test123',
            'confirmation' => 'test123',
        ));

        $this->assertTrue($result);
    }

    public function testWithDomainRestriction()
    {
        $this->container['configModel']->save(array('registration_email_domain' => 'mydomain.tld'));
        $validator = new RegistrationValidator($this->container);

        list($result,) = $validator->validateCreation(array(
            'username' => 'test',
            'email' => 'test@localhost',
            'password' => 'test123',
            'confirmation' => 'test123',
        ));

        $this->assertFalse($result);

        list($result,) = $validator->validateCreation(array(
            'username' => 'test',
            'email' => 'test@mydomain.tld',
            'password' => 'test123',
            'confirmation' => 'test123',
        ));

        $this->assertTrue($result);

        list($result,) = $validator->validateCreation(array(
            'username' => 'test',
            'email' => 'test@mydomain.tld.example.org',
            'password' => 'test123',
            'confirmation' => 'test123',
        ));

        $this->assertFalse($result);

        list($result,) = $validator->validateCreation(array(
            'username' => 'test',
            'email' => 'test+mydomain.tld@example.org',
            'password' => 'test123',
            'confirmation' => 'test123',
        ));

        $this->assertFalse($result);
    }

    public function testWithMultipleDomainRestriction()
    {
        $this->container['configModel']->save(array('registration_email_domain' => 'domain1.tld, domain2.tld ,domain3.tld'));
        $validator = new RegistrationValidator($this->container);

        list($result,) = $validator->validateCreation(array(
            'username' => 'test',
            'email' => 'test@localhost',
            'password' => 'test123',
            'confirmation' => 'test123',
        ));

        $this->assertFalse($result);

        list($result,) = $validator->validateCreation(array(
            'username' => 'test',
            'email' => 'test@domain1.tld',
            'password' => 'test123',
            'confirmation' => 'test123',
        ));

        $this->assertTrue($result);

        list($result,) = $validator->validateCreation(array(
            'username' => 'test',
            'email' => 'test@domain2.tld',
            'password' => 'test123',
            'confirmation' => 'test123',
        ));

        $this->assertTrue($result);

        list($result,) = $validator->validateCreation(array(
            'username' => 'test',
            'email' => 'test@domain3.tld',
            'password' => 'test123',
            'confirmation' => 'test123',
        ));

        $this->assertTrue($result);
    }
}
