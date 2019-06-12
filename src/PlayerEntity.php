<?php
namespace PSDE;

use PSDE\Utils;
use PSDE\Enum;
use PSDE\Enum\Sex;
use PSDE\Enum\Species;
use PSDE\Vector2;
use PSDE\Vector3;

class PlayerEntity {
	private $id = "";
	private $nid = "";
	private $name = "";
	private $age = 18;
	private $sex = Sex::NONE;
	private $species = Species::FOXSKELETON;
	private $meshID = "skeletonN";
	private $materialID = "bone01";
	private $position = null;
	private $rotation = null;
	private $scaling = null;
    private $movementKeys = array("forward"=>false,"shift"=>false,"backward"=>false,"turnLeft"=>false,"turnRight"=>false,"strafeLeft"=>false,"strafeRight"=>false,"jump"=>false);

	public function __construct($id, $networkID, $name = "", $age = 18, $sex = 0, $species = 0, $meshID = "foxSkeletonN", $materialID = "bone01", $position = null, $rotation = null, $scaling = null) {
		$this->setID($id); // UUID
		$this->setNetworkID($networkID); // ConnectionInstance->resourceId
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
	public function setID($id) {
		$this->id = $id;
	}
	public function getID() {
		return $this->id;
	}
	public function setNetworkID($id) {
		$this->nid = $id;
	}
	public function getNetworkID() {
		return $this->nid;
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
	public function setMeshID($string = "foxSkeletonN") {
		$string = preg_replace('/^[\W\-\s\,\/\.]+/', "", $string);
		if (!empty($string)) {
			$this->meshID = $string;
		}
		else {
			$this->meshID = "foxSkeletonN";
		}
	}
	public function getMeshID() {
		return $this->meshID;
	}
	public function setMaterialID($string = "bone01") {
		$string = preg_replace('/^[\W\-\s\,\/\.]+/', "", $string);
		if (!empty($string)) {
			$this->materialID = $string;
		}
		else {
			$this->meshID = "bone01";
		}
	}
	public function getMaterialID() {
		return $this->materialID;
	}
	public function setPosition($position) {
		if ($position instanceof Vector3) {
			$this->position.copyFrom($position);
		}
		else if (is_array($position) && count($position) == 3) {
			$this->position = Vector3::FromArray($position);
		}
		return $this;
	}
	public function getPosition() {
		return $this->position;
	}
	public function setRotation($rotation) {
		if ($rotation instanceof Vector3) {
			$this->rotation.copyFrom($rotation);
		}
		else if (is_array($rotation) && count($rotation) == 3) {
			$this->rotation = Vector3::FromArray($rotation);
		}
		else if (is_int($rotation)) {
			$this->rotation->y = $rotation;
		}
		return $this;
	}
	public function getRotation() {
		return $this->rotation;
	}
	public function setScaling($scaling) {
		if ($scaling instanceof Vector3) {
			$this->scaling.copyFrom($scaling);
		}
		else if (is_array($scaling) && count($scaling) == 3) {
			$this->scaling = Vector3::FromArray($scaling);
		}
		else if (is_int($scaling)) {
			$this->scaling.set($scaling, $scaling, $scaling);
		}
		return $this;
	}
	public function getScaling() {
		return $this->scaling;
	}
	public function setLocRotScale($position, $rotation, $scaling) {
		$this->setPosition($position);
		$this->setRotation($rotation);
		$this->setScaling($scaling);
		return $this;
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
}