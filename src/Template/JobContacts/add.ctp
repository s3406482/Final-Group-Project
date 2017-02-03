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
<div class="jobContacts form large-9 medium-8 columns content">
    <?= $this->Form->create($jobContact) ?>
    <fieldset>
        <legend><?= __('Add Job Contact') ?></legend>
        <?php
            echo $this->Form->input('job_id', ['options' => $jobs]);
            echo $this->Form->input('email');
            echo $this->Form->input('phone');
            echo $this->Form->input('fax');
            echo $this->Form->input('contact_name');
            echo $this->Form->input('address');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
