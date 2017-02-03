<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
        <li><?= $this->Html->link(__('Cancel Changes'), ['controller' => 'Developers', 'action' => 'view', $developerSkill->developer_id]) ?></li>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="developerSkills form large-9 medium-8 columns content">
    <?= $this->Form->create($developerSkill) ?>
    <fieldset>
        <legend><?= __('Edit Developer Skill') ?></legend>
        <?php
            echo $this->Form->input('developer_id', ['options' => $developers]);
            echo $this->Form->input('skill_id', ['options' => $skills]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
