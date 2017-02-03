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
    <h3><?= __('My Employers Help') ?></h3>
    <p>This page lists all employer profiles attached to your logged in user account. Click an employer name to see details, or click their website to be taken to the website. The information on this page is sortable by clicking on the column headers.</p>
</div>
