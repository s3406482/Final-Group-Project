<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <?= $this->element('main-nav') ?>
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
        <li><?= $this->Html->link(__('Edit Developer Skill'), ['action' => 'edit', $developerSkill->id]) ?> </li>
        <!-- <li><?= $this->Form->postLink(__('Delete Developer Skill'), ['action' => 'delete', $developerSkill->id], ['confirm' => __('Are you sure you want to delete # {0}?', $developerSkill->id)]) ?> </li> -->
        <li><?= $this->Html->link(__('List Developer Skills'), ['action' => 'index']) ?> </li>
    </ul>
    <?php
        if ($this->request->Session()->read('Auth.User.administrator'))
            echo $this->element('admin-nav');
    ?>
</nav>
<div class="developerSkills view large-9 medium-8 columns content">
    <h3><?= h($developerSkill->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Developer') ?></th>
            <td><?= $developerSkill->has('developer') ? $this->Html->link($developerSkill->developer->name, ['controller' => 'Developers', 'action' => 'view', $developerSkill->developer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Skill') ?></th>
            <td><?= $developerSkill->has('skill') ? $this->Html->link($developerSkill->skill->name, ['controller' => 'Skills', 'action' => 'view', $developerSkill->skill->id]) : '' ?></td>
        </tr>
    </table>
</div>
