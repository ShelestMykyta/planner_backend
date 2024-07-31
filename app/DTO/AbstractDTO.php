<?php

namespace App\DTO;

use ReflectionClass;

readonly class AbstractDTO
{
    public function toArray(): array
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();

        $data = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyValue = $property->getValue($this);

            $data[$propertyName] = $propertyValue;
        }

        return $data;
    }
}
