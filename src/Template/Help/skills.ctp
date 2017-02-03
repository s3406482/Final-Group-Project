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
    <h3><?= __('Skills Help') ?></h3>
    <p>This page allows an administrator to view a list of all the skills currently in the skills pool. The list is sortable by name. Skills can be selected to view their dedicated page, from which a skill can be edited or removed from the system.</p>
</div>
