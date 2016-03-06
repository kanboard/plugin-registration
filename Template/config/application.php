<?= $this->form->label(t('Email domain restriction for sign up'), 'registration_email_domain') ?>
<?= $this->form->text('registration_email_domain', $values, $errors, array('placeholder="mycompany.tld"')) ?>
<p class="form-help"><?= t('Only people with this email address will be allowed to sign up.') ?></p>