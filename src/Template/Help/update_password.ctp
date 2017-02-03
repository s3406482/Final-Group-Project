<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="help index large-9 medium-8 columns content">
    <h3><?= __('Update Password Help') ?></h3>
    <p>This page can be used to update the password of a user account.</p>
    <strong>Current Password: </strong> The current password of the logged in account.<br /><br />
    <strong>New Password: </strong> The desired new password.<br /><br />
    <strong>Confirm New Password: </strong> Re-enter the new password to confirm.<br /><br /></p>
</div>
