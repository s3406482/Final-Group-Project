<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\ForbiddenException;

/**
 * DeveloperSkills Controller
 *
 * @property \App\Model\Table\DeveloperSkillsTable $DeveloperSkills
 */
class DeveloperSkillsController extends AppController
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
        
        $developerSkills = $this->DeveloperSkills->find('all', [
           'contain' => ['Developers', 'Skills'] 
        ]);
        
        $developerSkills = $this->paginate($developerSkills);

        $this->set(compact('developerSkills'));
        $this->set('_serialize', ['developerSkills']);
    }

    /**
     * View method
     *
     * @param string|null $id Developer Skill id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // check that user is an administrator
        if (!$this->request->session()->read('Auth.User.administrator'))
            throw new ForbiddenException('You must be an Administrator');
        
        $developerSkill = $this->DeveloperSkills->get($id, [
            'contain' => ['Skills','Developers']
        ]);

        $this->set('developerSkill', $developerSkill);
        $this->set('_serialize', ['developerSkill']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // this will populate User drop down list, at this stage will display user id
        // as it is in related table developers
        $developers = $this->getValidDeveloper();

        // get list of skills with key of 'id' value of 'name'
        $skills = $this->DeveloperSkills->Skills->find('list',[
            'keyField' => 'id',
            'valueField' => 'name']);

        $developerSkill = $this->DeveloperSkills->newEntity();
        
        $this->set(compact('developerSkill', 'skills', 'developers'));
        $this->set('_serialize', ['developers']);
        $this->set('_serialize', ['developerSkill']);
        
        if ($this->request->is('post')) {
            $developerSkill = $this->DeveloperSkills->patchEntity($developerSkill, $this->request->data);
            
            // get first developer details that match developerSkill's developer_id
            $developer = $this->DeveloperSkills->Developers->find('all', [
                'conditions' => ['Developers.id = ' => $developerSkill->developer_id],
                'limit' => 1
            ])->first();
            
            // if developers user_id is session id OR session user is admin
            if ($developer->user_id != $this->request->session()->read('Auth.User.id') && !$this->request->session()->read('Auth.User.administrator')) {
                $this->Flash->error('Only Administrators or Developer owners can add skills.');
                return;
            }
            
            // check database if record already exists for skill assigned to developer
            $dbDeveloperSkills = $this->DeveloperSkills->find('all', [
                'conditions' => [
                    'DeveloperSkills.skill_id = ' => $developerSkill->skill_id,
                    'DeveloperSkills.developer_id = ' => $developerSkill->developer_id],
                'limit' => 1
            ]);
            
            // if number of records is not zero then record already exists in database
            if ($dbDeveloperSkills->count() > 0) {
                $this->Flash->error('Skill already added to Developer');
                return;
            }
            
            // try and save record to database
            if ($this->DeveloperSkills->save($developerSkill)) {
                $this->Flash->success(__('The developer skill has been saved.'));
                return $this->redirect(['controller' => 'Developers', 'action' => 'view', $developerSkill->developer_id]);
            } else
                $this->Flash->error(__('The developer skill could not be saved. Please, try again.'));
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Developer Skill id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // check that user is an administrator
        if (!$this->request->session()->read('Auth.User.administrator'))
            throw new ForbiddenException('You must be an Administrator');
        
        // this will populate User drop down list, at this stage will display user id
        // as it is in related table developers
        $developers = $this->getValidDeveloper();
        // this will ensure the skills are displayed
        $skills = $this->DeveloperSkills->Skills->find('list',[
            'keyField' => 'id',
            'valueField' => 'name']);

        $developerSkill = $this->DeveloperSkills->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $developerSkill = $this->DeveloperSkills->patchEntity($developerSkill, $this->request->data);
            if ($this->DeveloperSkills->save($developerSkill)) {
                $this->Flash->success(__('The developer skill has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The developer skill could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('developerSkill', 'skills', 'developers'));
        $this->set('_serialize', ['developerSkill']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Developer Skill id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $developerSkill = $this->DeveloperSkills->get($id, [
            'contain' => ['Developers']
        ]);
        
        // check if user is developers owner
        if ($this->request->Session()->read('Auth.User.id') != $developerSkill->user_id && !$this->request->Session()->read('Auth.User.administrator')) {
            $this->Flash->error(__('Only Developer owner or an Administrator can delete a skill.'));
            return $this->redirect(['controller' => 'Developers', 'action' => 'view', $developerSkill->developer_id]);
        }
        
        if ($this->DeveloperSkills->delete($developerSkill)) {
            $this->Flash->success(__('The developer skill has been deleted.'));
        } else {
            $this->Flash->error(__('The developer skill could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Developers', 'action' => 'view', $developerSkill->developer_id]);
    }
    /**
     * getValidDeveloper method
     *
     * @param null.
     * @return list/array of Developer ID User can use with the Key being the Primary Key.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function getValidDeveloper()
    {
        $developers = null;
        
        // Admin users get all Developer IDs where Users can only use themselves
        if ($this->request->session()->read('Auth.User.administrator')) {
            $developers = $this->DeveloperSkills->Developers->find('list', [
                'keyField' => 'id',
                'valueField' => 'name']);
        } else {
            $developers = $this->DeveloperSkills->Developers->find('list', [
                    'keyField' => 'id',
                    'valueField' => 'name'])
                    ->where(['user_id' => $this->request->session()->read('Auth.User.id')]);
        }

        return $developers;
    }
}
