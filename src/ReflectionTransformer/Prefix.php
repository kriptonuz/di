<?php

declare(strict_types=1);

namespace Cekta\DI\ReflectionTransformer;

use Cekta\DI\ReflectionTransformer;

class Prefix implements ReflectionTransformer
{
    /**
     * @var string
     */
    private $prefix;
    /**
     * @var array<string, string>
     */
    private $replace;

    /**
     * @param string $prefix
     * @param array<string, string> $replace
     */
    public function __construct(string $prefix, array $replace)
    {
        $this->prefix = $prefix;
        $this->replace = $replace;
    }

    /**
     * @param string $name
     * @param array<string, string> $params
     * @return array<string, string>
     */
    public function transform(string $name, array $params): array
    {
        if (strpos($name, $this->prefix) === 0) {
            $params = $this->transformParam($params);
        }
        return $params;
    }

    /**
     * @param array<string, string> $params
     * @return array<string, string>
     */
    private function transformParam(array $params): array
    {
        foreach ($params as $key => $value) {
            if (array_key_exists($value, $this->replace)) {
                $params[$key] = $this->replace[$value];
            }
        }
        return $params;
    }
}
