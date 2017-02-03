<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property bool $administrator
 * @property \Cake\I18n\Time $joined
 * @property bool $active
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 *
 * @property \App\Model\Entity\Developer[] $developers
 * @property \App\Model\Entity\Employer[] $employers
 */
class User extends Entity
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

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
	
	protected function _setPassword($value) {
		$hasher = new DefaultPasswordHasher();
		return $hasher->hash($value);
	}
}
