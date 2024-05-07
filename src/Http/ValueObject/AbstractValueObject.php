<?php

declare(strict_types=1);

namespace H22k\MngKargo\Http\ValueObject;

use H22k\MngKargo\Contract\HttpValue;

abstract class AbstractValueObject implements HttpValue
{
    /**
     * @var array<string, string|int|bool> $data
     */
    protected array $data;

    /**
     * @param array<string, string|int|bool> $data
     */
    public function __construct(array|object $data)
    {
        if (is_object($data)) {
            if (!method_exists($data, 'toArray')) {
                throw new \InvalidArgumentException('Data object must have a toArray method');
            }
            $data = $data->toArray();
        }

        $this->data = $data;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function add(string $key, bool|int|string $value): static
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }
}
