<?php
namespace PSDE;

class Vector3 {
    public $x = 0.0;
    public $y = 0.0;
    public $z = 0.0;
    function __construct($x, $y, $z) {
        $this->x = number_format(floatval($x), 16);
        $this->y = number_format(floatval($y), 16);
        $this->z = number_format(floatval($z), 16);
    }
    function getClassName() {
        return "Vector3";
    }
    function add($otherVector) {
        return new Vector3($this->x + $otherVector->x, $this->y + $otherVector->y, $this->z + $otherVector->z);
    }
    function addInPlace($otherVector) {
        $this->x += $otherVector->x;
        $this->y += $otherVector->y;
        $this->z += $otherVector->z;
        return $this;
    }
    function addToRef($otherVector, $result) {
        $result->x = $this->x + $otherVector->x;
        $result->y = $this->y + $otherVector->y;
        $result->z = $this->z + $otherVector->z;
        return $this;
    }
    function subtract($otherVector) {
        return new Vector3($this->x - $otherVector->x, $this->y - $otherVector->y, $this->z - $otherVector->z);
    }
    function subtractInPlace($otherVector) {
        $this->x -= $otherVector->x;
        $this->y -= $otherVector->y;
        $this->z -= $otherVector->z;
        return $this;
    }
    function subtractToRef($otherVector, $result) {
        $result->x = $this->x - $otherVector->x;
        $result->y = $this->y - $otherVector->y;
        $result->z = $this->z - $otherVector->z;
        return $this;
    }
    function clone() {
        return new Vector3($this->x, $this->y, $this->z);
    }
    function copyFrom($otherVector) {
        $this->x = $otherVector->x;
        $this->y = $otherVector->y;
        $this->z = $otherVector->z;
        return $this;
    }
    function divide($otherVector) {
        return new Vector3($this->x / $otherVector->x, $this->y / $otherVector->y, $this->z / $otherVector->z);
    }
    function divideInPlace($otherVector) {
        $this->x /= $otherVector->x;
        $this->y /= $otherVector->y;
        $this->z /= $otherVector->z;
        return $this;
    }
    function divideToRef($otherVector, $result) {
        $result->x = $this->x / $otherVector->x;
        $result->y = $this->y / $otherVector->y;
        $result->z = $this->z / $otherVector->z;
        return $this;
    }
    function equals($otherVector) {
        return ($this->x == $otherVector->x && $this->y == $otherVector->y && $this->z == $otherVector->z);
    }
    function equalsWithEpsilon($otherVector, $epsilon = Utils::EPSILON) {
        $xDiff = abs($this->x - $otherVector->x);
        $yDiff = abs($this->y - $otherVector->y);
        $zDiff = abs($this->z - $otherVector->z);
        return ($xDiff <= $epsilon && $yDiff <= $epsilon && $zDiff <= $epsilon);
    }
    function floor() {
        return new Vector3(floor($this->x), floor($this->y), floor($this->z));
    }
    function ceil() {
        return new Vector3(ceil($this->x), ceil($this->y), ceil($this->z));
    }
    function length() {
        return sqrt($this->x * $this->x + $this->y * $this->y + $this->z * $this->z);
    }
    function multiply($otherVector) {
        return new Vector3($this->x * $otherVector->x, $this->y * $otherVector->y, $this->z * $otherVector->z);
    }
    function multiplyInPlace($otherVector) {
        $this->x *= $otherVector->x;
        $this->y *= $otherVector->y;
        $this->z *= $otherVector->z;
        return $this;
    }
    function multiplyToRef($otherVector, $result) {
        $result->x = $this->x * $otherVector->x;
        $result->y = $this->y * $otherVector->y;
        $result->z = $this->z * $otherVector->z;
        return $this;
    }
    function negate() {
        return new Vector3(-$this->x, -$this->y, -$this->z);
    }
    function normalize() {
        $length = $this->length();
        if ($length == 0) {
            return $this;
        }
        $number = 1.0/$length;
        $this->x *= $number;
        $this->y *= $number;
        $this->z *= $number;
        return $this;
    }
    function copyFromFloats($x, $y, $z) {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
        return $this;
    }
    function set($x, $y, $z) {
        return $this->copyFromFloats(number_format(floatval($x), 16), number_format(floatval($y), 16), number_format(floatval($z), 16));
    }
    function toArray($array, $index = 0) {
        $array[$index] = $this->x;
        $array[$index + 1] = $this->y;
        $array[$index + 2] = $this->z;
        return $this;
    }
    function asArray() {
        return array($this->x, $this->y, $this->z);
    }
    function toString() {
        return "{X: " . $this->x . " Y:" . $this->y . " Z:" . $this->z . "}";
    }
    static function Distance($vectorA, $vectorB) {
        return sqrt(self::DistanceSquared($vectorA, $vectorB));
    }
    static function DistanceSquared($vectorA, $vectorB) {
        $x = $vectorA->x - $vectorB->x;
        $y = $vectorA->y - $vectorB->y;
        $z = $vectorA->z - $vectorB->z;
        return ($x * $x) + ($y * $y) + ($z * $z);
    }
    static function FromArray($array) {
        return new Vector3($array[0], $array[1], $array[2]);
    }
    static function Lerp($vectorA, $vectorB, $amount) {
        $result = new Vector3(0,0,0);
        Vector3::LerpToRef($vectorA, $vectorB, $amount, $result);
        return $result;
    }
    static function LerpToRef($vectorA, $vectorB, $amount, $result) {
        $result->x = $vectorA->x + (($vectorB->x - $vectorA->x) * $amount);
        $result->y = $vectorA->y + (($vectorB->y - $vectorA->y) * $amount);
        $result->z = $vectorA->z + (($vectorB->z - $vectorA->z) * $amount);
    }
    static function Zero() {
        return new Vector3(0, 0, 0);
    }
    static function One() {
        return new Vector3(1, 1, 1);
    }
}