<?php
namespace PSDE;

use PSDE\Utils;
use PSDE\Enum;
use PSDE\Enum\EntityEnum;
use PSDE\Enum\Sex;
use PSDE\Enum\CreatureTypeEnum;
use PSDE\Enum\CreatureSubTypeEnum;
use PSDE\Vector2;
use PSDE\Vector3;
use PSDE\AbstractEntity;
use PSDE\Entity;

class PlayerEntity extends Entity {
    protected $name = "";
	protected $creatureType = CreatureType::HUMANOID;
	protected $creatureSubType = CreatureSubType::FOX;
    protected $sex = Sex::NONE;
    protected $age = 18;
	protected $height = 1.2;
    protected $movementKeys = 0x0;

	public function __construct($id, $networkID, $name = "", $creatureType = 0, $creatureSubType = 0, $sex = 0, $age = 18, $meshID = "foxSkeletonN", $materialID = "bone01", $position = null, $rotation = null, $scaling = null) {
		parent::__construct($id, $networkID);
		$this->entityType = EntityEnum::CHARACTER;
		$this->setName($name);
		$this->setCreatureType($creatureType);
		$this->setCreatureSubType($creatureSubType);
        $this->setSex($sex);
        $this->setAge($age);
		$this->setMeshID($meshID);
		$this->setMaterialID($materialID);
		$this->setPosition($position);
		$this->setRotation($rotation);
		$this->setScaling($scaling);
	}
	public function setName($string) {
		$this->name = preg_replace('/^[\W\-\s\,]+/', "", $string);
	}
	public function getName() {
		return $this->name;
	}
	public function setAge($int) {
		if (is_int($int)) {
			$this->age = $int;
		}
	}
	public function getAge() {
		return $this->age;
	}
	public function setSex($int) {
		if (is_int($int)) {
			if ($int == 2) {
				$this->sex = 2;
			}
			else {
				$this->sex = 1;
			}
		}
		else {
			if (strtolower(mb_substr($int, 0, 1)) == "f") {
				$this->sex = 2;
			}
			else {
				$this->sex = 1;
			}
		}
	}
	public function getSex() {
		return $this->sex;
	}
	public function setCreatureType($number) {
		$this->creatureType = $number;
	}
	public function getCreatureType() {
		return $this->creatureType;
	}
	public function setCreatureSubType($number) {
		$this->creatureSubType = $number;
	}
	public function getCreatureSubType() {
		return $this->creatureSubType;
	}
	public function setHeight($number) {
		$this->height = $number;
	}
	public function getHeight() {
		return $this->height;
	}
	public function getMovementKeys() {
		return $this->movementKeys;
	}
	public function setMovementKeys($movementKeys) {
		$this->movementKeys = $movementKeys;
	}
	public function getLocRot() {
		return array(
			$this->nid,
			$this->position->asArray(),
			$this->rotation->asArray(),
			$this->movementKeys
		);
	}
	public function getLocRotScale() {
		return array(
			$this->nid,
			$this->position->asArray(),
			$this->rotation->asArray(),
			$this->scaling->asArray(),
			$this->movementKeys
		);
	}
	public function getAll() {
		return array(
			$this->nid,
			$this->id,
			$this->name,
			$this->creatureType,
			$this->creatureSubType,
            $this->sex,
            $this->age,
			$this->meshID,
			$this->materialID,
			$this->position->asArray(),
			$this->rotation->asArray(),
			$this->scaling->asArray(),
			$this->movementKeys
		);
	}
	public function getArmourClass() {
		return 0;
	}
}