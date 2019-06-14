<?php
namespace PSDE;

use PSDE\Utils;
use PSDE\Enum;
use PSDE\Enum\EntityEnum;
use PSDE\Enum\Sex;
use PSDE\Enum\Species;
use PSDE\Vector2;
use PSDE\Vector3;
use PSDE\AbstractEntity;
use PSDE\Entity;

class PlayerEntity extends Entity {
    protected $name = "";
	protected $age = 18;
	protected $sex = Sex::NONE;
	protected $species = Species::FOXSKELETON;
	protected $height = 1.2;
    protected $movementKeys = array("forward"=>false,"shift"=>false,"backward"=>false,"turnLeft"=>false,"turnRight"=>false,"strafeLeft"=>false,"strafeRight"=>false,"jump"=>false);

	public function __construct($id, $networkID, $name = "", $age = 18, $sex = 0, $species = 0, $meshID = "foxSkeletonN", $materialID = "bone01", $position = null, $rotation = null, $scaling = null) {
		parent::__construct($id, $networkID);
		$this->entityType = EntityEnum::CHARACTER;
		$this->setName($name);
		$this->setAge($age);
		$this->setSex($sex);
		$this->setSpecies($species);
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
	public function setSpecies($number) {
		$this->species = $number;
	}
	public function getSpecies() {
		return $this->species;
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
		$this->movementKeys["forward"] = $movementKeys["forward"] === true;
		$this->movementKeys["shift"] = $movementKeys["shift"] === true;
		$this->movementKeys["backward"] = $movementKeys["backward"] === true;
		$this->movementKeys["turnRight"] = $movementKeys["turnRight"] === true;
		$this->movementKeys["turnLeft"] = $movementKeys["turnLeft"] === true;
		$this->movementKeys["strafeRight"] = $movementKeys["strafeRight"] === true;
		$this->movementKeys["strafeLeft"] = $movementKeys["strafeLeft"] === true;
		$this->movementKeys["jump"] = $movementKeys["jump"] === true;
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
			$this->age,
			$this->sex,
			$this->species,
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