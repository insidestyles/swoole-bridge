<?php

namespace Insidestyles\SwooleBridge\TTests\Base;

class TestUtils
{
    public static function getMethod($name, $object)
    {
        $class = new \ReflectionClass(get_class($object));
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    public static function getProperty($property, $object)
    {
        $class = new \ReflectionClass(get_class($object));
        $property = $class->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    public static function setProperty($property, $value, $object)
    {
        $class = new \ReflectionClass(get_class($object));
        $property = $class->getProperty($property);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    /**
     * recursive detect and parse iterator object in array
     * @param array $array
     */
    public static function parseIteratorArray(array &$array)
    {
        if (!empty($array)) {
            foreach ($array as &$item) {
                if (is_array($item)) {
                    self::parseIteratorArray($item);
                } elseif ($item instanceof \Iterator) {
                    $item = iterator_to_array($item);
                    self::parseIteratorArray($item);
                }
            }
        }
    }
}