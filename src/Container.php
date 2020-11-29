<?php


namespace Dicro;


class Container
{
    protected $interfacesMap = [];

    public function register(string $name, string $implementation = null)
    {
        if ($implementation === null) $implementation = $name;
        $this->interfacesMap[$name] = $implementation;
    }

    public function resolve(string $needle)
    {
        $target = $this->interfacesMap[$needle];

        $targetReflection = new \ReflectionClass($target);
        $targetReflectionConstructor = $targetReflection->getConstructor();

        if (!$targetReflectionConstructor || count($targetReflectionConstructor->getParameters()) === 0) return $targetReflection->newInstance();

        $argumentsInstanceList = [];
        foreach ($targetReflectionConstructor->getParameters() as $parameter) {
            $argumentsInstanceList[] = $this->resolve($parameter->getClass()->getName());
        }

        return $targetReflection->newInstance(...$argumentsInstanceList);
    }
}