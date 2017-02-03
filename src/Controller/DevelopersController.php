<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\DeveloperSkill;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
/**
 * Developers Controller
 *
 * @property \App\Model\Table\DevelopersTable $Developers
 */
class DevelopersController extends AppController
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
        //$this->Auth->allow(['add']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];

        // check to ensure developers to be seen are active
        $developers = $this->Developers->find('all')
            ->where(['Developers.active' => TRUE]);

        $developers = $this->paginate($developers);
        
        $this->set(compact('developers'));
        $this->set('_serialize', ['developers']);
    }

    /**
     * myDevelopers method
     * displays only Developers associated with current User
     * @return \Cake\Network\Response|null
     */
    public function myDevelopers()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];

        $developers = null;

        // If user is an Admin return all Developers else return only active Developers
        // associated with User
        if ($this->request->session()->read('Auth.User.administrator'))
            $developers = $this->paginate($this->Developers);
        else {
            $developers = $this->Developers->find('all')
                ->where(['user_id' => $this->request->session()->read('Auth.User.id')])
                ->andWhere(['Developers.active' => TRUE]);
            
            $developers = $this->paginate($developers);
        }

        $this->set(compact('developers'));
        $this->set('_serialize', ['developers']);
    }

    /**
     * View method
     *
     * @param string|null $id Developer id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // this will load Skills and send it to view
        $skills = $this->loadModel('Skills')->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'])
                ->toArray();

        $developer = $this->Developers->get($id, [
            'contain' => ['Users', 'Applications', 'DeveloperSkills']
        ]);
        
        // don't display Applications if not owner or Administrator
        if ($developer->user_id != $this->request->Session()->read('Auth.User.id') && !$this->request->Session()->read('Auth.User.administrator'))
            $developer->applications = null;

        $jobs = $this->loadModel('Jobs')->find('list', [
            'keyField' => 'id',
            'valueField' => 'title'])
            ->toArray();

        $this->set(compact('skills', 'developer', 'jobs'));
        $this->set('_serialize', ['developer', 'skills', 'jobs']);
        
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $developer = $this->Developers->newEntity();
        
        if ($this->request->is('post')) {
            $developer = $this->Developers->patchEntity($developer, $this->request->data);

            // count query to get number of developers with same name as name entered
            $count = $this->Developers->find('all', [
                'conditions' => ['Developers.name' => $this->request->data['name']]])
                ->count();
            
            // if name found display flash message requesting a different name to be entered
            if($count != 0)
                $this->Flash->error(__('Developer name already exists. Please, enter different Developer name.'));
            else {
                // save developer to db
                if ($this->Developers->save($developer)) {
                    $this->Flash->success(__('The developer has been saved.'));

                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The developer could not be saved. Please, try again.'));
                }
            }
        }
        
        $users = $this->getValidUsernames();
        $this->set(compact('developer', 'users'));
        $this->set('_serialize', ['developer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Developer id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $developer = $this->Developers->get($id, [
            'contain' => []
        ]);

        // check if user_id of passed developer equals current user session id
        if ($this->request->Session()->read('Auth.User.id') != $developer->user_id && !$this->request->Session()->read('Auth.User.administrator')) {
            $this->Flash->error(__('Only the User or an Administrator can edit a Developer account'));
            $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $developer = $this->Developers->patchEntity($developer, $this->request->data);

            if ($this->Developers->save($developer)) {
                $this->Flash->success(__('The developer has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The developer could not be saved. Please, try again.'));
            }
        }

        $users = $this->getValidUsernames();
        $this->set(compact('developer', 'users'));
        $this->set('_serialize', ['developer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Developer id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $developer = $this->Developers->get($id, [
            'contain' => []
        ]);

        // check if user_id of passed developer equals current user session id
        if ($this->request->Session()->read('Auth.User.id') != $developer->user_id && !$this->request->Session()->read('Auth.User.administrator')) {
            $this->Flash->error(__('Only the User or an Administrator can deactivate a Developer account'));
            $this->redirect(['action' => 'index']);
        }
        
        $developer->active = false;

        if ($this->Developers->save($developer)) {
            $this->Flash->success(__('The developer has been deleted.'));
        } else {
            $this->Flash->error(__('The developer could not be deleted. Please, try again.'));
        }
        
        return $this->redirect(['action' => 'index']);
    }

    /**
     * getValidUsernames method
     *
     * @param null.
     * @return list/array of Usernames User can use with the Key being the Primary Key.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function getValidUsernames()
    {
        // Admin users get all Usernames where Users can only use themselves
        if ($this->request->session()->read('Auth.User.administrator')) {
            $users = $this->Developers->Users->find('list', [
                'keyField' => 'id',
                'valueField' => 'username']);
        } else {
            $users = $this->Developers->Users->find('list', [
                'keyField' => 'id',
                'valueField' => 'username'])
                ->where(['id' => $this->request->session()->read('Auth.User.id')]);
        }

        return $users;
    }
}
