Self-Registration Plugin
========================

[![Build Status](https://travis-ci.org/kanboard/plugin-registration.svg?branch=master)](https://travis-ci.org/kanboard/plugin-registration)

This plugin allow people to sign up to Kanboard.

- An email verification is necessary
- A domain restriction can be applied to avoid unwanted users

Author
------

- Frédéric Guillot
- License MIT

Requirements
------------

- Kanboard version >= 1.0.27
- Kanboard configured to send emails

Installation
------------

- Decompress the archive in the `plugins` folder

or

- Create a folder **plugins/Registration**
- Copy all files under this directory

Documentation
-------------

### Workflow

- From the login page a link to the sign up form is displayed
- The user fill the form and submit
- The user account is created but it's disabled
- The user have to validate his email address to enable the account

### Domain restriction

From the application settings, you can authorize only the domain name of your organization to avoid anybody to sign up.
