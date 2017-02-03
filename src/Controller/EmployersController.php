<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Employers Controller
 *
 * @property \App\Model\Table\EmployersTable $Employers
 */
class EmployersController extends AppController
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
        $this->paginate = [
            'contain' => ['Users']
        ];
        // check to ensure only active employers are shown
        $employers = $this->Employers->find('all')
            ->where(['Employers.active' => TRUE]);

        $employers = $this->paginate($employers);

        $this->set(compact('employers'));
        $this->set('_serialize', ['employers']);
    }

    /**
     * myEmployers method
     * displays only employers associated with current User
     * @return \Cake\Network\Response|null
     */
    public function myEmployers()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];

        $employers = null;

        // If user is an Admin return all Employers else return only Employers
        // associated with User
        if ($this->request->session()->read('Auth.User.administrator'))
            $employers = $this->paginate($this->Employers);
        else {
            $employers = $this->Employers->find('all')
                ->where(['user_id' => $this->request->session()->read('Auth.User.id')])
                ->andWhere(['Employers.active' => TRUE]);

            $employers = $this->paginate($employers);
        }

        $this->set(compact('employers'));
        $this->set('_serialize', ['employers']);
    }

    /**
     * View method
     *
     * @param string|null $id Employer id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.

     */
    public function view($id = null)
    {
        $employer = $this->Employers->get($id, [
            'contain' => ['Users', 'Jobs']
        ]);

        $this->set('employer', $employer);
        $this->set('_serialize', ['employer']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employer = $this->Employers->newEntity();
        
        if ($this->request->is('post')) {
            $employer = $this->Employers->patchEntity($employer, $this->request->data);

            // count query to get number of developers with same name as name entered
            $count = $this->Employers->find('all', [
                'conditions' => ['Employers.business_name' => $this->request->data['business_name']]])
                ->count();
            
            // if name found display flash message requesting a different name to be entered
            if($count != 0)
                $this->Flash->error(__('Business name already exists. Please, enter different Business name.'));
            else{
                // try to save emplyer to db
                if ($this->Employers->save($employer)) {
                    $this->Flash->success(__('The employer has been saved.'));

                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('The employer could not be saved. Please, try again.'));
                }
            }
        }

        $users = $this->getValidUsernames();
        
        $this->set(compact('employer', 'users'));
        $this->set('_serialize', ['employer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Employer id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employer = $this->Employers->get($id, [
            'contain' => []
        ]);

        // check to ensure user is admin or owner of current employer
        if ($this->request->Session()->read('Auth.User.id') != $employer->user_id && !$this->request->Session()->read('Auth.User.administrator')) {
            $this->Flash->error(__('Only the User or an Administrator can deactivate a Employer account'));
            $this->redirect(['action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $employer = $this->Employers->patchEntity($employer, $this->request->data);
            
            if ($this->Employers->save($employer)) {
                $this->Flash->success(__('The employer has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The employer could not be saved. Please, try again.'));
            }
        }

        $users = $this->getValidUsernames();

        $this->set(compact('employer', 'users'));
        $this->set('_serialize', ['employer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Employer id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $employer = $this->Employers->get($id, [
            'contain' => []
        ]);
        
        $this->request->allowMethod(['post', 'delete']);

        // check to ensure user is admin or owner of current employer
        if ($this->request->Session()->read('Auth.User.id') != $employer->user_id && !$this->request->Session()->read('Auth.User.administrator')) {
            $this->Flash->error(__('Only the User or an Administrator can deactivate a Employer account'));
            $this->redirect(['action' => 'index']);
        }

        $employer = $this->Employers->get($id);
        $employer->active = FALSE;

        if ($this->Employers->save($employer)) {
            $this->Flash->success(__('The employer has been deleted.'));
        } else {
            $this->Flash->error(__('The employer could not be deleted. Please, try again.'));
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
            $users = $this->Employers->Users->find('list', [
                'keyField' => 'id',
                'valueField' => 'username']);
        } else {
            $users = $this->Employers->Users->find('list', [
                'keyField' => 'id', 
                'valueField' => 'username'])
                ->where(['id' => $this->request->session()->read('Auth.User.id')]);
        }
        
        return $users;
    }
}
