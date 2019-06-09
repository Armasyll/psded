<?php
namespace PSDE;

use PSDE\Utils;

class Player {
	private $id = "";
	private $nid = "";
	private $name = "";
	private $age = 18;
	private $sex = 0;
	private $species = 0;
	private $meshID = null;
	private $materialID = null;
	private $position = array("x"=>0.000000000000000,"y"=>0.000000000000000,"z"=>0.000000000000000);
	private $rotation = array("x"=>0.000000000000000,"y"=>0.000000000000000,"z"=>0.000000000000000);
	private $scaling = array("x"=>1.000000000000000,"y"=>1.000000000000000,"z"=>1.000000000000000);
    private $movementKeys = array("forward"=>false,"shift"=>false,"backward"=>false,"turnLeft"=>false,"turnRight"=>false,"strafeLeft"=>false,"strafeRight"=>false,"jump"=>false);

	public function __construct($id, $networkID, $name = "", $age = 18, $sex = 0, $species = 0, $meshID = "foxSkeletonN", $materialID = "bone01") {
		$this->setID($id);
		$this->setNetworkID($networkID);
		$this->setName($name);
		$this->setAge($age);
		$this->setSex($sex);
		$this->setSpecies($species);
		$this->setMeshID($meshID);
		$this->setMaterialID($materialID);
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
	public function setPosition($x = 0, $y = 0, $z = 0) {
		if (array_key_exists("x", $x) && array_key_exists("y", $x) && array_key_exists("z", $x)) {
			$this->position = $x;
		}
		else {
			$this->position["x"] = $x;
			$this->position["y"] = $y;
			$this->position["z"] = $z;
		}
	}
	public function getPosition() {
		return $this->position;
	}
	public function setRotation($x = 0, $y = 0, $z = 0) {
		if (array_key_exists("x", $x) && array_key_exists("y", $x) && array_key_exists("z", $x)) {
			$this->rotation = $x;
		}
		else {
			$this->rotation["x"] = $x;
			$this->rotation["y"] = $y;
			$this->rotation["z"] = $z;
		}
	}
	public function getRotation() {
		return $this->rotation;
	}
	public function setScaling($x = 1, $y = 1, $z = 1) {
		if (array_key_exists("x", $x) && array_key_exists("y", $x) && array_key_exists("z", $x)) {
			$this->scaling = $x;
		}
		else {
			$this->scaling["x"] = $x;
			$this->scaling["y"] = $y;
			$this->scaling["z"] = $z;
		}
	}
	public function getScaling() {
		return $this->scaling;
	}
	public function setLocRotScale($position = array("x"=>0,"y"=>0,"z"=>0), $rotation = array("x"=>0,"y"=>0,"z"=>0), $scaling = array("x"=>0,"y"=>0,"z"=>0)) {
		$this->setPosition($position);
		$this->setRotation($rotation);
		$this->setScaling($scaling);
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
			$this->position,
			$this->rotation,
			$this->movementKeys
		);
	}
	public function getLocRotScale() {
		return array(
			$this->nid,
			$this->position,
			$this->rotation,
			$this->scaling,
			$this->movementKeys
		);
	}
	public function getAll() {
		return array(
			"id"=>$this->id,
			"nid"=>$this->nid,
			"name"=>$this->name,
			"age"=>$this->age,
			"sex"=>$this->sex,
			"species"=>$this->species,
			"meshID"=>$this->mesh,
			"materialID"=>$this->materialID,
			"position"=>$this->position,
			"rotation"=>$this->rotation,
			"scaling"=>$this->scaling,
			"movementKeys"=>$this->movementKeys
		);
	}
}