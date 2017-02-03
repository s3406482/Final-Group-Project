<ul class="side-nav">
    <li class="heading"><?= __('Navigation') ?><i class="fa fa-angle-up" aria-hidden="true"></i></li>
    <li><?= $this->Html->link(__('Jobs'), ['controller' => 'Jobs', 'action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('Developers'), ['controller' => 'Developers', 'action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('Employers'), ['controller' => 'Employers', 'action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('About Us'), ['controller' => 'AboutUs', 'action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('Help'), ['controller' => 'Help', 'action' => 'index']) ?></li>
</ul>