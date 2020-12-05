<?php


namespace Dicro;


class Entry
{
    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $target;

    /**
     * @var array
     */
    protected $arguments;

    /**
     * Entry constructor.
     * @param string $source
     * @param string|null $target
     */
    public function __construct(string $source, string $target = null)
    {
        $this->source = $source;
        $this->target = ($target) ? $target : $source;
        if ($target == null) {
            $this->hasInterface = false;
        }
        $this->arguments = [];
    }

    /**
     * @param array $arguments
     */
    public function bind(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return array
     */
    public function getBindings()
    {
        return $this->arguments;
    }

    /**
     * @return array
     */
    public function getBoundArgumentNames()
    {
        return array_keys($this->getBindings());
    }

    /**
     * @param $name
     * @return bool
     */
    public function isBound($name)
    {
        return in_array($name, $this->getBoundArgumentNames());
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getBoundValue($name)
    {
        return $this->getBindings()[$name];
    }
}