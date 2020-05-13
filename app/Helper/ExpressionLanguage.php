<?php declare(strict_types=1);


namespace App\Helper;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage as BaseExpressionLanguage;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class ExpressionLanguage
 * @package App\Helper
 * @Bean("expressionLanguage")
 */
class ExpressionLanguage extends BaseExpressionLanguage
{
    public function __construct(CacheItemPoolInterface $cache = null, array $providers = [])
    {
        array_unshift($providers,bean('expressionLanguageProvider'));

        parent::__construct($cache, $providers);
    }
}
