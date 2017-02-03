<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
        <li><?= $this->Html->link(__('Edit Job Skill'), ['action' => 'edit', $jobSkill->id]) ?> </li>
        <li><?= $this->Html->link(__('List Job Skills'), ['action' => 'index']) ?> </li>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="jobSkills view large-9 medium-8 columns content">
    <h3><?= h($jobSkill->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Skill') ?></th>
            <td><?= $jobSkill->has('skill') ? $this->Html->link($jobSkill->skill->name, ['controller' => 'Skills', 'action' => 'view', $jobSkill->skill->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Job') ?></th>
            <td><?= $jobSkill->has('job') ? $this->Html->link($jobSkill->job->title, ['controller' => 'Jobs', 'action' => 'view', $jobSkill->job->id]) : '' ?></td>
        </tr>
    </table>
</div>
