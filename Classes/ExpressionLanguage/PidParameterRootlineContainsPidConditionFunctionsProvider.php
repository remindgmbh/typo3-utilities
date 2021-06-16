<?php

declare(strict_types=1);

namespace Remind\RmndUtil\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use TYPO3\CMS\Core\Utility\RootlineUtility;

/**
 * @author Marco Wegner <m.wegner@remind.de>
 */
class PidParameterRootlineContainsPidConditionFunctionsProvider implements ExpressionFunctionProviderInterface
{
    /**
     *
     * @return array
     */
    public function getFunctions(): array
    {
        /* Return functions for symfony conditions */
        return [
            $this->getCompareRootlineFunction()
        ];
    }

    /**
     * Check for url parameter with pid and get rootline.
     * Then check if the given pid (in ts condition) is in the same rootline.
     *
     * @todo is there a better way to define the function inside the function?
     * @return ExpressionFunction
     */
    protected function getCompareRootlineFunction(): ExpressionFunction
    {
        return new ExpressionFunction('isPidParameterRootlineContainsPid', function () {
            // Not implemented, we only use the evaluator
        }, function (
            array $existingVariables,
            array $parameterPath,
            int $comparePid,
            bool $additionallyCheckCurrentRootline = false
        ) {

            /* If current rootline should be checked do that first and return if successful */
            if ($additionallyCheckCurrentRootline) {
                /* Rootline on current page */
                $currentPageRootLine = $existingVariables['tree']->rootLineIds ?? [];
                /* Is given page on current rootline */
                if (\in_array($comparePid, $currentPageRootLine)) {
                    return true;
                }
            }

            /* Post parameter */
            $post = $existingVariables['request']->getParsedBody();
            /* Get parameter */
            $get = $existingVariables['request']->getQueryParams();

            /* Merge get and post parameter */
            $parameter = \array_merge($get, $post);

            /* Search for pid url parameter */
            $pathValue = $parameter;

            foreach ($parameterPath as $pathSegment) {
                if (empty($pathValue[$pathSegment])) {
                    break;
                }

                $pathValue = $pathValue[$pathSegment];
            }

            /* post/get parameter was not found or is empty */
            if (!\is_int($pathValue) && !(\is_string($pathValue) && \is_numeric($pathValue))) {
                return false;
            }

            /* pid from url parameter */
            $pageUid = (int)$pathValue;

            try {
                /* Get rootline for pid from parameter */
                $rootLineUtility = new RootlineUtility($pageUid);
                $rootLine = $rootLineUtility->get();
            } catch (\Exception $ex) {
                return false;
            }

            /* Extract only pids from rootlins pages */
            $rootLineIds = [];
            foreach ($rootLine as $page) {
                $rootLineIds[] = $page['uid'];
            }

            /* Is given pid in parameter page rootline */
            $isInRootLine = \in_array($comparePid, $rootLineIds);

            return $isInRootLine;
        });
    }
}
