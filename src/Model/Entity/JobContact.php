<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * JobContact Entity
 *
 * @property int $id
 * @property int $job_id
 * @property string $email
 * @property string $phone
 * @property string $fax
 * @property string $contact_name
 * @property string $address
 *
 * @property \App\Model\Entity\Job $job
 */
class JobContact extends Entity
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
