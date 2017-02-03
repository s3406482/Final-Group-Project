<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\JobSkillsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\JobSkillsTable Test Case
 */
class JobSkillsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\JobSkillsTable
     */
    public $JobSkills;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.job_skills',
        'app.skills',
        'app.developer_skills',
        'app.developers',
        'app.users',
        'app.employers',
        'app.jobs',
        'app.applications',
        'app.job_contacts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('JobSkills') ? [] : ['className' => 'App\Model\Table\JobSkillsTable'];
        $this->JobSkills = TableRegistry::get('JobSkills', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->JobSkills);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
