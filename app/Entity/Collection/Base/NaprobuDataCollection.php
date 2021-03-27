<?php


namespace App\Entity\Collection\Base;

use App\Entity\Common\DataClassInterface;
use App\StaticData\Base\StaticDataInterface;
use ArrayIterator;
use Traversable;

/**
 * @method ArrayIterator|Traversable getIterator()
 * @method                           next()
 * @method                           current()
 * @method                           first()
 * @method                           last()
 * @method                           get($key)
 */
abstract class NaprobuDataCollection extends NaprobuImmutableCollection
{
    public static function getDataClassName(): ?string
    {
        return null;
    }

    public static function buildCollection(): NaprobuBaseCollection
    {
        $class = get_called_class();
        $dataCollection = new $class();

        /** @var StaticDataInterface $dataArray */
        $dataArrayClass = $dataCollection::getDataClassName();
        $dataArray = new $dataArrayClass();

        /** @var DataClassInterface $dataClassName */
        $dataClass = $dataCollection::getClassName();

        foreach ($dataArray->getData() as $data){
            $dataObject = $dataClass::createFromArray($data);
            $dataCollection->addElement($dataObject);
        }

        return $dataCollection;
    }
}
