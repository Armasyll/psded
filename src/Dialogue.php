<?php
namespace PSDE;

use PSDE\Utils;
use PSDE\Entity\AbstractEntity;
use PSDE\Entity\Entity;
use PSDE\Entity\SoulEntity;
use PSDE\Entity\PlayerEntity;

class Dialogue {
    protected $id = "";
    protected $title = "";
    protected $text = "";
    protected $options = []; // >:L i refuse to implement variable functions

	public function __construct($id, $title = "", $text = "") {
        $this->setID($id);
        $this->setTitle($title);
        $this->setText($text);
	}
	public function setID($id) {
		$this->id = $id;
        return 0;
	}
	public function getID() {
		return $this->id;
	}
	public function setTitle($title) {
		$this->title = $title;
        return 0;
	}
	public function getTitle() {
		return $this->title;
	}
	public function setText($text) {
		$this->text = $text;
        return 0;
	}
	public function getText() {
		return $this->text;
    }
    public function hasOptions() {
        return count($this->options) > 0;
    }
    public function getOptions() {
        return $this->options;
    }
    public function setOptions($id, $dialogue, $title, $condition) {
        return 0;
        // read angery comments
    }
}
class DialogueOptions {
    protected $id = "";
    protected $dialogue = null;
    protected $title = "";
    protected $condition = null; // >:L i refuse to implement a variable function

    public function __construct($id, $dialogue, $title, $condition) {

    }
}