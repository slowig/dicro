<?php


namespace Dicro;


use Dicro\Exceptions\ClassNotFoundException;

class Container
{
    /**
     * @var Registry
     */
    protected $registry;

    public function __construct()
    {
        $this->registry = new Registry();
    }

    public function register(string $source, string $target = null)
    {
        $this->registry->add(new Entry($source, $target));
    }

    public function resolve(string $needle)
    {
        if (!$this->registry->has($needle)) {
            throw new ClassNotFoundException("Class ".$needle." not found. Did you register it?");
        }
        $target = $this->registry->get($needle)->getTarget();

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