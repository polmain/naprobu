<?php


namespace App\StaticData\Base;


class StaticDataClass implements StaticDataInterface
{
    protected $data;

    public function getData(): array
    {
        return $this->data;
    }
}
