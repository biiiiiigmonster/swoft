<?php


namespace App\Annotation\Mapping;

use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\Attributes;

/**
 * Class CacheWrap
 * @package App\Annotation\Mapping
 *
 * @Annotation()
 * @Attributes({
 *     @Attribute("key",type="string"),
 *     @Attribute("ttl",type="int")
 * })
 */
class CacheWrap
{
    /**
     * @var string
     */
    private $key = '';

    /**
     * @var int
     */
    private $ttl = -1;

    /**
     * CacheWrap constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        if (isset($values['key'])) {
            $this->key = $values['key'];
        }
        if (isset($values['ttl'])) {
            $this->ttl = (int)$values['ttl'];
        }
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return int
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }
}
