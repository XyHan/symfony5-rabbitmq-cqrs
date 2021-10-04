<?php

namespace App\Infrastructure\Serializer\Denormalizer\Model;

use App\Infrastructure\Bus\Model\AmqpEnvelope;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class AmqpEnvelopeDenormalizer
 */
class AmqpEnvelopeDenormalizer extends ObjectNormalizer
{
    /**
     * @param $data
     * @param $type
     * @param null $format
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return class_exists($type) === true && is_subclass_of($type, AmqpEnvelope::class);
    }

    /**
     * @param $data
     * @param null $format
     * @return bool
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return is_object($data) === true && $data instanceof AmqpEnvelope;
    }
}
