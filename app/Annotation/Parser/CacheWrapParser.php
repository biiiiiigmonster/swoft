<?php


namespace App\Annotation\Parser;

use App\Annotation\Mapping\CacheWrap;
use App\Register\CacheWrapRegister;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Annotation\Annotation\Parser\Parser;
use Swoft\Annotation\Exception\AnnotationException;

/**
 * Class CacheWrapParser
 * @package App\Annotation\Parser
 * @AnnotationParser(CacheWrap::class)
 */
class CacheWrapParser extends Parser
{
    /**
     * @param int $type
     * @param CacheWrap $annotationObject
     * @return array
     * @throws AnnotationException
     */
    public function parse(int $type, $annotationObject): array
    {
        // TODO: Implement parse() method.
        if($type !== self::TYPE_METHOD) {
            throw new AnnotationException('Annotation CacheWrap should on method!');
        }

        $data = [
            $annotationObject->getPrefix(),
            $annotationObject->getKey(),
            $annotationObject->getTtl(),
        ];

        CacheWrapRegister::register($data, $this->className, $this->methodName);

        return [];
    }
}
