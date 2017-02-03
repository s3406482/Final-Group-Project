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
    <h3><?= __('Add Job Help') ?></h3>
    <p>The purpose of this page is to allow users with an employer account to list a new job on the site. Jobs become active on the site immediately and can be searched for by perspective developers straight away.</p>
    <p><strong>Employer: </strong> This dropdown allows you to choose from any employer account connected to the logged in user.<br /><br />
    <strong>Title: </strong> The name of the new job. This should be a one-line summary and will be the first thing a perspective developer sees.<br /><br />
    <strong>Description: </strong> In-depth description of the job. Important things to add here are a description of the actual project, skills required, and of course the compensation awarded.<br /><br />
    <strong>Date Created: </strong> The date the job is to be listed on the site.<br /><br />
    <strong>Date Closed: </strong> The date the job should close to applicants.<br /><br /></p>
</div>
