<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Dev#: Jobs for Developers';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    
    <?= $this->Html->css('https://fonts.googleapis.com/css?family=Open+Sans') ?>
    <?= $this->Html->css('https://fonts.googleapis.com/css?family=Roboto') ?>
    <?= $this->Html->css('https://fonts.googleapis.com/css?family=Montserrat') ?>
    
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('layout.css') ?>
    
    <?= $this->Html->script('https://code.jquery.com/jquery-3.1.1.min.js') ?>
    <?= $this->Html->script('https://use.fontawesome.com/c01fe95ecf.js') ?>
    <?= $this->Html->script('script.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <div id="logo-container" class="large-3 medium-4 columns">
            <a href="/"><?= $this->Html->image('logo.svg', ['class' => 'logo', 'alt' => 'dev h']); ?></a>
        </div>
        <div class="top-bar-section right">
            <?php if (!empty($this->request->session()->read('Auth.User.username'))): ?>
                <span>Hi, <?= $this->Html->link($this->request->session()->read(
                                                'Auth.User.username'), 
                                                ['controller' => 'Users', 'action' => 'view', $this->request->session()->read('Auth.User.id')], 
                                                ['id' => 'username-top-bar']) ?></span>
                <ul class="right inlne-list">
                    <li><?= $this->Html->link(__('Logout'), ['controller' => 'Users', 'action' => 'logout']) ?></li>
                </ul>
            <?php else: ?>
                <ul class="right inline-list">
                    <li><?= $this->Html->link(__('Register'), ['controller' => 'Users', 'action' => 'add']) ?></li>
                    <li><?= $this->Html->link(__('Login'), ['controller' => 'Users', 'action' => 'login']) ?></li>
                </ul>
            <?php endif; ?>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
