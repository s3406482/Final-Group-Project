<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Users') ?></h3>
    <?php
        echo $this->Html->link(
            $this->Html->div(['help-icon', 'right', 'text-center'], '?'), [
                'controller' => 'Help',
                'action' => 'users'
            ], [
                'escape' => false,
                'target' => '_blank'
            ]
        );
    ?> 
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('username') ?></th>
                <th class="show-for-large-up" scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th class="show-for-large-up" scope="col"><?= $this->Paginator->sort('joined') ?></th>
                <th scope="col"><?= $this->Paginator->sort('active') ?></th>
                <th scope="col"><?= $this->Paginator->sort('administrator') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Html->link($user->username, ['action' => 'view', $user->id]) ?></td>
                <td class="show-for-large-up"><?= h($user->email) ?></td>
                <td class="show-for-large-up"><?= h($user->joined->format('j F Y')) ?></td>
                <td>
                    <?php
                        if ($user->active == 1)
                            echo __('Yes');
                        else
                            echo __('No');
                    ?>
                </td>
                <td>
                    <?php 
                        if ($user->administrator == 1)
                            echo __('Yes');
                        else
                            echo __('No');
                    ?>
                </td>
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
