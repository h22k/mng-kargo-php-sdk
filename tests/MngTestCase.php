<?php

declare(strict_types=1);

namespace H22k\MngKargo\Test;

trait MngTestCase
{
    protected function getPrivateProperty(object $object, string $propertyName): mixed
    {
        $reflection = new \ReflectionClass($object);
        $property = $reflection->getProperty($propertyName);

        return $property->getValue($object);
    }
}
