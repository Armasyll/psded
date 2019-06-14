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

    public function __construct($id, $networkID) {
        $this->entityType = EntityEnum::ABSTRACT;
		$this->setID($id); // UUID
        $this->setNetworkID($networkID); // ConnectionInstance->resourceId
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
}