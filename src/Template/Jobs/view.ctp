<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
        <li><?= $this->Html->link(__('Search Jobs'), ['action' => 'search']) ?></li>
        <?php 
            if (!is_null($this->request->Session()->read('Auth.User.id'))) {
                echo '<li>' . $this->Html->link(__('New Job'), ['action' => 'add']) . '</li>';
                echo '<li>' . $this->Html->link(__('My Jobs'), ['action' => 'myJobs']) . '</li>';
                echo '<li>' . $this->Html->link(__('Recommended Jobs'), ['action' => 'recommendedJobs']) . '</li>';
                echo '<li>' . $this->Html->link(__('Apply for Job'), ['controller' => 'Applications', 'action' => 'add', '?' => ['job' => $job->id]]) .'</li>';
            }
    
            if ($job->employer->user_id == $this->request->Session()->read('Auth.User.id') || $this->request->Session()->read('Auth.User.administrator')) {
                echo '<li>' . $this->Html->link(__('Edit Job'), ['action' => 'edit', $job->id]) . '</li>';
                echo '<li>' . $this->Form->postLink(__('Close Job'), ['action' => 'delete', $job->id], ['confirm' => __('Are you sure you want to delete # {0}?', $job->id)]) . '</li>';
                echo '<li>' . $this->Html->link(__('Add Contact'), ['controller' => 'JobContacts', 'action' => 'add', '?' => ['job' => $job->id]]) . '</li>';
                echo '<li>' . $this->Html->link(__('Add Skill'), ['controller' => 'JobSkills', 'action' => 'add', '?' => ['job' => $job->id]]) .'</li>';
            }
        ?>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="jobs view large-9 medium-8 columns content">
    <h3><?= ($job->title) ?></h3>
    <?php
        echo $this->Html->link(
            $this->Html->div(['help-icon', 'right', 'text-center'], '?'), [
                'controller' => 'Help',
                'action' => 'viewJob'
            ], [
                'escape' => false,
                'target' => '_blank'
            ]
        );
    ?>    
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($job->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Created') ?></th>
            <td><?= h($job->date_created->format('j F Y')) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date Closed') ?></th>
            <td><?= h($job->date_closed->format('j F Y')) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Applications') ?></h4>
        <?php if (!empty($applications)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Developer') ?></th>
                <th scope="col"><?= __('Date Created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($applications as $application): ?>
            <tr>
                <td><?= h($application->developer->name) ?></td>
                <td><?= h($application->date_created->format('j F Y')) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Applications', 'action' => 'view', $application->id]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Job Contacts') ?></h4>
        <?php if (!empty($job->job_contacts)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Contact Name') ?></th>
                <th scope="col"><?= __('Email') ?></th>
            </tr>
            <?php foreach ($job->job_contacts as $jobContacts): ?>
            <tr>
                <td><?= $this->Html->link($jobContacts->contact_name, ['controller' => 'JobContacts', 'action' => 'view', $jobContacts->id]) ?></td>
                <td><?= h($jobContacts->email) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Job Skills') ?></h4>
        <?php if (!empty($job->job_skills)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Skill') ?></th>
                <?php if($job->employer->user_id == $this->request->Session()->read('Auth.User.id') || $this->request->Session()->read('Auth.User.administrator')): ?>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                <?php endif; ?>
            </tr>
            <?php foreach ($job->job_skills as $jobSkills): ?>
            <tr>
                <td><?= h($skills[$jobSkills->skill_id]) ?></td>
                <?php if($job->employer->user_id == $this->request->Session()->read('Auth.User.id') || $this->request->Session()->read('Auth.User.administrator')): ?>
                    <td class="actions">
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'JobSkills', 'action' => 'delete', $jobSkills->id], ['confirm' => __('Are you sure you want to delete # {0}?', $jobSkills->id)]) ?>
                    </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
