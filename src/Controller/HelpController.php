<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Help Controller
 *
 * @property \App\Model\Table\HelpTable $Help
 */
class HelpController extends AppController
{

    /**
     * Before Filter method
     *
     * Called during the Controller.Initialize event which occurs before every
     * action in the controller. Check for active session or inspect user permissions.
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Deny un-authenticated users from seeing the following actions
        //$this->Auth->deny(['index', 'view']);
        
        // Allow un-authenticated users to see the following actions
        $this->Auth->allow([
            'addApplication',
            'addDeveloper',
            'addEmployer',
            'addJob', 
            'addSkill',
            'addUser',
            'applications',
            'developers',
            'editApplication',
            'editDeveloper',
            'editEmployer',
            'editJob',
            'editSkill',
            'editUser',
            'employers',
            'jobs', 
            'login',
            'skills',
            'myDevelopers',
            'myEmployers',
            'myJobs',
            'updatePassword',
            'users',
            'viewApplication',
            'viewDeveloper',
            'viewEmployer',
            'viewJob',
            'viewSkill',
            'viewUser'
        ]);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {}
    
    public function addApplication() {}
    
    public function addDeveloper() {}
    
    public function addEmployer() {}
    
    public function addJob() {}
    
    public function addSkill() {}
    
    public function addUser() {}
    
    public function applications() {}
    
    public function developers() {}
    
    public function editApplication() {}
    
    public function editDeveloper() {}
    
    public function editEmployer() {}

    public function editJob() {}
    
    public function editSkill() {}
    
    public function editUser() {}
    
    public function employers() {}
    
    public function jobs() {}
    
    public function login() {}
    
    public function skills() {}
    
    public function myDevelopers() {}
    
    public function myEmployers() {}
    
    public function myJobs() {}
    
    public function updatePassword() {}
    
    public function users() {}
    
    public function viewApplication() {}
    
    public function viewDeveloper() {}
    
    public function viewEmployer() {}
    
    public function viewJob() {}
    
    public function viewSkill() {}
    
    public function viewUser() {}
}
