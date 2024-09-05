<?php

namespace App\Interfaces;

interface BitMapServiceInterface {

    public function set(array $propertyValueSlugs, int $object_id, string $propertySlug, bool $value);

    public function get(array $keys);
}