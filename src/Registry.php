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
        return isset($this->entries[$name]);
    }
}