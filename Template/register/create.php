<div class="form-login">
    <div class="page-header">
        <h2><?= t('Sign up') ?></h2>
    </div>
    <form method="post" action="<?= $this->url->href('Register', 'save', array('plugin' => 'Registration')) ?>" autocomplete="off">

        <?= $this->form->csrf() ?>

        <?= $this->form->label(t('Username'), 'username') ?>
        <?= $this->form->text('username', $values, $errors, array('autofocus', 'required', 'maxlength="50"')) ?>

        <?= $this->form->label(t('Name'), 'name') ?>
        <?= $this->form->text('name', $values, $errors) ?>

        <?= $this->form->label(t('Email'), 'email') ?>
        <?= $this->form->email('email', $values, $errors, array('required')) ?>

        <?= $this->form->label(t('Password'), 'password') ?>
        <?= $this->form->password('password', $values, $errors, array('required')) ?>

        <?= $this->form->label(t('Confirmation'), 'confirmation') ?>
        <?= $this->form->password('confirmation', $values, $errors, array('required')) ?>

        <?= $this->form->label(t('Timezone'), 'timezone') ?>
        <?= $this->form->select('timezone', $timezones, $values, $errors) ?>

        <?= $this->form->label(t('Language'), 'language') ?>
        <?= $this->form->select('language', $languages, $values, $errors) ?>

        <?= $this->form->checkbox('notifications_enabled', t('Enable email notifications'), 1, isset($values['notifications_enabled']) && $values['notifications_enabled'] == 1 ? true : false) ?>

        <div class="form-actions">
            <input type="submit" value="<?= t('Send email verification') ?>" class="btn btn-blue">
        </div>
    </form>
</div>