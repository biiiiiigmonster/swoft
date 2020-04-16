<?php


namespace App\Annotation\Mapping;


use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\Attributes;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Class Throttle
 * @package App\Annotation\Mapping
 * @Annotation()
 * @Target("METHOD")
 * @Attributes({
 *     @Attribute("frequency",type="string")
 *     })
 */
class Throttle
{
    /**
     * @var string
     */
    private $prefix = 'biiiiiigmonster:throttle:';

    /**
     * @var string
     */
    private $key = '';

    /**
     * @var string
     * @example 1/1m,1/5m,5/30s... unit support [s:每秒,m:每分,h:每小时,d:每天]
     */
    private $frequency = '1/1m';

    /**
     * Throttle constructor.
     * @param array $values
     */
    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->frequency = $values['value'];
        }
        if (isset($values['frequency'])) {
            $this->frequency = $values['frequency'];
        }
        if (isset($values['key'])) {
            $this->key = $values['key'];
        }
        if (isset($values['prefix'])) {
            $this->prefix = $values['prefix'];
        }
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @return string
     */
    public function getFrequency(): string
    {
        return $this->frequency;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
}