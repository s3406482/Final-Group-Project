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
    <h3><?= __('My Jobs Help') ?></h3>
    <p>This page displays a listing of all active jobs that are listed under employer accounts linked to your logged in user account. All columns are sortable alphabetically by selecing the column heading. Selecting the title of a job will take you to that job's page, or you can select an employer in order to go to that employer's page.</p>
</div>
