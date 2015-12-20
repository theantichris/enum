<?php

namespace theantichris\enum;

use ReflectionClass;

abstract class Enum
{
    /** @var string[]|null */
    private static $constCacheArray = null;

    /**
     * Returns an array of all the constants in the called Enum class.
     *
     * @return string[]
     */
    private static function getConstants()
    {
        if (empty(self::$constCacheArray)) {
            self::$constCacheArray = [];
        }

        $calledClass = get_called_class();

        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect                             = new ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }

        return self::$constCacheArray[$calledClass];
    }

    /**
     * Checks if a constant is a member of the Enum class.
     *
     * @param string $name
     * @param bool   $strict
     *
     * @return bool
     */
    public static function isValidName($name, $strict = false)
    {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));

        return in_array(strtolower($name), $keys);
    }

    /**
     * Checks if a value is assigned to a constant in the Enum class.
     *
     * @param string $value
     *
     * @return bool
     */
    public static function isValidValue($value)
    {
        $values = array_values(self::getConstants());

        return in_array($value, $values, $strict = true);
    }
}