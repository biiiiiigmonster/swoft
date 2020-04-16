<?php


namespace App\Annotation\Parser;


use App\Register\ThrottleRegister;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use App\Annotation\Mapping\Throttle;
use Swoft\Annotation\Annotation\Parser\Parser;

/**
 * Class ThrottleParser
 * @package App\Annotation\Parser
 * @AnnotationParser(Throttle::class)
 */
class ThrottleParser extends Parser
{
    /**
     * @param int $type
     * @param Throttle $annotationObject
     * @return array
     */
    public function parse(int $type, $annotationObject): array
    {
        if ($type != self::TYPE_METHOD) {
            return [];
        }

        ThrottleRegister::register($this->className,$this->methodName,$annotationObject);
        return [];
    }
}
