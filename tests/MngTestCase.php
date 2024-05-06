<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test;

use ReflectionException;

class MngTestCase extends TestCase
{
    /**
     * @throws ReflectionException
     */
    protected function getPrivateProperty(object $object, string $propertyName): mixed
    {
        $reflection = new \ReflectionClass($object);
        return $reflection->getProperty($propertyName)->getValue($object);
    }
}
