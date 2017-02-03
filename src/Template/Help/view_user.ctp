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
    <h3><?= __('View User Help') ?></h3>
    <p>This page shows a detailed view of any user profile. All public information is displayed, as well as the status of the account (active or administrator). Also listed are any employer and developer accounts currently linked to the user, as well as any job applications submitted by the user. This page can only be viewed by administrators.</p>
</div>
