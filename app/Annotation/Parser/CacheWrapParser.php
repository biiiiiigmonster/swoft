<?php


namespace App\Annotation\Parser;

use App\Annotation\Mapping\CacheWrap;
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
     * @param object $annotationObject
     * @return array
     * @throws AnnotationException
     */
    public function parse(int $type, $annotationObject): array
    {
        // TODO: Implement parse() method.
        if($type === self::TYPE_PROPERTY) {
            throw new AnnotationException('Annotation CacheClear should not on property!');
        }

        return [];
    }
}
