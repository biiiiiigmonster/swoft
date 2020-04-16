<?php


namespace App\Annotation\Mapping;


use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\Attributes;
use Doctrine\Common\Annotations\Annotation\Required;
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
    private $name = 'swoft:throttle';

    /**
     * @var string
     * @Required()
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
        if (isset($values['name'])) {
            $this->name = $values['name'];
        }
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
    public function getName(): string
    {
        return $this->name;
    }
}
