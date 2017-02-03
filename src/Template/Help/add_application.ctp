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
    <h3><?= __('Add Application Help') ?></h3>
    <p>This page allows you to apply for a viewed job. In order to apply, you must be logged in as a user with a developer account.</p>
    <p><strong>Job: </strong> Select the job that you wish to apply for.<br /><br />
    <strong>Developer: </strong> If you have multiple developer profiles against your account, allows you to select which one under which to apply for the job.<br /><br />
    <strong>Comments: </strong> Any relevant information to include for the employer.<br /><br /></p>
</div>
