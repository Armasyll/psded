<?php
namespace PSDE;

use PSDE\Utils;

class Player {
	private $id = "";
	private $nid = "";
	private $name = "";
	private $mesh = "foxSkeletonN";
	private $position = array("x"=>0.000000000000000,"y"=>0.000000000000000,"z"=>0.000000000000000);
	private $rotation = array("x"=>0.000000000000000,"y"=>0.000000000000000,"z"=>0.000000000000000);
	private $scaling = array("x"=>1.000000000000000,"y"=>1.000000000000000,"z"=>1.000000000000000);
    private $moveForward = false;
    private $moveBackward = false;
    private $runForward = false;
    private $strafeRight = false;
    private $strafeLeft = false;
    private $turnRight = false;
    private $turnLeft = false;
    private $jump = false;

	public function __construct($id, $networkID, $mesh = "foxSkeletonN", $position = array("x"=>0,"y"=>0,"z"=>0), $rotation = array("x"=>0,"y"=>0,"z"=>0), $scaling = array("x"=>0,"y"=>0,"z"=>0)) {
		echo sprintf("Creating new Player (%s, %s, %s, %s, %s)\n", $id, $mesh, json_encode($position, true), json_encode($rotation, true), json_encode($scaling, true));
		$this->setID($id);
		$this->setNetworkID($networkID);
		$this->setMesh($mesh);
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
	public function setMesh($mesh) {
		switch ($mesh) {
			case "foxM" : {
				$this->mesh = "foxM";
				break;
			}
			case "foxSkeletonM" : {
				$this->mesh = "foxSkeletonM";
				break;
			}
			case "foxSkeletonN" : {
				$this->mesh = "foxSkeletonN";
				break;
			}
			default : {
				$this->mesh = "foxSkeletonN";
			}
		}
	}
	public function getMesh() {
		return $this->mesh;
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
	public function setMovementStatus($moveForward, $moveBackward, $runForward, $strafeRight, $strafeLeft, $turnRight, $turnLeft, $jump) {
		$this->moveForward = $moveForward;
		$this->moveBackward = $moveBackward;
		$this->runForward = $runForward;
		$this->strafeRight = $strafeRight;
		$this->strafeLeft = $strafeLeft;
		$this->turnRight = $turnRight;
		$this->turnLeft = $turnLeft;
		$this->jump = $jump;
	}
	public function getLocRot() {
		return array(
			$this->nid,
			$this->position,
			$this->rotation,
			$this->moveForward,
			$this->moveBackward,
			$this->runForward,
			$this->strafeRight,
			$this->strafeLeft,
			$this->turnRight,
			$this->turnLeft,
			$this->jump
		);
	}
	public function getLocRotScale() {
		return array(
			$this->nid,
			$this->position,
			$this->rotation,
			$this->scaling,
			$this->moveForward,
			$this->moveBackward,
			$this->runForward,
			$this->strafeRight,
			$this->strafeLeft,
			$this->turnRight,
			$this->turnLeft,
			$this->jump
		);
	}
	public function getAll() {
		return array(
			$this->id,
			$this->nid,
			$this->name,
			$this->mesh,
			$this->position,
			$this->rotation,
			$this->scaling,
			$this->moveForward,
			$this->moveBackward,
			$this->runForward,
			$this->strafeRight,
			$this->strafeLeft,
			$this->turnRight,
			$this->turnLeft,
			$this->jump
		);
	}
}