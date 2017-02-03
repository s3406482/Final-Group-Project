<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
        <li><?= $this->Html->link(__('New Job Contact'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Job'), ['controller' => 'Jobs', 'action' => 'add']) ?></li>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="jobContacts index large-9 medium-8 columns content">
    <h3><?= __('Job Contacts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('job_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fax') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contact_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jobContacts as $jobContact): ?>
            <tr>
                <td><?= $this->Html->link($jobContact->id, ['action' => 'view', $jobContact->id]) ?></td>
                <td><?= $jobContact->has('job') ? $this->Html->link($jobContact->job->title, ['controller' => 'Jobs', 'action' => 'view', $jobContact->job->id]) : '' ?></td>
                <td><?= h($jobContact->email) ?></td>
                <td><?= h($jobContact->phone) ?></td>
                <td><?= h($jobContact->fax) ?></td>
                <td><?= h($jobContact->contact_name) ?></td>
                <td><?= h($jobContact->address) ?></td>
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
