<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * JobContacts Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Jobs
 *
 * @method \App\Model\Entity\JobContact get($primaryKey, $options = [])
 * @method \App\Model\Entity\JobContact newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\JobContact[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\JobContact|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\JobContact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\JobContact[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\JobContact findOrCreate($search, callable $callback = null)
 */
class JobContactsTable extends Table
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

        $this->table('job_contacts');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Jobs', [
            'foreignKey' => 'job_id',
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

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->allowEmpty('phone');

        $validator
            ->allowEmpty('fax');

        $validator
            ->requirePresence('contact_name', 'create')
            ->notEmpty('contact_name');

        $validator
            ->allowEmpty('address');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['job_id'], 'Jobs'));

        return $rules;
    }
}
