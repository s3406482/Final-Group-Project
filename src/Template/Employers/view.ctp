<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
        <?php
            if (!is_null($this->request->Session()->read('Auth.User.id'))) {
                echo '<li>' . $this->Html->link(__('New Employer'), ['action' => 'add']) . '</li>';
                echo '<li>' . $this->Html->link(__('My Employers'), ['action' => 'my_employers']) . '</li>';
            }
    
            if ($employer->user_id == $this->request->Session()->read('Auth.User.id') || $this->request->Session()->read('Auth.User.administrator')) {
                echo '<li>' . $this->Html->link(__('Edit Employer'), ['action' => 'edit', $employer->id]) . '</li>';
                echo '<li>' . $this->Form->postLink(__('Delete Employer'), ['action' => 'delete', $employer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employer->id)]) . '</li>';
            }
        ?>        
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="employers view large-9 medium-8 columns content">
    <h3><?= h($employer->business_name) ?></h3>
    <?php
        echo $this->Html->link(
            $this->Html->div(['help-icon', 'right', 'text-center'], '?'), [
                'controller' => 'Help',
                'action' => 'viewEmployer'
            ], [
                'escape' => false,
                'target' => '_blank'
            ]
        );
    ?> 
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Address') ?></th>
            <td><?= h($employer->address) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Phone') ?></th>
            <td><?= h($employer->phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fax') ?></th>
            <td><?= h($employer->fax) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Website') ?></th>
            <td>
                <?php
                    if (preg_match('/^http.*/', $employer->website))
                        echo $this->Html->link($employer->website, $employer->website, ['target' => '_blank']);
                    else
                        echo $this->Html->link($employer->website, 'http://' . $employer->website, ['target' => '_blank']);
                ?>
            </td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Jobs') ?></h4>
        <?php if (!empty($employer->jobs)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col" class="show-for-large-up"><?= __('Description') ?></th>
                <th scope="col" class="show-for-large-up"><?= __('Date Created') ?></th>
                <th scope="col"><?= __('Date Closed') ?></th>
            </tr>
            <?php foreach ($employer->jobs as $jobs): ?>
            <tr>
                <td><?= $this->Html->link($jobs->title, ['controller' => 'Jobs', 'action' => 'view', $jobs->id]) ?></td>
                <td class="show-for-large-up"><?= h($jobs->description) ?></td>
                <td class="show-for-large-up"><?= h($jobs->date_created) ?></td>
                <td><?= h($jobs->date_closed) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
