<?php declare(strict_types=1);

namespace App\Helper;


use Swoft\Http\Message\Request;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class ExpressionLanguageProvider
 * @package App\Helper
 * @Bean("expressionLanguageProvider")
 */
class ExpressionLanguageProvider implements ExpressionFunctionProviderInterface
{
    /**
     * @inheritDoc
     */
    public function getFunctions()
    {
        /**
         * 将系统中的公共函数注册到语法表达式当中，使用技巧详见文档
         * https://symfony.com/doc/current/components/expression_language/extending.html
         */
        return [
            new ExpressionFunction('ip',
                fn() => sprintf('ip(%1$s)',context()->getRequest()),
                fn() => ip(context()->getRequest()),
            ),
            new ExpressionFunction('root_domain',
                fn() => sprintf('root_domain(%1$s)',context()->getRequest()),
                fn() => root_domain(context()->getRequest()),
            ),
            new ExpressionFunction('sub_domain',
                fn() => sprintf('sub_domain(%1$s)',context()->getRequest()),
                fn() => sub_domain(context()->getRequest()),
            ),
        ];
    }
}
