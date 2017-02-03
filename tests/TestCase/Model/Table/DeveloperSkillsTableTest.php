<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DeveloperSkillsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DeveloperSkillsTable Test Case
 */
class DeveloperSkillsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DeveloperSkillsTable
     */
    public $DeveloperSkills;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.developer_skills',
        'app.developers',
        'app.users',
        'app.employers',
        'app.jobs',
        'app.applications',
        'app.job_contacts',
        'app.job_skills',
        'app.skills'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('DeveloperSkills') ? [] : ['className' => 'App\Model\Table\DeveloperSkillsTable'];
        $this->DeveloperSkills = TableRegistry::get('DeveloperSkills', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DeveloperSkills);

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
