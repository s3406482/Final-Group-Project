<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
        <li><?= $this->Html->link(__('Cancel Changes'), ['controller' => 'Jobs', 'action' => 'view', $jobSkill->job_id]) ?></li>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="jobSkills form large-9 medium-8 columns content">
    <?= $this->Form->create($jobSkill) ?>
    <fieldset>
        <legend><?= __('Edit Job Skill') ?></legend>
        <?php
            echo $this->Form->input('skill_id', ['options' => $skills]);
            echo $this->Form->input('job_id', ['options' => $jobs]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
