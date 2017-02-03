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
    <h3><?= __('Edit Developer Help') ?></h3>
    <p>This page allows you to edit a developer profile linked to your account.</p>
    <p><strong>User: </strong> The user that this profile is linked to.<br /><br />
    <strong>Location: </strong> Your current location.<br /><br />
    <strong>Website: </strong> The URL of your website or e-portfolio.<br /><br /></p>
</div>
