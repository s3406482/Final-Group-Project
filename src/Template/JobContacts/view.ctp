<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
        <li><?= $this->Html->link(__('Back to Job'), ['controller' => 'Jobs', 'action' => 'view', $jobContact->job_id]) ?> </li>
        <li><?= $this->Html->link(__('Edit'), ['action' => 'edit', $jobContact->id]) ?></li>
        <li><?= $this->Form->postLink(__('Delete Job Contact'), ['action' => 'delete', $jobContact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $jobContact->id)]) ?> </li>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="jobContacts view large-9 medium-8 columns content">
    <h3><?= h($jobContact->contact_name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($jobContact->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Address') ?></th>
            <td><?= h($jobContact->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Phone') ?></th>
            <td><?= h($jobContact->phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fax') ?></th>
            <td><?= h($jobContact->fax) ?></td>
        </tr> 
    </table>
</div>
