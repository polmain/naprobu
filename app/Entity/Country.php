<?php

namespace App\Entity;

use App\Entity\Common\DataClassInterface;

class Country implements DataClassInterface
{
    private const NAME_KEY = 'name';
    private const CODE_KEY = 'code';
    private const FLAG_KEY = 'flag';

    /** @var string $name */
    private $name;

    /** @var string $code */
    private $code;

    /** @var string $flag */
    private $flag;

    private function __construct(string $name, string $code, string $flag)
    {
        $this->name = $name;
        $this->code = $code;
        $this->flag = $flag;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getFlag(): string
    {
        return $this->flag;
    }

    public static function createFromArray(array $data): DataClassInterface
    {
        return new self(
            $data[self::NAME_KEY],
            $data[self::CODE_KEY],
            $data[self::FLAG_KEY]
        );
    }
}
