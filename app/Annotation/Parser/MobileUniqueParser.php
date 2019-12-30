<?php


namespace App\Annotation\Parser;

use App\Annotation\Mapping\MobileUnique;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Annotation\Annotation\Parser\Parser;
use Swoft\Validator\Exception\ValidatorException;
use Swoft\Validator\ValidatorRegister;
use ReflectionException;

/**
 * Class MobileUniqueParser
 *
 * @AnnotationParser(annotation=MobileUnique::class)
 */
class MobileUniqueParser extends Parser
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
        //我还不太明白这个判断的意义是啥...
        if ($type == self::TYPE_PROPERTY) {
            ValidatorRegister::registerValidatorItem($this->className, $this->propertyName, $annotationObject);
        }

        return [];
    }
}
