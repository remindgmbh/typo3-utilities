<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Helper;

use TYPO3\CMS\Core\Authentication\AbstractUserAuthentication;

/**
 * Provides a wrapper for the TYPO3 global session data handling variables.
 */
class SessionHelper
{
    /**
     * Identifier for the TYPO3 backend mode.
     * @var string
     */
    public const TYPO3_MODE_BE = 'BE';

    /**
     * Identifier for the TYPO3 frontend mode.
     * @var string
     */
    public const TYPO3_MODE_FE = 'FE';

    /**
     * The selected TYPO3 mode.
     *
     * @var string
     */
    protected string $mode = self::TYPO3_MODE_FE;

    /**
     *
     * The User-Object with the session-methods.
     * Either $GLOBALS['BE_USER'] or $GLOBALS['TSFE']->fe_user.
     *
     * @var AbstractUserAuthentication
     */
    protected ?AbstractUserAuthentication $sessionObject = null;

    /**
     * The session key to store the data in.
     * @var string
     */
    protected string $storageKey = '';

    /**
     * Creates a new SessionHelper with a storage key and a TYPO3 mode.
     * If no mode is given, it will default to frontend mode.
     *
     * @param string $storageKey An identifier to store session data in
     * @param string $mode The TYPO3 session mode
     */
    public function __construct(string $storageKey, string $mode = self::TYPO3_MODE_FE)
    {
        /* Process the input value */
        switch ($mode) {
            case self::TYPO3_MODE_BE: // If it is the BE mode
                $this->mode = self::TYPO3_MODE_BE;
                $this->sessionObject = $GLOBALS['BE_USER'];
                break;
            case self::TYPO3_MODE_FE: // If it is the FE mode
            default:                  // Or any other mode
                $this->mode = self::TYPO3_MODE_FE;
                $this->sessionObject = $GLOBALS['TSFE']->fe_user;
        }

        $this->storageKey = $storageKey;
    }

    /**
     * Returns the session storage key this helper is using.
     *
     * @return string The storage key.
     */
    public function getStorageKey(): string
    {
        return $this->storageKey;
    }

    /**
     * Set the session storage key this helper should use.
     *
     * @param string $storageKey
     * @return void
     */
    public function setStorageKey(string $storageKey): void
    {
        $this->storageKey = $storageKey;
    }

    /**
     * Store a key-value pair in the session.
     * If the key already exists the data will be overwritten.
     *
     * @param string $key The key to store the value in.
     * @param mixed $value A value that will be stored.
     * @return void
     */
    public function set(string $key, $value): void
    {
        /* Get the data for the set storage key */
        $sessionData = $this->sessionObject->getSessionData($this->storageKey);

        /* Write the value to the key in the session storage */
        $sessionData[$key] = $value;

        /* Save the session data */
        $this->sessionObject->setAndSaveSessionData(
            $this->storageKey,
            $sessionData
        );
    }

    /**
     * Delete a key that is stored in the session.
     *
     * @param string $key The key name that will be deleted.
     * @return void
     */
    public function delete(string $key): void
    {
        /* Get the data for the set storage key */
        $sessionData = $this->sessionObject->getSessionData($this->storageKey);

        /* Void and unset the key */
        $sessionData[$key] = null;
        unset($sessionData[$key]);

        /* Save the session data */
        $this->sessionObject->setAndSaveSessionData(
            $this->storageKey,
            $sessionData
        );
    }

    /**
     * Get a key from the session.
     *
     * @param string $key The key whoose value will be returned.
     * @return mixed|null
     */
    public function get(string $key)
    {
        /* Get the data for the set storage key */
        $sessionData = $this->sessionObject->getSessionData($this->storageKey);

        /* Either return the data if the key exists or return null */
        return $sessionData[$key] ?? null;
    }
}
