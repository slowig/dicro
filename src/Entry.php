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
     * @var bool
     */
    protected $hasInterface = true;
    /**
     * @var array
     */
    protected $arguments;

    public function __construct(string $source, string $target = null)
    {
        $this->source = $source;
        $this->target = ($target) ? $target : $source;
        if ($target == null) {
            $this->hasInterface = false;
        }
    }

    public function bind(array $arguments)
    {
        $this->arguments = $arguments;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getTarget()
    {
        return $this->target;
    }
}