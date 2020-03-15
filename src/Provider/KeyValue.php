<?php

declare(strict_types=1);

namespace Cekta\DI\Provider;

use Cekta\DI\Loader\Alias;
use Cekta\DI\Provider\Exception\NotFound;
use Cekta\DI\ProviderInterface;
use InvalidArgumentException;

class KeyValue implements ProviderInterface
{
    /**
     * @var array
     */
    private $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public static function stringToAlias(array $values): self
    {
        $result = [];
        foreach ($values as $key => $value) {
            if (is_string($value)) {
                $value = new Alias($value);
            }
            $result[$key] = $value;
        }
        return new static($result);
    }

    public static function stringToType(array $params): self
    {
        foreach ($params as $key => $value) {
            $params[$key] = self::transform($value);
        }
        return new static($params);
    }

    public static function compile(string $compiledFile, callable $callable): self
    {
        if (!is_readable($compiledFile)) {
            if (!is_writable(dirname($compiledFile))) {
                throw new InvalidArgumentException("`$compiledFile` must be writable");
            }
            file_put_contents($compiledFile, call_user_func($callable));
        }
        /** @noinspection PhpIncludeInspection */
        return new static(require $compiledFile);
    }

    public function provide(string $id)
    {
        if (!$this->canProvide($id)) {
            throw new NotFound($id);
        }
        return $this->values[$id];
    }

    public function canProvide(string $id): bool
    {
        return array_key_exists($id, $this->values);
    }

    private static function transform($value)
    {
        if (is_string($value)) {
            if (preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
                $value = $matches[2];
            }
            $value = self::transformString($value);
        }
        return $value;
    }

    private static function transformString(string $value)
    {
        switch (strtolower($value)) {
            case '(true)':
            case 'true':
                $value = true;
                break;
            case '(false)':
            case 'false':
                $value = false;
                break;
            case '(null)':
            case 'null':
                $value = null;
                break;
            case '(empty)':
            case 'empty':
                $value = '';
                break;
        }
        return $value;
    }
}
