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
<div class="developerSkills index large-9 medium-8 columns content">
    <h3><?= __('Developer Skills') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('developer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('skill_id') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($developerSkills as $developerSkill): ?>
            <tr>
                <td><?= $this->Html->link(__($this->Number->format($developerSkill->id)), ['action' => 'view', $developerSkill->id]) ?></td>
                <td><?= $developerSkill->has('developer') ? $this->Html->link($developerSkill->developer->name, ['controller' => 'Developers', 'action' => 'view', $developerSkill->developer->id]) : '' ?></td>
                <td><?= $developerSkill->has('skill') ? $this->Html->link($developerSkill->skill->name, ['controller' => 'Skills', 'action' => 'view', $developerSkill->skill->id]) : '' ?></td>
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
