<?php

namespace App\Entity\Collection;

use App\Entity\Collection\Base\NaprobuMutableCollection;
use App\Entity\Country;
use App\StaticData\CountryData;
use ArrayIterator;
use Traversable;

/**
 * @method Country[]|ArrayIterator|Traversable getIterator()
 * @method Country|null                        next()
 * @method Country|null                        current()
 * @method Country|null                        first()
 * @method Country|null                        last()
 */
class CountryCollection extends NaprobuMutableCollection
{
    public static function getClassName(): string
    {
        return Country::class;
    }

    public static function buildCollection(): CountryCollection
    {
        $countryDataArray = new CountryData();

        $countryCollection = new self();

        foreach ($countryDataArray as $countryData){
            $country = Country::createFromArray($countryData);
            $countryCollection->add($country);
        }

        return $countryCollection;
    }
}
