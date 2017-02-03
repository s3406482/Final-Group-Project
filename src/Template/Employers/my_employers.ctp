<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
        <li><?= $this->Html->link(__('New Employer'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('My Employers'), ['action' => 'my_employers']) ?></li>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="employers index large-9 medium-8 columns content">
    <h3><?= __('My Employers') ?></h3>
    <?php
        echo $this->Html->link(
            $this->Html->div(['help-icon', 'right', 'text-center'], '?'), [
                'controller' => 'Help',
                'action' => 'myEmployers'
            ], [
                'escape' => false,
                'target' => '_blank'
            ]
        );
    ?> 
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('business_name') ?></th>
                <th scope="col" class="show-for-large-up"><?= $this->Paginator->sort('address') ?></th>
                <th scope="col" class="show-for-large-up"><?= $this->Paginator->sort('phone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('website') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employers as $employer): ?>
            <tr>
                <td><?= $this->Html->link($employer->business_name, ['action' => 'view', $employer->id]) ?></td>
                <td class="show-for-large-up"><?= h($employer->address) ?></td>
                <td class="show-for-large-up"><?= h($employer->phone) ?></td>
                <td>
                    <?php
                        if (preg_match('/^http.*/', $employer->website))
                            echo $this->Html->link($employer->website, $employer->website, ['target' => '_blank']);
                        else
                            echo $this->Html->link($employer->website, 'http://' . $employer->website, ['target' => '_blank']);
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
