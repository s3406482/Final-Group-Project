<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
        <li><?= $this->Html->link(__('Cancel Changes'), ['action' => 'view', $this->request->Session()->read('Auth.User.id')]); ?></li>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?php
        echo $this->Html->link(
            $this->Html->div(['help-icon', 'right', 'text-center'], '?'), [
                'controller' => 'Help',
                'action' => 'updatePassword'
            ], [
                'escape' => false,
                'target' => '_blank'
            ]
        );
    ?> 
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Update Password') ?></legend>
        <?php
            echo $this->Form->label('old-password', 'Old Password');
            echo $this->Form->password('old-password');
            echo $this->Form->label('new-password', 'New Password');
            echo $this->Form->password('new-password');
            echo $this->Form->label('confirm-new-password', 'Confirm New Password');
            echo $this->Form->password('confirm-new-password');      
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
