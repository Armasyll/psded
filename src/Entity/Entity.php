<?php
namespace PSDE;

use PSDE\Utils;
use PSDE\Enum;
use PSDE\Enum\EntityEnum;
use PSDE\Vector2;
use PSDE\Vector3;
use PSDE\AbstractEntity;

class Entity extends AbstractEntity {
	protected $meshID = "skeletonN";
	protected $materialID = "bone01";
	protected $position = null;
	protected $rotation = null;
	protected $scaling = null;

    public function __construct($id, $networkID) {
        parent::__construct($id, $networkID);
        $this->entityType = EntityEnum::ENTITY;
        $this->position = Vector3::Zero();
        $this->rotation = Vector3::Zero();
        $this->scaling = Vector3::Zero();
    }
	public function setMeshID($string = "foxSkeletonN") {
		$string = preg_replace('/^[\W\-\s\,\/\.]+/', "", $string);
		if (!empty($string)) {
			$this->meshID = $string;
		}
		else {
			$this->meshID = "foxSkeletonN";
		}
        return 0;
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
        return 0;
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
    public function calcMovePOV($amountRight, $amountUp, $amountForward) {
        return false;
    }
}