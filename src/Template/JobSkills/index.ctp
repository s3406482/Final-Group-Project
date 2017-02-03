<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
        <li><?= $this->Html->link(__('New Job Skill'), ['action' => 'add']) ?></li>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="jobSkills index large-9 medium-8 columns content">
    <h3><?= __('Job Skills') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('skill_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('job_id') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobSkills as $jobSkill): ?>
            <tr>
                <td><?= $this->Html->link(__($this->Number->format($jobSkill->id)), ['action' => 'view', $jobSkill->id]) ?></td>
                <td><?= $this->Html->link($jobSkill->skill->name, ['controller' => 'Skills', 'action' => 'view', $jobSkill->skill->id]) ?></td>
                <td><?= $this->Html->link($jobSkill->job->title, ['controller' => 'Jobs', 'action' => 'view', $jobSkill->job->id]) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
