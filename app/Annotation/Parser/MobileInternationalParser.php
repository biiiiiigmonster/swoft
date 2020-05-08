<?php


namespace App\Annotation\Parser;

use App\Annotation\Mapping\MobileInternational;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Annotation\Annotation\Parser\Parser;
use Swoft\Validator\Exception\ValidatorException;
use Swoft\Validator\ValidatorRegister;
use ReflectionException;

/**
 * Class MobileInternationalParser
 *
 * @AnnotationParser(annotation=MobileInternational::class)
 */
class MobileInternationalParser extends Parser
{
    /**
     * @param int $type
     * @param object $annotationObject
     * @return array
     * @throws ReflectionException
     * @throws ValidatorException
     */
    public function parse(int $type, $annotationObject): array
    {
        if ($type == self::TYPE_PROPERTY) {
            ValidatorRegister::registerValidatorItem($this->className, $this->propertyName, $annotationObject);
        }

        return [];
    }
}
