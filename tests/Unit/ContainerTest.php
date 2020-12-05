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

    public function test_should_bind_arguments()
    {
        $this
            ->container
            ->register(ExampleBindingsImplementation::class)
            ->bind([
                'example' => 'binding Test'
            ]);

        $instance = $this->container->resolve(ExampleBindingsImplementation::class);

        $this->assertEquals('binding Test', $instance->example);
    }

    public function test_should_resolve_nested_classes()
    {
        $this->container->register(ExampleImplementation::class);
        $this->container->register(ExampleArgumentsImplementation::class);
        $this->container->register(ExampleBindingsImplementation::class)->bind(['example' => 'any example value']);
        $this->container->register(ExampleNestedArgumentsImplementation::class)->bind(['string' => 'any example string value']);

        $instance = $this->container->resolve(ExampleNestedArgumentsImplementation::class);

        $this->assertNotNull($instance);
        $this->assertEquals('any example string value', $instance->string);
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
class ExampleBindingsImplementation
{
    public $example;
    public function __construct(string $example)
    {
        $this->example = $example;
    }
}
class ExampleNestedArgumentsImplementation
{
    public $class;
    public $string;
    public $bindings;

    public function __construct(ExampleArgumentsImplementation $class, $string, ExampleBindingsImplementation $bindings)
    {
        $this->class = $class;
        $this->string = $string;
        $this->bindings = $bindings;
    }
}