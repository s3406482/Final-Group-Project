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
<div class="help index large-9 medium-8 columns content">
    <h3><?= __('Help Topics') ?></h3>
    <?php
        /*echo $this->Html->link(
            $this->Html->div(['help-icon', 'right', 'text-center'], '?'), [
                'controller' => 'Jobs',
                'action' => 'index'
            ], [
                'escape' => false
            ]
        );*/
    ?>
    <div><strong>Applications</strong></div>
    <ul>
        <li><?= $this->Html->link(__('Applications'), ['action' => 'applications'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('Add Application'), ['action' => 'addApplication'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('Edit Application'), ['action' => 'editApplication'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('View Application'), ['action' => 'viewApplication'], ['target' => '_blank']) ?></li>
    </ul>
    <div><strong>Developers</strong></div>
    <ul>
        <li><?= $this->Html->link(__('Developers'), ['action' => 'developers'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('My Developers'), ['action' => 'myDevelopers'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('Add Developer'), ['action' => 'addDeveloper'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('Edit Developer'), ['action' => 'editDeveloper'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('View Developer'), ['action' => 'viewDeveloper'], ['target' => '_blank']) ?></li>
    </ul>
    <div><strong>Employers</strong></div>
    <ul>
        <li><?= $this->Html->link(__('Employers'), ['action' => 'employers'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('My Employers'), ['action' => 'myEmployers'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('Add Employer'), ['action' => 'addEmployer'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('Edit Employer'), ['action' => 'editEmployer'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('View Employer'), ['action' => 'viewEmployer'], ['target' => '_blank']) ?></li>
    </ul>
    <div><strong>Jobs</strong></div>
    <ul>
        <li><?= $this->Html->link(__('Jobs'), ['action' => 'jobs'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('My Jobs'), ['action' => 'myJobs'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('Add Job'), ['action' => 'addJob'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('Edit Job'), ['action' => 'editJob'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('View Job'), ['action' => 'viewJob'], ['target' => '_blank']) ?></li>
    </ul>
    <div><strong>Skills</strong></div>
    <ul>
        <li><?= $this->Html->link(__('Skills'), ['action' => 'skills'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('Add Skill'), ['action' => 'addSkill'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('Edit Skill'), ['action' => 'editSkill'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('View Skill'), ['action' => 'viewSkill'], ['target' => '_blank']) ?></li>
    </ul>
    <div><strong>Users</strong></div>
    <ul>
        <li><?= $this->Html->link(__('Users'), ['action' => 'users'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('Add User'), ['action' => 'addUser'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'editUser'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('View User'), ['action' => 'viewUser'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('Login'), ['action' => 'login'], ['target' => '_blank']) ?></li>
        <li><?= $this->Html->link(__('Update Password'), ['action' => 'updatePassword'], ['target' => '_blank']) ?></li>
    </ul>
</div>