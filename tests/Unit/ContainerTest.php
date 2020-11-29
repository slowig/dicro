<?php


namespace Tests\Unit;


use Dicro\Container;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    /**
     * @var Container
     */
    protected $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
    }

    public function test_should_register_and_resolve_class_in_container()
    {
        $this->container->register(ExampleInterface::class, ExampleImplementation::class);

        $instance = $this->container->resolve(ExampleInterface::class);

        $this->assertInstanceOf(ExampleImplementation::class, $instance);
    }

    public function test_can_register_class_without_bind_interface()
    {
        $this->container->register(ExampleImplementation::class);

        $instance = $this->container->resolve(ExampleImplementation::class);

        $this->assertInstanceOf(ExampleImplementation::class, $instance);
        $this->assertNotNull($instance);
    }


    public function test_should_resolve_arguments_resolving_class()
    {
        $this->container->register(ExampleImplementation::class);
        $this->container->register(ExampleArgumentsImplementation::class);

        $instanceWithArgument = $this->container->resolve(ExampleArgumentsImplementation::class);

        $this->assertNotNull($instanceWithArgument->argument);
        $this->assertInstanceOf(ExampleImplementation::class, $instanceWithArgument->argument);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->container = null;
    }
}

interface ExampleInterface {}
class ExampleImplementation implements ExampleInterface {}
class ExampleArgumentsImplementation
{
    public $argument;
    public function __construct(ExampleImplementation $example)
    {
        $this->argument = $example;
    }
}