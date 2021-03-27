<?php


namespace App\Entity\Common;


interface DataClassInterface
{
    public static function createFromArray(array $data): DataClassInterface;
}
