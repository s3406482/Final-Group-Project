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
    <h3><?= __('Add Developer Help') ?></h3>
    <p>This page allows you to add a developer profile to your account. You must be logged in to do this.</p>
    <p><strong>User: </strong> The selected user account to which a developer profile is to be applied.<br /><br />
    <strong>Name: </strong> This field can be any moniker, usually either an online identifier or trading name if a sole trader. This value cannot be edited once the profile is saved.<br /><br />
    <strong>Location: </strong> Your current location.<br /><br />
    <strong>Website: </strong> The URL of your website or e-portfolio.<br /><br /></p>
</div>
