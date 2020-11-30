<?php


namespace Dicro;


class Entry
{
    /**
     * @var string
     */
    protected $source;
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
        $this->source = ($target) ? $target : $source;
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
}