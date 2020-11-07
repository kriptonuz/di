--FILE--
<?php

declare(strict_types=1);

use Cekta\DI\Container;
use Cekta\DI\Provider;

require __DIR__ . '/../../vendor/autoload.php';

class MyContainer extends Container
{
    public function __construct()
    {
        $providers = [];
        $providers[] = new Provider\KeyValue(['test' => 'hello world']);
        parent::__construct(...$providers);
    }
}

$container = new MyContainer();
echo $container->get('test');
--EXPECT--
hello world
