<?php
namespace PSDE;

use PSDE\Utils;
use PSDE\Enum;
use PSDE\Enum\EntityEnum;
use PSDE\Vector2;
use PSDE\Vector3;

abstract class AbstractEntity {
	protected $id = "";
    protected $nid = "";
	protected $entityType = 0;
	protected $name = "";
	protected $description = "";

    public function __construct($id, $networkID, $name = "", $description = "") {
        $this->entityType = EntityEnum::ABSTRACT;
		$this->setID($id); // UUID
        $this->setNetworkID($networkID); // ConnectionInstance->resourceId
    }
	public function setID($id) {
		$this->id = $id;
        return 0;
	}
	public function getID() {
		return $this->id;
	}
	public function setNetworkID($id) {
		$this->nid = $id;
        return 0;
	}
	public function getNetworkID() {
		return $this->nid;
    }
	public function setName($string) {
		$this->name = preg_replace('/^[\W\-\s\,]+/', "", $string);
        return 0;
	}
	public function getName() {
		return $this->name;
	}
	public function setDescription($string) {
		$this->description = preg_replace('/^[\W\-\s\,\.\!\?\d]+/', "", $string);
        return 0;
	}
	public function getDescription() {
		return $this->description;
	}
	public function setEntityType($entityType) {
		if (EntityEnum::hasValue($entityType)) {
			$entityType = EntityEnum::getValue($entityType);
		}
		else if (EntityEnum::hasKey($entityType)) {}
		$this->entityType = $entityType;
        return 0;
	}
	public function getEntityType() {
		return $this->entityType;
	}
}