<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Date;

/**
 * Jobs Controller
 *
 * @property \App\Model\Table\JobsTable $Jobs
 */
class JobsController extends AppController
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
        $this->Auth->allow(['search']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $todaysDate = new Date();

        // added a check so only active employers jobs are shown, also check the
        $jobs = $this->Jobs->find('all',[
            'contain' => ['Employers']])
            ->where(['Employers.active' => TRUE])
            ->andWhere(['date_closed >' =>  $todaysDate]);

        $jobs = $this->paginate($jobs);

        $this->set(compact('jobs'));
        $this->set('_serialize', ['jobs']);
    }
    
    /**
     * MyJobs method
     *
     * @return \Cake\Network\Response|null
     */
    public function myJobs()
    {
        $jobs = $this->Jobs->find('all', [
            'contain' => ['Employers']])
            ->where(['Employers.user_id' => $this->request->Session()->read('Auth.User.id')])
            ->andWhere(['Employers.active' => TRUE]);
        
        $jobs = $this->paginate($jobs);

        $this->set(compact('jobs'));
        $this->set('_serialize', ['jobs']);
    }

    /**
     * View method
     *
     * @param string|null $id Job id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $job = $this->Jobs->get($id, [
            'contain' => ['Employers', 'JobContacts', 'JobSkills']
        ]);
        
        // create empty Applications return variable for view
        $applications = null;
        
        // get applications for Job. Return all applications if user is the Job owner or an administrator.
        // If User not owner or administrator return only Applications that they have created.
        if ($this->request->Session()->read('Auth.User.id') == $job->employer->user_id || $this->request->Session()->read('Auth.User.administrator')) {
            $applications = $this->loadModel('Applications')->find('all', [
                'contain' => 'Developers',
                'conditions' => ['job_id' => $id]
            ]);
        } else if (!is_null($this->request->Session()->read('Auth.User.id'))) {
            // get developers owned by logged in user
            $devsOwnedByUser =  $this->loadModel('Developers')->find('list', [
                'keyField' => 'id',
                'valueField' => 'name',
                'conditions' => ['user_id' => $this->request->Session()->read('Auth.User.id')]
            ])->toArray();
            
            // check that user has any developers
            if(count($devsOwnedByUser) > 0) {
                // get applications where developer_id is in devsOwnedByUser array
                $tempApplications = $this->loadModel('Applications')->find('all', [
                    'contain' => 'Developers'
                ])->where([
                    'job_id' => $id
                ])->andWhere([
                    'developer_id IN' => array_keys($devsOwnedByUser)
                ]);

                // if count of results in query is greater than zero assign query to return Applications variable
                if ($tempApplications->count() > 0)
                    $applications = $tempApplications;
            }
        }
        
        // get array of Skills so can put Skill name instead of ID in view
        $skills = $this->loadModel('Skills')->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->toArray();

        $this->set(compact('job', 'skills', 'applications'));
        $this->set('_serialize', ['job']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $job = $this->Jobs->newEntity();
        
        // make date closed 1 month in the future by default
        $closedDate = new Date();
        $closedDate->modify('+1 months');
        $job->date_closed = $closedDate;

        if ($this->request->is('post')) {
            $todaysDate = new Date();
            
            $job = $this->Jobs->patchEntity($job, $this->request->data);
            
            // add the date create. Not sure if this will cause an issue assigning this after the
            // validation. I.e. patchEntity()
            $job->date_created = $todaysDate;
            
            if ($this->Jobs->save($job)) {
                $this->Flash->success(__('The job has been saved.'));

                return $this->redirect(['action' => 'myJobs']);
            } else {
                $this->Flash->error(__('The job could not be saved. Please, try again.'));
            }
        }
        
        // returns all active employers associated with current user
        $employers = $this->Jobs->Employers->find('list',[
            'keyField' => 'id',
            'valueField' => 'business_name'])
            ->where(['user_id' => $this->request->session()->read('Auth.User.id')])
            ->andWhere(['active' => TRUE])
            ->toArray();
        
        // if user has no employers they cannot create a job
        if(!$employers) {
            $this->Flash->error(__('You must have an active Employers account to add a Job!'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('job', 'employers'));
        $this->set('_serialize', ['job']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Job id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $job = $this->Jobs->get($id, [
            'contain' => ['Employers']
        ]);

        // check so can only owner or admin can edit job
        if ($this->request->Session()->read('Auth.User.id') != $job->employer->user_id && !$this->request->Session()->read('Auth.User.administrator')) {
            $this->Flash->error(__('Only Job\'s Employer or an Administrator can edit a Job'));
            return $this->redirect(['controller' => 'Jobs', 'action' => 'view', $job->id]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $job = $this->Jobs->patchEntity($job, $this->request->data);
            
            if ($this->Jobs->save($job)) {
                $this->Flash->success(__('The job has been saved.'));

                return $this->redirect(['action' => 'view', $job->id]);
            } else {
                $this->Flash->error(__('The job could not be saved. Please, try again.'));
            }
        }
        
        // returns all active employers associated with current user
        $employers = $this->Jobs->Employers->find('list',[
            'keyField' => 'id',
            'valueField' => 'business_name'])
            ->where(['user_id' => $this->request->session()->read('Auth.User.id')])
            ->andWhere(['active' => TRUE])
            ->toArray();
        
        $this->set(compact('job', 'employers'));
        $this->set('_serialize', ['job']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Job id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $job = $this->Jobs->get($id, [
            'contain' => ['Employers']
        ]);

        // check to ensure user is admin or owner of current job
        if ($this->request->Session()->read('Auth.User.id') != $job->employer->user_id && !$this->request->Session()->read('Auth.User.administrator')) {
            $this->Flash->error(__('Only the Employer or an Administrator can close a Job'));
            return $this->redirect(['action' => 'view', $id]);
        }
        
        $todaysDate = new Date();

        // check if job already closed
        if($job->date_closed <= $todaysDate) {
            $this->Flash->error(__('Job is already closed!'));
            return $this->redirect(['action' => 'view', $id]);
        }

        // change date closed to todays date
        $job->date_closed = $todaysDate;

        if ($this->Jobs->save($job)) {
            $this->Flash->success(__('The job has been closed.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('The job could not be closed. Please, try again.'));
            return $this->redirect(['action' => 'view', $id]);   
        }
    }
    
    /**
     * Search method
     *
     * @return \Cake\Network\Response|null
     */
    public function search()
    {
        // get Skills for input
        $skills = $this->loadModel('Skills')->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ]);
        
        $jobs = null;
        $resultsFound = null;
        
        if ($this->request->is('post')) {
            // get skill id
            $skillId = $this->request->data['skill'];
            
            // get Job Skills where Skill equals $skillId
            $jobSkills = $this->loadModel('JobSkills')->find('all')->where(['skill_id' => $skillId]);
            
            // NOTE: THERE IS A BETTER WAY TO DO THIS IF YOU CAN INCLUDE JOB_SKILLS IN THE JOB QUERY
            // YOU THEN NEED TO TO LOOK AND SEE IF THE VALUE IS IN THE ARRAY. JOBS->JOBSKILLS[1,2,3] HAS
            // VALUE YOU WANT
            
            // create array for Job IDs
            $jobIds = [];
            
            // loop through returned Job Skills and add job_id
            foreach ($jobSkills as $jobSkill)
                array_push($jobIds, $jobSkill->job_id);
            
            $todaysDate = new Date();
            
            // only execute if there has 1 or more jobs for the skill submitted
            if (count($jobIds) > 0) {
                $jobs = $this->Jobs->find('all',[
                    'contain' => ['Employers']])
                    ->where(['Employers.active' => TRUE])
                    ->andWhere(['date_closed >' =>  $todaysDate])
                    ->andWhere(['Jobs.id IN ' =>  $jobIds]);
                
                $jobs = $this->paginate($jobs);
                
                $resultsFound = TRUE;
            } else
                $resultsFound = FALSE;
        }
        
        $this->set(compact('skills', 'jobs', 'resultsFound'));
        $this->set('_serialize', ['skills', 'jobs', 'resultsFound']);
    }
    
    /**
     * Recommended Jobs method
     *
     * @return \Cake\Network\Response|null
     */
    public function recommendedJobs()
    {        
        // create array of active Job IDs, Job Details and employer details
        $activeJobIds = [];
        $jobTitles = [];
        $jobDescriptions = [];
        $jobDateClosed = [];
        $employerNames = [];
        $developerNames = [];
     
        $todaysDate = new Date();
            
        // get all active jobs with active Employers
        $jobs = $this->Jobs->find('all',[
            'contain' => ['Employers']])
            ->where(['Employers.active' => TRUE])
            ->andWhere(['date_closed >' =>  $todaysDate]);
        
        // check that there are Jobs to process
        if (count($jobs) == 0)
            return $this->Flash->error('No Jobs to process.');
        
        // save requried data for later processing or passing to the view
        foreach($jobs as $job) {
            // add job ID to the active jobs array
            array_push($activeJobIds, $job->id);
            
            // add job title by job Job Id to jobTitles array to pass to view
            $jobTitles[$job->id] = $job->title;
            
            // add Job description by job Job Id to jobDescription array to pass to view
            $jobDescriptions[$job->id] = $job->description;
            
            // add Job closed date by job Job Id to jobDateClosed array to pass to view
            $jobDateClosed[$job->id] = $job->date_closed;
            
            // add Employer name by Employer Id to employerNames array to pass to view
            $employerNames[$job->id] = [$job->employer->id, $job->employer->business_name];
        }
        
        // get job skills for active jobs
        $jobSkills = $this->Jobs->JobSkills->find('all')
            ->where(['job_id IN' => $activeJobIds]);
        
        // check that there are any Skills to process
        if (count($jobSkills) == 0)
            return $this->Flash->error('No Job Skills to process.');
        
        // create and populate Job Skills array for matching. format is [job_id, [skill_id*]]
        $jobSkillsArray = [];
        
        foreach($jobSkills as $jobSkill) {
            if (array_key_exists($jobSkill->job_id, $jobSkillsArray))
                array_push($jobSkillsArray[$jobSkill->job_id], $jobSkill->skill_id);
            else
                $jobSkillsArray[$jobSkill->job_id] = [$jobSkill->skill_id];
        }
        
        //DEBUG: JOB SKILLS ARRAY [JOB ID, [SKILLS ID ARRAY]]
        //var_dump($jobSkillsArray);
        
        // get active developers that user owns
        $developers = $this->loadModel('Developers')->find('all', [
            'contain' => ['DeveloperSkills']])
            ->where(['user_id' => $this->request->Session()->read('Auth.User.id')])
            ->andWhere(['active' => TRUE]);
        
        // check that there are Developers to process
        if (count($developers) == 0)
            return $this->Flash->error('No Developers to process.');
        
        // create and populate Developer Skills array
        $developerSkillsArray = [];
        
        foreach($developers as $developer) {
            // add developer name to developerNames array by developerId
            $developerNames[$developer->id] = $developer->name;
            
            // loop through each developer skill and add it to the developerSkillsArray
            foreach($developer->developer_skills as $devSkill) {
                if (array_key_exists($devSkill->developer_id, $developerSkillsArray))
                    array_push($developerSkillsArray[$devSkill->developer_id], $devSkill->skill_id);
                else
                    $developerSkillsArray[$devSkill->developer_id] = [$devSkill->skill_id];
            }
        }
        
        // DEBUG: DEVELOPER SKILLS ARRAY [DEVELOPER, [SKILLS ID ARRAY]]
        //var_dump($developerSkillsArray);
        
        // create array for matches and match ratio
        $recommendedJobs = [];
        $matchRatio = 0.5;
        
        // for each active job ID compare number of job skills against developer skills.
        // add to recommended jobs if over required ratio    
        foreach ($activeJobIds as $activeJobId) {
            // check if active job's id is in jobSkillsArray, if not skip matching process
            if (!array_key_exists($activeJobId, $jobSkillsArray))
                continue;
            
            $jobSkillsCount = count($jobSkillsArray[$activeJobId]);
            
            // loop through each developer's skills and check if in skills for job
            foreach($developerSkillsArray as $developerId=>$devSkills) {
                $skillsMatchCount = 0;
                $devSkillsCount = count($devSkills);
                
                foreach($devSkills as $devSkill) {
                    // check if skill exists in Job Skills
                    if (in_array($devSkill, $jobSkillsArray[$activeJobId]))
                        $skillsMatchCount++;
                }
                
                // add job to recommended Jobs array if ratio of skills matched : job skills greater or equal to match ratio
                if ($devSkillsCount >= $jobSkillsCount) {
                    // check if ratio of matched skills to job skills is over match ratio
                    if (($skillsMatchCount/$jobSkillsCount) >= $matchRatio) {
                        if (array_key_exists($activeJobId, $recommendedJobs))
                            array_push($recommendedJobs[$activeJobId], $developerId);
                        else
                            $recommendedJobs[$activeJobId] = [$developerId];
                    }
                } else {
                    // check if ratio of matched skills to dev skills is over match ratio
                    if (($skillsMatchCount/$devSkillsCount) >= $matchRatio) {
                        if (array_key_exists($activeJobId, $recommendedJobs))
                            array_push($recommendedJobs[$activeJobId], $developerId);
                        else
                            $recommendedJobs[$activeJobId] = [$developerId];
                    }
                }
            }
            
            //DEBUG: RECOMMENDED JOBS [JOBID, [DEVELOPERS ARRAY]]
            //var_dump($recommendedJobs);   
        }

        //$jobs = $this->paginate($jobs);

        $this->set(compact('recommendedJobs', 'jobTitles', 'jobDescriptions', 'jobDateClosed', 'employerNames', 'developerNames'));
        $this->set('_serialize', ['recommendedJobs', 'jobTitles', 'jobDescriptions', 'jobDateClosed', 'employerNames', 'developerNames']);
    }
}
