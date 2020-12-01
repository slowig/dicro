<?php

namespace Tests\Unit;

use Dicro\Entry;
use Dicro\Registry;
use PHPUnit\Framework\TestCase;

class RegistryTest extends TestCase
{
    /**
     * @var Registry
     */
    protected $registry;

    protected function setUp(): void
    {
        $this->registry = new Registry();
    }

    public function test_should_add_entry_to_registry()
    {
        $this->registry->add(new Entry('source', 'target'));

        $this->assertTrue($this->registry->has('source'));
    }

    public function test_should_return_target()
    {
        $this->registry->add(new Entry('source', 'target'));

        $this->assertEquals('target', $this->registry->get('source'));
    }

    protected function tearDown(): void
    {
        $this->registry = null;
    }
}