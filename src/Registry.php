<?php


namespace Dicro;


class Registry
{
    protected $entries;

    public function __construct()
    {
        $this->entries = [];
    }

    /**
     * @param Entry $entry
     */
    public function add(Entry $entry)
    {
        $this->entries[$entry->getSource()] = $entry;
    }

    public function has(string $name)
    {
        return isset($this->entries[$name]) && $this->entries[$name] !== null;
    }

    public function get(string $needle)
    {
        if (!$this->has($needle)) return null;

        return $this->entries[$needle]->getTarget();
    }
}