<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DeveloperSkillsFixture
 *
 */
class DeveloperSkillsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'developer_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'skill_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'IX_developer_skills_developer_id' => ['type' => 'index', 'columns' => ['developer_id'], 'length' => []],
            'IX_developer_skills_skill_id' => ['type' => 'index', 'columns' => ['skill_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'UQ_developer_skills' => ['type' => 'unique', 'columns' => ['developer_id', 'skill_id'], 'length' => []],
            'FK_developer_skills_developer_id' => ['type' => 'foreign', 'columns' => ['developer_id'], 'references' => ['developers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'FK_developer_skills_skill_id' => ['type' => 'foreign', 'columns' => ['skill_id'], 'references' => ['skills', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'developer_id' => 1,
            'skill_id' => 1
        ],
    ];
}
