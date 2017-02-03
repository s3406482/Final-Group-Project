<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Html->link(__('Change Password'), ['action' => 'updatepassword', $this->request->session()->read('Auth.User.id')]); ?></li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete: {0}?', $user->username)]) ?> </li>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->username) ?></h3>
    <?php
        echo $this->Html->link(
            $this->Html->div(['help-icon', 'right', 'text-center'], '?'), [
                'controller' => 'Help',
                'action' => 'viewUser'
            ], [
                'escape' => false,
                'target' => '_blank'
            ]
        );
    ?> 
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('First Name') ?></th>
            <td><?= h($user->first_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Name') ?></th>
            <td><?= h($user->last_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Phone') ?></th>
            <td><?= h($user->phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Joined') ?></th>
            <td><?= h($user->joined->format('j F Y')) ?></td>
        </tr>    
    </table>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Active') ?></th>
            <td><?= $user->active ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Administrator') ?></th>
            <td><?= $user->administrator ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Developers') ?></h4>
        <?php if (!empty($user->developers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Location') ?></th>
                <th scope="col"><?= __('Website') ?></th>
            </tr>
            <?php foreach ($user->developers as $developers): ?>
            <tr>
                <td>
                    <?= $this->Html->link($developers->name, ['controller' => 'Developers', 'action' => 'view', $developers->id]) ?>
                </td>
                <td><?= h($developers->location) ?></td>
                <td><?= $this->Html->link($developers->website, $developers->website, ['target' => '_blank']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Employers') ?></h4>
        <?php if (!empty($user->employers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Business Name') ?></th>
                <th scope="col"><?= __('Website') ?></th>
            </tr>
            <?php foreach ($user->employers as $employers): ?>
            <tr>
                <td><?= $this->Html->link($employers->business_name, ['controller' => 'Employers', 'action' => 'view', $employers->id]) ?></td>
                <td><?= $this->Html->link($employers->website, $employers->website, ['target' => '_Blank']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('My Job Applications') ?></h4>
        <?php if (!empty($applications)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Job Title') ?></th>
                <th scope="col"><?= __('Developer') ?></th>
                <th scope="col"><?= __('Date Applied') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($applications as $application): ?>
            <tr>
                <td><?= $this->Html->link($application->job->title, ['controller' => 'Jobs', 'action' => 'view', $application->job->id]) ?></td>
                <td><?= $this->Html->link($developerNames[$application->developer_id], ['controller' => 'Developers', 'action' => 'view', $application->developer_id]) ?></td>
                <td><?= h($application->date_created->format('j F Y')) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Applications', 'action' => 'view', $application->id]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
