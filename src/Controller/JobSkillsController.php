<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\ForbiddenException;

/**
 * JobSkills Controller
 *
 * @property \App\Model\Table\JobSkillsTable $JobSkills
 */
class JobSkillsController extends AppController
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
        
        $jobSkills = $this->JobSkills->find('all', [
            'contain' => ['Jobs', 'Skills']
        ]);
        $jobSkills = $this->paginate($jobSkills);

        $this->set(compact('jobSkills'));
        $this->set('_serialize', ['jobSkills']);
    }

    /**
     * View method
     *
     * @param string|null $id Job Skill id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // check that user is an administrator
        if (!$this->request->session()->read('Auth.User.administrator'))
            throw new ForbiddenException('You must be an Administrator');
        
        $jobSkill = $this->JobSkills->get($id, [
            'contain' => ['Skills', 'Jobs']
        ]);

        $this->set('jobSkill', $jobSkill);
        $this->set('_serialize', ['jobSkill']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $jobSkill = $this->JobSkills->newEntity();
        $job = $this->JobSkills->Jobs->get($this->request->query('job'));
        $employer = $this->loadModel('Employers')->get($job->employer_id);

        // check that User owns Job before adding skill
        if ($this->request->Session()->read('Auth.User.id') != $employer->user_id && !$this->request->Session()->read('Auth.User.administrator')) {
            $this->Flash->error(__('Only Job\'s Employer or an Administrator can add a Job\'s Skills'));
            return $this->redirect(['controller' => 'Jobs', 'action' => 'view', $job->id]);
        }

        // get list of skills with key of 'id' value of 'name'
        $skills = $this->JobSkills->Skills->find('list',[
            'keyField' => 'id',
            'valueField' => 'name']);

        $jobs = $this->JobSkills->Jobs->find('list', [
            'conditions' => ['id' => $this->request->query('job')],
            'keyField' => 'id',
            'valueField' => 'title'
        ]);

        if ($this->request->is('post')) {
            $jobSkill = $this->JobSkills->patchEntity($jobSkill, $this->request->data);
            
            if ($this->JobSkills->save($jobSkill)) {
                $this->Flash->success(__('The job skill has been saved.'));

                return $this->redirect(['controller' => 'Jobs', 'action' => 'view', $jobSkill->job_id]);
            } else {
                $this->Flash->error(__('The job skill could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('jobSkill', 'skills', 'jobs'));
        $this->set('_serialize', ['jobSkill']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Job Skill id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // check that user is an administrator
        if (!$this->request->session()->read('Auth.User.administrator'))
            throw new ForbiddenException('You must be an Administrator');
        
        $jobSkill = $this->JobSkills->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $jobSkill = $this->JobSkills->patchEntity($jobSkill, $this->request->data);
            if ($this->JobSkills->save($jobSkill)) {
                $this->Flash->success(__('The job skill has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The job skill could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('jobSkill'));
        $this->set('_serialize', ['jobSkill']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Job Skill id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $jobSkill = $this->JobSkills->get($id, [
            'contain' => ['Jobs']
        ]);
        
        $employer = $this->loadModel('Employers')->get($jobSkill->job->employer_id);
        
        // save job id for redirect after
        $jobId = $jobSkill->job_id;
        
        // check that User owns Job before deleting skill
        if ($this->request->Session()->read('Auth.User.id') != $employer->user_id && !$this->request->Session()->read('Auth.User.administrator')) {
            $this->Flash->error(__('Only Job\'s Employer or an Administrator can remove a Job\'s Skills'));
            return $this->redirect(['controller' => 'Jobs', 'action' => 'view', $jobId]);
        }
            
        if ($this->JobSkills->delete($jobSkill)) {
            $this->Flash->success(__('The job skill has been deleted.'));
        } else {
            $this->Flash->error(__('The job skill could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Jobs', 'action' => 'view', $jobId]);
    }
}
