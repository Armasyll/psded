<?php
namespace PSDE;

class Vector2 {
    public $x;
    public $y;
    function __construct($x, $y) {
        $this->x = number_format(floatval($x), 16);
        $this->y = number_format(floatval($y), 16);
    }
    function getClassName() {
        return "Vector2";
    }
    function add($otherVector) {
        return new Vector2($this->x + $otherVector->x, $this->y + $otherVector->y);
    }
    function addInPlace($otherVector) {
        $this->x += $otherVector->x;
        $this->y += $otherVector->y;
        return $this;
    }
    function addToRef($otherVector, $result) {
        $result->x = $this->x + $otherVector->x;
        $result->y = $this->y + $otherVector->y;
        return $this;
    }
    function subtract($otherVector) {
        return new Vector2($this->x - $otherVector->x, $this->y - $otherVector->y);
    }
    function subtractInPlace($otherVector) {
        $this->x -= $otherVector->x;
        $this->y -= $otherVector->y;
        return $this;
    }
    function subtractToRef($otherVector, $result) {
        $result->x = $this->x - $otherVector->x;
        $result->y = $this->y - $otherVector->y;
        return $this;
    }
    function clone() {
        return new Vector2($this->x, $this->y);
    }
    function copyFrom($otherVector) {
        $this->x = $otherVector->x;
        $this->y = $otherVector->y;
        return $this;
    }
    function divide($otherVector) {
        return new Vector2($this->x / $otherVector->x, $this->y / $otherVector->y);
    }
    function divideInPlace($otherVector) {
        $this->x /= $otherVector->x;
        $this->y /= $otherVector->y;
        return $this;
    }
    function divideToRef($otherVector, $result) {
        $result->x = $this->x / $otherVector->x;
        $result->y = $this->y / $otherVector->y;
        return $this;
    }
    function equals($otherVector) {
        return ($this->x == $otherVector->x && $this->y == $otherVector->y);
    }
    function equalsWithEpsilon($otherVector, $epsilon = Utils::EPSILON) {
        $xDiff = abs($this->x - $otherVector->x);
        $yDiff = abs($this->y - $otherVector->y);
        return ($xDiff <= $epsilon && $yDiff <= $epsilon);
    }
    function floor() {
        return new Vector2(floor($this->x), floor($this->y));
    }
    function ceil() {
        return new Vector2(ceil($this->x), ceil($this->y));
    }
    function length() {
        return sqrt($this->x * $this->x + $this->y * $this->y);
    }
    function multiply($otherVector) {
        return new Vector2($this->x * $otherVector->x, $this->y * $otherVector->y);
    }
    function multiplyInPlace($otherVector) {
        $this->x *= $otherVector->x;
        $this->y *= $otherVector->y;
        return $this;
    }
    function multiplyToRef($otherVector, $result) {
        $result->x = $this->x * $otherVector->x;
        $result->y = $this->y * $otherVector->y;
        return $this;
    }
    function negate() {
        return new Vector2(-$this->x, -$this->y);
    }
    function normalize() {
        $length = $this->length();
        if ($length == 0) {
            return $this;
        }
        $number = 1.0/$length;
        $this->x *= $number;
        $this->y *= $number;
        return $this;
    }
    function copyFromFloats($x, $y) {
        $this->x = $x;
        $this->y = $y;
        return $this;
    }
    function set($x, $y) {
        return $this->copyFromFloats(number_format(floatval($x), 16), number_format(floatval($y), 16));
    }
    function toArray($array = array(), $index = 0) {
        $array[$index] = $this->x;
        $array[$index + 1] = $this->y;
        return $this;
    }
    function asArray() {
        $array = array();
        $this->toArray($array, 0);
        return $array;
    }
    function toString() {
        return "{X: " . $this->x . " Y:" . $this->y . "}";
    }
    static function Distance($vectorA, $vectorB) {
        return sqrt(self::DistanceSquared($vectorA, $vectorB));
    }
    static function DistanceSquared($vectorA, $vectorB) {
        $x = $vectorA->x - $vectorB->x;
        $y = $vectorA->y - $vectorB->y;
        return ($x * $x) + ($y * $y);
    }
    static function FromArray($array) {
        return new Vector2($array[0], $array[1]);
    }
    static function FromVector3($otherVector, $swapYAndZ = false) {
        if ($swapYAndZ) {
            return new Vector2($otherVector->x, $otherVector->z);
        }
        return new Vector2($otherVector->x, $otherVector->y);
    }
    static function Lerp($vectorA, $vectorB, $amount) {
        $x = $vectorA->x + (($vectorB->x - $vectorA->x) * $amount);
        $y = $vectorA->y + (($vectorB->y - $vectorA->y) * $amount);
        return new Vector2($x, $y);
    }
    static function Zero() {
        return new Vector2(0, 0);
    }
    static function One() {
        return new Vector2(1, 1);
    }
}