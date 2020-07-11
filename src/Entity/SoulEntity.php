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
use PSDE\Entity\AbstractEntity;
use PSDE\Entity\Entity;

class SoulEntity extends AbstractEntity {
    protected $abilityScore = [
        "INTELLIGENCE" => 10,
        "WISDOM" => 10,
        "CHARISMA" => 10
    ];
    protected $gender = Sex::NONE;
    protected $age = 18;
    protected $sexualOrientation = 0;
	protected $creatureType = CreatureType::HUMANOID;
    protected $creatureSubType = CreatureSubType::FOX;
    protected $handedness = 0;
    protected $defaultDisposition = [
        "passion" => 0,
        "friendship" => 0,
        "playfulness" => 0,
        "soulmate" => 0,
        "familial" => 0,
        "obsession" => 0,
        "hate" => 0
    ];
    protected $characterDisposition = [];
    protected $dialogue = null;

	public function __construct($id, $networkID, $name = "", $description = "") {
        parent::__construct($id, $networkID);
        $this->setName($name);
	}
	public function setAge($int) {
		if (is_int($int)) {
			$this->age = $int;
		}
        return 0;
	}
	public function getAge() {
		return $this->age;
    }
    public function setDialogue($dialogue) {
        $this->dialogue = $dialogue;
        return 0;
    }
    public function getDialogue() {
        return $this->dialogue;
    }
	public function setGender($int) {
		if (Sex.hasKey($int)) {
			$int = Sex.getValue($int);
		}
		else if (Sex.hasValue($int)) {}
		else {
			return 1;
		}
		$this->gender = $int;
        return 0;
	}
	public function getGender() {
		return $this->gender;
	}
}