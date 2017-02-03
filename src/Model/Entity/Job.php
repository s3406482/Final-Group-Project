<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Job Entity
 *
 * @property int $id
 * @property int $employer_id
 * @property string $title
 * @property string $description
 * @property \Cake\I18n\Time $date_created
 * @property \Cake\I18n\Time $date_closed
 *
 * @property \App\Model\Entity\Employer $employer
 * @property \App\Model\Entity\Application[] $applications
 * @property \App\Model\Entity\JobContact[] $job_contacts
 * @property \App\Model\Entity\JobSkill[] $job_skills
 */
class Job extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
