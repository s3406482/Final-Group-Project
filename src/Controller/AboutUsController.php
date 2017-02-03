<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * AboutUs Controller
 *
 * @property \App\Model\Table\AboutUsTable $AboutUs
 */
class AboutUsController extends AppController
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
        //$this->Auth->deny(['index']);
        
        // Allow un-authenticated users to see the following actions
        //$this->Auth->allow(['add']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
    }
}
