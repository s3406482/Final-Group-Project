<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
        <?php 
            if (!is_null($this->request->Session()->read('Auth.User.id'))) {
                echo '<li>' . $this->Html->link(__('New Job'), ['action' => 'add']) . '</li>';
                echo '<li>' . $this->Html->link(__('My Jobs'), ['action' => 'myJobs']) . '</li>';
                echo '<li>' . $this->Html->link(__('Recommended Jobs'), ['action' => 'recommendedJobs']) . '</li>';
            }
        ?>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="jobs form index large-9 medium-8 columns content">
    <h3><?= __('Search Jobs') ?></h3>
    <?php
        echo $this->Html->link(
            $this->Html->div(['help-icon', 'right', 'text-center'], '?'), [
                'controller' => 'Help',
                'action' => 'searchJobs'
            ], [
                'escape' => false,
                'target' => '_blank'
            ]
        );
    ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Select Skill') ?></legend>
        <?php
            echo $this->Form->input('skill', ['options' => $skills]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
    
    <?php
        if ($resultsFound === FALSE)
            echo '<p>No Results Found</p>';
    ?>
    
    <?php if (!empty($jobs)): ?>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col" class="show-for-large-up"><?= $this->Paginator->sort('description') ?></th>
                <th scope="col"><?= $this->Paginator->sort('employer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date_closed') ?></th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobs as $job): ?>
            <tr>
                <td><?= $this->Html->link($job->title, ['action' => 'view', $job->id]) ?></td>
                <td class="show-for-large-up"><?= substr(h($job->description),0,150) ?></td>
                <td><?= $job->has('employer') ? $this->Html->link($job->employer->business_name, ['controller' => 'Employers', 'action' => 'view', $job->employer->id]) : '' ?></td>
                <td><?= h($job->date_closed->format('j F Y')) ?></td>
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
    <?php endif; ?>
</div>
