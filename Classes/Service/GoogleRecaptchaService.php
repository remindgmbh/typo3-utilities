<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Service;

use function file_get_contents;
use function filter_input;
use function json_decode;

use const INPUT_POST;
use const INPUT_SERVER;

/**
 * Google recaptcha API client for validating the response token.
 */
class GoogleRecaptchaService
{
    /**
     * The recaptcha url with sprintf placeholders for parameters.
     * @var string
     */
    public const GOOGLE_URL = 'https://www.google.com/recaptcha/api/siteverify?secret=%s&response=%s&remoteip=%s';

    /**
     * The google recaptcha response variable name.
     * @var string
     */
    public const RESPONSE_VAR_NAME = 'g-recaptcha-response';

    /**
     * The secret used for requests.
     *
     * @var string
     */
    protected string $secret = '';

    /**
     * The token response from the client side.
     *
     * @var string
     */
    protected string $response = '';

    /**
     * The server ip address.
     *
     * @var string
     */
    protected string $remoteIp = '';

    /**
     * Creates a new instance using the recaptcha post response and
     * the server ip address if available.
     */
    public function __construct()
    {
        $this->secret = '';
        $this->response = filter_input(INPUT_POST, self::RESPONSE_VAR_NAME) ?? '';
        $this->remoteIp = filter_input(INPUT_SERVER, 'REMOTE_ADDR') ?? '';
    }

    /**
     * Generates the request url and parses the result for the success value.
     *
     * @return bool
     */
    public function validate(): bool
    {
        /* Generate the url by filling the arguments */
        $url = sprintf(self::GOOGLE_URL, $this->secret, $this->response, $this->remoteIp);

        /* Post to the recaptcha url */
        $response = file_get_contents($url, false);

        /* Decode result object to array */
        $result = json_decode($response, true);

        /* Passthrough response */
        return (bool) $result['success'];
    }

    /**
     * Returns the secret used for the api request.
     *
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * Returns the response parameter posted by the google api.
     *
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }

    /**
     * Returns the set server ip address.
     *
     * @return string
     */
    public function getRemoteIp(): string
    {
        return $this->remoteIp;
    }

    /**
     * Sets the secret used for the api request.
     *
     * @param string $secret A secret
     * @return void
     */
    public function setSecret(string $secret): void
    {
        $this->secret = $secret;
    }

    /**
     * Sets the google api response value.
     *
     * @param string $response Some response value
     * @return void
     */
    public function setResponse(string $response): void
    {
        $this->response = $response;
    }

    /**
     * Sets the server IP address.
     *
     * @param string $remoteIp An IP address
     * @return void
     */
    public function setRemoteIp(string $remoteIp): void
    {
        $this->remoteIp = $remoteIp;
    }
}
