<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\JobContactsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\JobContactsTable Test Case
 */
class JobContactsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\JobContactsTable
     */
    public $JobContacts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.job_contacts',
        'app.jobs',
        'app.employers',
        'app.users',
        'app.developers',
        'app.applications',
        'app.developer_skills',
        'app.job_skills'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('JobContacts') ? [] : ['className' => 'App\Model\Table\JobContactsTable'];
        $this->JobContacts = TableRegistry::get('JobContacts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->JobContacts);

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
