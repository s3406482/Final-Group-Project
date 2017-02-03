<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DeveloperSkills Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Developers
 * @property \Cake\ORM\Association\BelongsTo $Skills
 *
 * @method \App\Model\Entity\DeveloperSkill get($primaryKey, $options = [])
 * @method \App\Model\Entity\DeveloperSkill newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DeveloperSkill[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DeveloperSkill|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DeveloperSkill patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DeveloperSkill[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DeveloperSkill findOrCreate($search, callable $callback = null)
 */
class DeveloperSkillsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('developer_skills');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Developers', [
            'foreignKey' => 'developer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Skills', [
            'foreignKey' => 'skill_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['developer_id'], 'Developers'));
        $rules->add($rules->existsIn(['skill_id'], 'Skills'));

        return $rules;
    }
}
