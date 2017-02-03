<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
        <li><?= $this->Html->link(__('Back to Job'), ['controller' => 'Jobs', 'action' => 'view', $application->job->id]) ?> </li>
        <li><?= $this->Html->link(__('Edit Application'), ['action' => 'edit', $application->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Application'), ['action' => 'delete', $application->id], ['confirm' => __('Are you sure you want to delete # {0}?', $application->id)]) ?> </li>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="applications view large-9 medium-8 columns content">
    <h3><?= h($application->job->title) ?></h3>
    <?php
        echo $this->Html->link(
            $this->Html->div(['help-icon', 'right', 'text-center'], '?'), [
                'controller' => 'Help',
                'action' => 'viewApplication'
            ], [
                'escape' => false,
                'target' => '_blank'
            ]
        );
    ?> 
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Date Applied') ?></th>
            <td><?= h($application->date_created->format('j F Y')) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Developer') ?></th>
            <td><?= $application->has('developer') ? $this->Html->link($application->developer->name, ['controller' => 'Developers', 'action' => 'view', $application->developer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Comments') ?></th>
            <td><?= h($application->comments) ?></td>
        </tr>
        
    </table>
</div>
