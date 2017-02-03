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
    <h3><?= __('Applications Help') ?></h3>
    <p>This page lists all current job applications in the system, and is viewable by administrator accounts only. Select the name of the job to be taken to the details of the job, or select the developer to see the details of the person applying for the job. Selecting the view option shows full details of the application. This table is sortable by clicking on the column headers.</p>
</div>
