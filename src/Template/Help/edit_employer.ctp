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
    <h3><?= __('Edit Employer Help') ?></h3>
    <p>This page allows you to edit an exiting employer profile already linked to your account. You must be logged in to do this.</p>
    <p><strong>User: </strong> The selected user account to which an employer profile is to be applied.<br /><br />
    <strong> Business Name: </strong> The trading name of the business which is being represented.<br /><br />
    <strong>Address: </strong> The registered address of the business.<br /><br />
    <strong>Phone: </strong> The main contact phone number of the business.<br /><br />
    <strong>Fax: </strong> The fax number of the business, if applicable.<br /><br />
    <strong>Website: </strong> The URL of the business's official website.<br /><br /></p>
</div>
