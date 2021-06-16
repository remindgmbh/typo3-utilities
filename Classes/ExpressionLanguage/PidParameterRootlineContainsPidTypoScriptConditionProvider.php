<?php

declare(strict_types=1);

namespace Remind\RmndUtil\ExpressionLanguage;

use TYPO3\CMS\Core\ExpressionLanguage\AbstractProvider;

/**
 * @author Marco Wegner <m.wegner@remind.de>
 */
class PidParameterRootlineContainsPidTypoScriptConditionProvider extends AbstractProvider
{
    /**
     *
     */
    public function __construct()
    {
        /* Register function */
        $this->expressionLanguageProviders = [
            PidParameterRootlineContainsPidConditionFunctionsProvider::class,
        ];
    }
}
