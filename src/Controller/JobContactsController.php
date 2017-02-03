<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\ForbiddenException;

/**
 * JobContacts Controller
 *
 * @property \App\Model\Table\JobContactsTable $JobContacts
 */
class JobContactsController extends AppController
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
        $this->Auth->deny(['index', 'view']);
        
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
        // check that user is an administrator
        if (!$this->request->session()->read('Auth.User.administrator'))
            throw new ForbiddenException('You must be an Administrator');
        
        $this->paginate = [
            'contain' => ['Jobs']
        ];
        
        $jobContacts = $this->paginate($this->JobContacts);

        $this->set(compact('jobContacts'));
        $this->set('_serialize', ['jobContacts']);
    }

    /**
     * View method
     *
     * @param string|null $id Job Contact id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // check that user is an administrator
        if (!$this->request->session()->read('Auth.User.administrator'))
            throw new ForbiddenException('You must be an Administrator');
        
        $jobContact = $this->JobContacts->get($id, [
            'contain' => ['Jobs']
        ]);

        $this->set('jobContact', $jobContact);
        $this->set('_serialize', ['jobContact']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $jobContact = $this->JobContacts->newEntity();

        if ($this->request->is('post')) {
            $currentJob = $this->JobContacts->Jobs->get($this->request->query('job'));
            $employer = $this->loadModel('Employers')->get($currentJob->employer_id);
            
            // check that User owns Job before adding a contact
            if ($this->request->Session()->read('Auth.User.id') != $employer->user_id && !$this->request->Session()->read('Auth.User.administrator')) {
                $this->Flash->error(__('Only Job\'s Employer or an Administrator can add a Job\'s Contacts'));
                return $this->redirect(['controller' => 'Jobs', 'action' => 'view', $currentJob->id]);
            }
            
            // get and validate post data from form
            $jobContact = $this->JobContacts->patchEntity($jobContact, $this->request->data);
            
            if ($this->JobContacts->save($jobContact)) {
                $this->Flash->success(__('The job contact has been saved.'));

                return $this->redirect(['controller' => 'Jobs', 'action' => 'view', $jobContact->job_id]);
            } else {
                $this->Flash->error(__('The job contact could not be saved. Please, try again.'));
            }
        }
        
        // get Job from URL parameter ?job=$jobId
        $jobs = $this->JobContacts->Jobs->find('list', [
            'conditions' => [
                'id' => $this->request->query('job')]]);
        
        $this->set(compact('jobContact', 'jobs'));
        $this->set('_serialize', ['jobContact']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Job Contact id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // check that user is an administrator
        if (!$this->request->session()->read('Auth.User.administrator'))
            throw new ForbiddenException('You must be an Administrator');
        
        $jobContact = $this->JobContacts->get($id, [
            'contain' => ['Jobs']
        ]);

        $employer = $this->loadModel('Employers')->get($jobContact->job->employer_id);

        // check that User owns Job before editing a contact
        if ($this->request->Session()->read('Auth.User.id') != $employer->user_id && !$this->request->Session()->read('Auth.User.administrator')) {
            $this->Flash->error(__('Only Job\'s Employer or an Administrator can edit a Job\'s Contacts'));
            return $this->redirect(['controller' => 'Jobs', 'action' => 'view', $jobContact->job->id ]);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $jobContact = $this->JobContacts->patchEntity($jobContact, $this->request->data);
            
            if ($this->JobContacts->save($jobContact)) {
                $this->Flash->success(__('The job contact has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The job contact could not be saved. Please, try again.'));
            }
        }
        
        // get Job from URL parameter ?job=$jobId
        $jobs = $this->JobContacts->Jobs->find('list', [
            'conditions' => [
                'id' => $jobContact->job->id]]);
        
        $this->set(compact('jobContact', 'jobs'));
        $this->set('_serialize', ['jobContact']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Job Contact id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $jobContact = $this->JobContacts->get($id, [
            'contain' => ['Jobs']
        ]);
        
        $jobId = $jobContact->job_id;

        $employer = $this->loadModel('Employers')->get($jobContact->job->employer_id);

        // check that User owns Job before deleting a contact
        if ($this->request->Session()->read('Auth.User.id') != $employer->user_id && !$this->request->Session()->read('Auth.User.administrator')) {
            $this->Flash->error(__('Only Job\'s Employer or an Administrator can delete a Job\'s Contacts'));
            return $this->redirect(['controller' => 'Jobs', 'action' => 'view', $jobId ]);
        }
        
        if ($this->JobContacts->delete($jobContact)) {
            $this->Flash->success(__('The job contact has been deleted.'));
            
            return $this->redirect(['controller' => 'Jobs', 'action' => 'view', $jobId]);
        } else {
            $this->Flash->error(__('The job contact could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'view', $jobContact->id]);
    }
}
