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
    <h3><?= __('Add User Help') ?></h3>
    <p>This page allows the viewer to create a new account on Dev#. Once a user account is created it is a generic user, which then needs to have either a developer or employer profile created under it.</p>
    <p><strong>Username: </strong> This will be your unique username used on the site.<br /><br />
    <strong>Password: </strong> Your password. The stronger the better!<br /><br />
    <strong>Email: </strong> Your email address.<br /><br />
    <strong>First Name: </strong> Your first name.<br /><br />
    <strong>Last Name: </strong> Your surname.<br /><br />
    <strong>Phone: </strong> Your contact phone number.<br /><br /></p>
</div>
