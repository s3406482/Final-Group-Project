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
    <h3><?= __('View Job Help') ?></h3>
    <p>This is the main listing page for a job. It will display the job's title and in-depth description as defined by the creator, as well as the required skillsets, contact persons, and active applications for the job.<br >
    Owners of the job can add and remove contacts and skill requirements from the panel on the left.</p>
</div>
