<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\ForbiddenException;
use Cake\I18n\Date;

/**
 * Applications Controller
 *
 * @property \App\Model\Table\ApplicationsTable $Applications
 */
class ApplicationsController extends AppController
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
        // Deny un-authenticated users from seeing details about applications
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
        if (!$this->request->Session()->read('Auth.User.administrator'))
            throw new ForbiddenException(__('Only Administrators can view all Applications.'));
        
        $this->paginate = [
            'contain' => ['Jobs', 'Developers']
        ];
        $applications = $this->paginate($this->Applications);

        $this->set(compact('applications'));
        $this->set('_serialize', ['applications']);
    }

    /**
     * View method
     *
     * @param string|null $id Application id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {   
        // get application
        $application = $this->Applications->get($id, [
            'contain' => ['Jobs', 'Developers']
        ]);
        
        // check that user is applicant or an administrator
        if ($application->developer->user_id != $this->request->Session()->read('Auth.User.id') && !$this->request->Session()->read('Auth.User.administrator'))
            throw new ForbiddenException(__('Only Applicants and Administrators can view Applications.'));

        $this->set('application', $application);
        $this->set('_serialize', ['application']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $application = $this->Applications->newEntity();
        
        if ($this->request->is('post')) {
            // get application entered
            $applicationData = $this->request->data;
            
            // get and assign today's date
            $todaysDate = new Date();
            $applicationData['date_created'] = $todaysDate;
            
            // validate application
            $applicationData = $this->Applications->patchEntity($application, $applicationData);
            
            // get job that is being applied for
            $job = $this->Applications->Jobs->get($applicationData->job_id, [
                'contain' => ['Employers']
                ]);
            
            // get developer that is applying for job
            $developer = $this->Applications->Developers->get($applicationData->developer_id);
            
            // check that user does not own both the job's employer and the applying developer
            if ($job->employer->user_id == $developer->user_id) {
                $this->Flash->error('You cannot apply for your own Job.');
                return $this->redirect(['controller' => 'Jobs', 'action' => 'view', $applicationData->job_id]);
            }
            
            // get list of other developers that have applied for the position
            $otherApplicationDevelopers = $this->Applications->find('list', [
               'contain' => ['Developers'],
                'keyField' => 'developer.user_id',
                'valueField' => 'developer.name'
            ])->where([
                'job_id' => $applicationData->job_id
            ])->toArray();
            
            // check that user has not already applied for the position under another developer
            if (in_array($developer->user_id, array_keys($otherApplicationDevelopers))) {
                $this->Flash->error('You can only apply for a Job once per User. Not once per Developer.');
                return $this->redirect(['controller' => 'Jobs', 'action' => 'view', $applicationData->job_id]);
            }
            
            if ($this->Applications->save($applicationData)) {
                $this->Flash->success(__('The application has been saved.'));

                return $this->redirect(['controller' => 'Jobs', 'action' => 'view', $applicationData->job_id]);
            } else {
                $this->Flash->error(__('The application could not be saved. Please, try again.'));
            }
        }
        
        // get job to be applied from ?job=$id in URL
        $jobs = $this->Applications->Jobs->find('list', [
            'conditions' => [
                'id' => $this->request->query('job')]
        ]);
        
        $developers = null;
        
        // get developers that are owned by user or all if administrator
        if ($this->request->Session()->read('Auth.User.administrator')) {
            $developers = $this->Applications->Developers->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])->where(['active' => TRUE]);
        } else {
            $developers = $this->Applications->Developers->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ])->where([
                'user_id' => $this->request->Session()->read('Auth.User.id')
            ])->andWhere(['active' => TRUE]);
        }
        // if not registered as any developer, display error and redirect to create developer page
        if($developers->count() == 0)
        {
            $this->Flash->error('You must first register as a developer to apply for jobs');
            return $this->redirect(['controller' => 'Developers', 'action' => 'add']);
        }
        $this->set(compact('application', 'jobs', 'developers'));
        $this->set('_serialize', ['application']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Application id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $application = $this->Applications->get($id, [
            'contain' => ['Developers']
        ]);
        
        // check that developer that applied for job is owned by the user or user is an administrator
        if ($application->developer->user_id != $this->request->Session()->read('Auth.User.id') && !$this->request->Session()->read('Auth.User.administrator')) {
            $this->Flash->error('Only Applications Developer or Administrators can edit an Application.');
            $this->redirect(['action' => 'view', $application->id]);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $application = $this->Applications->patchEntity($application, $this->request->data);
            
            if ($this->Applications->save($application)) {
                $this->Flash->success(__('The application has been saved.'));

                return $this->redirect(['action' => 'view', $application->id]);
            } else {
                $this->Flash->error(__('The application could not be saved. Please, try again.'));
            }
        }
        
        // get job that the application is made against
        $jobs = $this->Applications->Jobs->find('list', [
            'conditions' => [
                'id' => $application->job_id]
        ]);
        
        // get developers that are owned by user or all if administrator
        if ($this->request->Session()->read('Auth.User.administrator')) {
            $developers = $this->Applications->Developers->find('list', [
                'keyField' => 'id',
                'valueField' => 'name'
            ]);
        } else {
            $developers = $this->Applications->Developers->find('list', [
                'conditions' => ['user_id' => $this->request->Session()->read('Auth.User.id')],
                'keyField' => 'id',
                'valueField' => 'name'
            ]);
        }
        
        $this->set(compact('application', 'jobs', 'developers'));
        $this->set('_serialize', ['application']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Application id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $application = $this->Applications->get($id, [
            'contain' => ['Developers']
        ]);
        
        $jobId = $application->job_id;
        
        // check that user is developers owner or and administrator before deleting application
        if ($application->developer->user_id != $this->request->Session()->read('Auth.User.id') && !$this->request->Session()->read('Auth.User.administrator')) {
            $this->Flash->error('Only Applications Developer or an Administrator can delete an Application');
            $this->redirect(['action' => 'view', $jobId]);
        }
        
        if ($this->Applications->delete($application)) {
            $this->Flash->success(__('The application has been deleted.'));
        } else {
            $this->Flash->error(__('The application could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Jobs', 'action' => 'view', $jobId]);
    }
}
