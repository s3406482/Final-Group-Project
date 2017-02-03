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
<div class="applications form large-9 medium-8 columns content">
    <?php
        echo $this->Html->link(
            $this->Html->div(['help-icon', 'right', 'text-center'], '?'), [
                'controller' => 'Help',
                'action' => 'addApplication'
            ], [
                'escape' => false,
                'target' => '_blank'
            ]
        );
    ?> 
    <?= $this->Form->create($application) ?>
    <fieldset>
        <legend><?= __('Add Application') ?></legend>
        <?php
            echo $this->Form->input('job_id', ['options' => $jobs]);
            echo $this->Form->input('developer_id', ['options' => $developers]);
            echo $this->Form->input('comments');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
