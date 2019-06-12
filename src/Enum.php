<?php
namespace PSDE;

abstract class Enum {
    private static $constCacheArray = NULL;

    protected function __construct() {}

    public static function getConstants() {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        
        return self::$constCacheArray[$calledClass];
    }

    public static function hasKey($key, $strict = false) {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($key, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        
        return in_array(strtolower($key), $keys);
    }

    public static function hasValue($value) {
        $values = array_values(self::getConstants());
        
        return in_array($value, $values, $strict = true);
    }
    
    public static function getValue($key) {
        if (self::isValidKey($key))
            return self::getConstants()[$key];
        else
            return 1;
    }
    public static function getKey($value) {
        $results = "NONE";
        if (is_numeric($value)) {
            if (array_key_exists($value, $resultsSearch = array_flip(self::getConstants()))) {
                $resultsSearch = array_flip(self::getConstants())[$value];
                if (strlen($results) > 1)
                    $results = $resultsSearch;
            }
            else
                $results = "NONE";
        }
        return $results;
    }
}
