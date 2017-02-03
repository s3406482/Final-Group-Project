<ul class="side-nav">
    <li class="heading"><?= __('Administration') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
    <li><?= $this->Html->link(__('Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('Skills'), ['controller' => 'Skills', 'action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('View All Applications'), ['controller' => 'Applications', 'action' => 'index']) ?></li>
</ul>