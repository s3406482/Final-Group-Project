<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\ForbiddenException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Collection\Collection;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
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
        // Deny un-authenticated users from seeing the list of users
        $this->Auth->deny(['index', 'view']);
        
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['add', 'logout']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        // double check that there is a session from a user loggin in
        if (is_null($this->request->session()->read('Auth.User.id')))
            throw new ForbiddenException('You must be logged in');
        
        // check if user is an administrator
        if (!$this->request->session()->read('Auth.User.administrator'))
            throw new ForbiddenException('You must be an Administrator');
        
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if ($this->request->session()->read('Auth.User.id') != $id && !$this->request->session()->read('Auth.User.administrator'))
            throw new ForbiddenException(__('Only Administrators can view other Users.'));
        
        $user = $this->Users->get($id, [
            'contain' => ['Developers', 'Employers']
        ]);
        
        // get array of Developer ID's and Names
        $developerNames = $this->Users->Developers->find('list', [
            'conditions' => ['Developers.user_id' => $id],
            'keyField' => 'id',
            'valueField' => 'name'
        ])->toArray();
        
        $applications = null;
        
        // get applications from Users Developers. only try if User has any developers
        if (count($developerNames) > 0) {
            $applications = $this->loadModel('Applications')->find('all', [
                'contain' => ['Jobs'],
            ])->where(['developer_id IN' => array_keys($developerNames)]);
        }

        $this->set(compact('user', 'applications', 'developerNames'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        
        if ($this->request->is('post')) {
            // created date array for todays data
            $dateArray = [];
            $dateArray['year'] = gmdate('Y');
            $dateArray['month'] = gmdate('m');
            $dateArray['day'] = gmdate('d');
            
            // get data and assign default 'active' and 'administrator' values
            $userData = $this->request->data;
            $userData['active'] = true;
            $userData['administrator'] = false;
            $userData['joined'] = $dateArray;
            
            // check that username has not already in use
            $dbUser = $this->Users->find('all')->where(['username' => $userData['username']])->first();
            
            if (!is_null($dbUser))
                $this->Flash->error('Username already exists.');
            else {

                $user = $this->Users->patchEntity($user, $userData);

                if ($this->Users->save($user)) {
                    $this->Flash->success(__('The user has been saved.'));
                    $this->Auth->setUser($user);

                    return $this->redirect(['controller' => 'jobs', 'action' => 'index']);
                } else {
                    $this->Flash->error(__('The user could not be saved. Please, try again.'));
                }
            }
        }
        
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        
        // ensure User trying to edit is User to update or an Administrator
        if ($this->request->Session()->read('Auth.User.id') != $id && !$this->request->Session()->read('Auth.User.administrator'))
            throw new ForbiddenException(__('Only Administrators can edit other Users.'));
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            
            // if user is being promoted to an administrator verify that user logged in is an administrator
            if ($user->administrator && !$this->request->Session()->read('Auth.User.administrator'))
                throw new ForbiddenException(__('Only Administrators can promote Users to Administrators.'));
            
            // check to see if user is being deactivated
            $deactivatedAccount = false;
            
            if (!$user->active)
                $deactivatedAccount = true;
            
            // try and save user to database
            if ($this->Users->save($user)) {
                $this->Flash->success(__('User details updated.'));
                
                // logout if user has been deactivated
                if ($deactivatedAccount)
                    return $this->redirect(['action' => 'logout']);
                else
                    return $this->redirect(['action' => 'view', $id]);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']); 
        
        if ($this->request->Session()->read('Auth.User.id') != $id && !$this->request->Session()->read('Auth.User.administrator')) {
            $this->Flash->error(__('Only the User or an Administrator can deactivate an Account'));
            $this->redirect(['controller' => 'Jobs', 'action' => 'index']);
        }
        
        // get user from passed id and set active as FALSE
        $user = $this->Users->get($id);
        $user->active = false;
        
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'logout']);
    }
    
    /**
     * Login method
     */
    public function login()
    {   
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            
            // username/password combo correct
            if ($user) {
                // if user is active redirect to URL
                if ($user['active']) {
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl());    
                }
                $this->Flash->error(__('User account deleted. Please contact an Administrator.'));
                return;
            }
            $this->Flash->error(__('Invalid username or password, try again.'));
        }
    }
    
    /**
     * Logout method
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
    
    /**
     * Change Password method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to view/$user_id.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function updatepassword($id)
    {
        if ($id != $this->request->session()->read('Auth.User.id'))
            throw new ForbiddenException('You are only allowed to change your own Password.');
        
        if ($this->request->is('post')) {
            $user = $this->Users->get($id);
            $hasher = new DefaultPasswordHasher();
            
            // get data from form
            $oldPassword = $this->request->data('old-password');
            $newPassword = $this->request->data('new-password');
            $confirmNewPassword = $this->request->data('confirm-new-password');
            
            // check that data from fields is not empty
            if (empty($oldPassword) || empty($newPassword) || empty($confirmNewPassword)) {
                $this->Flash->error(__('Please fill out all fields.'));
                return;
            }
            
            // check if hash of old password is the same as what is stored in the database
            if (!$hasher->check($oldPassword, $user->password)) {
                $this->Flash->error(__('Wrong old Password.'));
                return;
            }
            
            // check that $newPassword and $confirmNewPassword are the same
            if ($newPassword != $confirmNewPassword) {
                $this->Flash->error(__('New passwords must be the same'));
                return;   
            }
            
            $user->password = $newPassword;
            
            // update database password with new hash
            if ($this->Users->save($user)) {
                $this->Flash->success('Successfully update Password.');
                $this->redirect(['action' => 'view', $user->id]);
            } else
                $this->Flash->error('Failed to update Password.');
        } 
    }
}