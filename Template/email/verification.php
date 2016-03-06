<p><?= t('Hello %s', $user['name'] ?: $user['username']) ?>,</p>
<p>
    <?= t('Click on this link to activate your account:') ?>
    <a href="<?= $this->url->href('Register', 'activate', array('plugin' => 'Registration', 'token' => $token, 'user_id' => $user['id']), false, '', true) ?>"><?= t('activate my account') ?></a>
</p>