<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
        <li><?= $this->Html->link(__('New Developer'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('My Developers'), ['action' => 'my_developers']) ?></li>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="developers index large-9 medium-8 columns content">
    <h3><?= __('My Developers') ?></h3>
    <?php
        echo $this->Html->link(
            $this->Html->div(['help-icon', 'right', 'text-center'], '?'), [
                'controller' => 'Help',
                'action' => 'myDevelopers'
            ], [
                'escape' => false,
                'target' => '_blank'
            ]
        );
    ?> 
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('user_id', 'Developers') ?></th>
                <th scope="col"><?= $this->Paginator->sort('location') ?></th>
                <th scope="col"><?= $this->Paginator->sort('website') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($developers as $developer): ?>
            <tr>
                <td><?= $this->Html->link($developer->name, ['controller' => 'Developers', 'action' => 'view', $developer->id]) ?> </td>
                <td><?= h($developer->location) ?></td>
                <td>
                    <?php
                        if (preg_match('/^http.*/', $developer->website))
                            echo $this->Html->link($developer->website, $developer->website, ['target' => '_blank']);
                        else
                            echo $this->Html->link($developer->website, 'http://' . $developer->website, ['target' => '_blank']);
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
