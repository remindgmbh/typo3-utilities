<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Frontend;

use function implode;

use function is_object;
use TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication;

/**
 *
 */
class User
{
    /**
     * The user instance from the globals variable.
     *
     * @var FrontendUserAuthentication
     */
    protected ?FrontendUserAuthentication $feUser = null;

    /**
     * If the TSFE is available at all.
     *
     * @var bool
     */
    protected bool $isFrontend = false;

    /**
     * Create a new instance and assign the variables.
     */
    public function __construct()
    {
        /* Init with invalid value */
        $this->feUser = null;

        /* Check and assign TSFE result */
        $this->isFrontend = isset($GLOBALS['TSFE']);

        /* If TSFE could be determined */
        if ($this->isFrontend) {
            $this->getFeUser();
        }
    }

    /**
     * Assigns the TSFE fe_user instance from the globals to a member variable.
     *
     * @return void
     */
    protected function getFeUser(): void
    {
        /* If the instance is set */
        if (isset($GLOBALS['TSFE']->fe_user)) {
            /* And the instance  */
            if (is_object($GLOBALS['TSFE']->fe_user)) {
                /* Assign the instance */
                $this->feUser = $GLOBALS['TSFE']->fe_user;
            }
        }
    }

    /**
     * Check if the logged in frontend user has the right to
     * create and send vehicle PDF.
     *
     * @return bool
     */
    public function canSendPDF(): bool
    {
        /* If this is not the frontend and the fe user could not be loaded */
        if (!$this->isFrontend || $this->feUser === null) {
            return false;
        }

        /* Check if the vehicle expose option is set */
        $hasVehicleOption = isset($this->feUser->user['vehicle_pdf']);

        /* Check if the option is enabled */
        $isEnabled = ((int) $this->feUser->user['vehicle_pdf']) === 1;

        /* If the option is avaliable and enabled */
        return $hasVehicleOption && $isEnabled;
    }

    /**
     * Returns true if the TSFE fe_user could be loaded.
     *
     * @return bool
     */
    public function isFrontend(): bool
    {
        return $this->isFrontend;
    }

    /**
     * Returns true if a fe_user could be found the TSFE.
     *
     * @return bool
     */
    public function hasUser(): bool
    {
        return $this->feUser !== null ? true : false;
    }

    /**
     * Returns true if the fe_user uid is set.
     *
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return isset($this->feUser->user['uid']) ? true : false;
    }

    /**
     * Will error when feuser = null.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->feUser->user['username'] ?? '';
    }

    /**
     * Will error when feuser = null.
     *
     * @return string
     */
    public function getFullName(): string
    {
        return implode(' ', [
            $this->feUser->user['first_name'],
            $this->feUser->user['last_name']
        ]);
    }

    /**
     *
     * @return FrontendUserAuthentication|null
     */
    public function getUser(): ?FrontendUserAuthentication
    {
        return $this->feUser;
    }
}
