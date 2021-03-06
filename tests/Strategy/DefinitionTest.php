<?php

declare(strict_types=1);

namespace Cekta\DI\Test\Strategy;

use Cekta\DI\Strategy\Definition;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use stdClass;

class DefinitionTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $container;

    protected function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
    }

    public function testGetClosure(): void
    {
        $this->container->method('get')->willReturn(123);
        assert($this->container instanceof ContainerInterface);
        $compile = new Definition(
            [
                'a' => function (ContainerInterface $container) {
                    $result = new stdClass();
                    $result->a = $container->get('a');
                    return $result;
                }
            ],
            $this->container
        );
        $result = $compile->get('a');
        $this->assertInstanceOf(stdClass::class, $result);
        $this->assertSame(123, $result->a);
    }

    public function testGetNotClosure(): void
    {
        assert($this->container instanceof ContainerInterface);
        $compile = new Definition(['a' => 123], $this->container);
        $this->assertSame(123, $compile->get('a'));
    }
}
