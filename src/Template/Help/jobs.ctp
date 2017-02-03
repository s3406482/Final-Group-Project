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
    <h3><?= __('Jobs Help') ?></h3>
    <p>This page provides a master list of all the active jobs in the system. You can sort the list alphabetically by any column simply by clicking on the column header. Clicking on a job title will take you to the job's page which shows you more information on the job, or you can select the employer's name to take you to the employer's page.</p>
</div>
