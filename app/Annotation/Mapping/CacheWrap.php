<?php


namespace App\Annotation\Mapping;

use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\Attributes;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Class CacheWrap
 * @package App\Annotation\Mapping
 *
 * @Annotation()
 * @Target("METHOD")
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
    private $prefix = 'biiiiiigmonster:cache:';
    /**
     * 注解key支持symfony/expression-language语法表达式
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
