<?php

namespace App\Infrastructure\Serializer\Denormalizer\Command;

use App\Application\Command\MyCommand\MyCommand;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class MyCommandDenormalizer
 */
class MyCommandDenormalizer extends ObjectNormalizer
{
    /**
     * @param $data
     * @param $type
     * @param null $format
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return class_exists($type) === true && is_subclass_of($type, MyCommand::class);
    }

    /**
     * @param $data
     * @param null $format
     * @return bool
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return is_object($data) === true && $data instanceof MyCommand;
    }
}
