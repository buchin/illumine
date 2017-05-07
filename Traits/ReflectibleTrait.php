<?php namespace Illumine\Framework\Traits;

trait ReflectibleTrait
{

    public function reflect()
    {
        return new \ReflectionClass(get_class($this));
    }
}