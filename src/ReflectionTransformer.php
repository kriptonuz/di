<?php

declare(strict_types=1);

namespace Cekta\DI;

interface ReflectionTransformer
{
    /**
     * @param string $name
     * @param array<string, string> $params
     * @return array<string, string>
     */
    public function transform(string $name, array $params): array;
}
