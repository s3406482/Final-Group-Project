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
    <h3><?= __('Edit User Help') ?></h3>
    <p>This page allows you to edit a user account's details. You must be logged into an administrator account to access this page. Usernames and passwords cannot be changed from this page.</p>
    <strong>Email: </strong> Your email address.<br /><br />
    <strong>First Name: </strong> Your first name.<br /><br />
    <strong>Last Name: </strong> Your surname.<br /><br />
    <strong>Phone: </strong> Your contact phone number.<br /><br />
    <strong>Active: </strong> If this box is ticked, the user is active. If unticked, they are archived.<br /><br />
    <strong>Administrator: </strong> If this box is ticked, the user account has administrator rights on the site.<br /><br /></p>
</div>
