<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
        <?php
            if (!is_null($this->request->Session()->read('Auth.User.id'))) {
                echo '<li>' . $this->Html->link(__('New Developer'), ['action' => 'add']) . '</li>';
                echo '<li>' . $this->Html->link(__('My Developers'), ['action' => 'my_developers']) . '</li>';
            }
    
            if ($developer->user_id == $this->request->Session()->read('Auth.User.id') || $this->request->Session()->read('Auth.User.administrator')) {
                echo '<li>' . $this->Html->link(__('Edit Developer'), ['action' => 'edit', $developer->id]) . '</li>';
                echo '<li>' . $this->Form->postLink(__('Delete Developer'), ['action' => 'delete', $developer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $developer->id)]) . '</li>';
                echo '<li>' . $this->Html->link(__('New Developer Skill'), ['controller' => 'DeveloperSkills', 'action' => 'add']) . '</li>';
            }
        ?>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="developers view large-9 medium-8 columns content">
    <h3><?= h($developer->name) ?></h3>
    <?php
        echo $this->Html->link(
            $this->Html->div(['help-icon', 'right', 'text-center'], '?'), [
                'controller' => 'Help',
                'action' => 'viewDeveloper'
            ], [
                'escape' => false,
                'target' => '_blank'
            ]
        );
    ?> 
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= h($developer->location) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Website') ?></th>
            <td>
                <?php
                    if (preg_match('/^http.*/', $developer->website))
                        echo $this->Html->link($developer->website, $developer->website, ['target' => '_blank']);
                    else
                        echo $this->Html->link($developer->website, 'http://' . $developer->website, ['target' => '_blank']);
                ?>
            </td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Developer Skills') ?></h4>
        <?php if (!empty($developer->developer_skills)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Skill') ?></th>
                <?php if($developer->user_id == $this->request->Session()->read('Auth.User.id') || $this->request->Session()->read('Auth.User.administrator')): ?>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                <?php endif; ?>
            </tr>

            <?php foreach ($developer->developer_skills as $developerSkills): ?>
            <tr>
                <td><?= $skills[$developerSkills->skill_id] ?></td>
                <?php if($developer->user_id == $this->request->Session()->read('Auth.User.id') || $this->request->Session()->read('Auth.User.administrator')): ?>
                    <td class="actions">
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'DeveloperSkills', 'action' => 'delete', $developerSkills->id], ['confirm' => __('Are you sure you want to delete skill: {0}?', $developerSkills->id)]) ?>
                    </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Job Applications') ?></h4>
        <?php if (!empty($developer->applications)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Job Title') ?></th>
                <th scope="col"><?= __('Date Applied') ?></th>
            </tr>
            <?php foreach ($developer->applications as $applications): ?>
            <tr>
                <td><?= $this->Html->link($jobs[$applications->job_id], ['controller' => 'Applications', 'action' => 'view', $applications->id]) ?></td>
                <td><?= h($applications->date_created) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
