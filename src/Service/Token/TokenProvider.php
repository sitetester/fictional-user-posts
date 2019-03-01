<?php
declare(strict_types=1);

namespace App\Service\Token;

use App\Service\Helper\DateTimeHelper;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Stdlib\Parameters;

class TokenProvider
{
    private const TOKEN_PATH = 'var/data/token.log';
    private const TOKEN_SEPARATOR = '<=>';
    private $params;
    private $client;
    private $dateTimeHelper;

    public function __construct(
        array $params,
        Client $client,
        DateTimeHelper $dateTimeHelper
    ) {
        $this->params = $params;
        $this->client = $client;
        $this->dateTimeHelper = $dateTimeHelper;
    }

    public function provideToken(): ?string
    {
        if ($this->isSavedTokenReusable()) {
            $tokenData = $this->getTokenData();

            return $tokenData[1];
        }

        return $this->registerToken();
    }

    /**
     * This is public, since used in unit test
     */
    public function isSavedTokenReusable(): bool
    {
        $tokenData = $this->getTokenData();
        if ($tokenData === null) {
            return false;
        }

        return $this->dateTimeHelper->isWithinPast60Min((int)$tokenData[0]);
    }

    private function getTokenData(): ?array
    {
        if (!file_exists(self::TOKEN_PATH)) {
            return null;
        }

        return explode(self::TOKEN_SEPARATOR, file_get_contents(self::TOKEN_PATH));
    }

    public function registerToken(): ?string
    {
        $response = $this->client->send(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setUri($this->params['url'])
                ->setPost(new Parameters($this->params['params']))
        );

        $responseData = json_decode($response->getBody(), true);
        if (isset($responseData['error'])) {
            return null;
        }

        $token = $responseData['data']['sl_token'];
        $this->saveToken($token);

        return $token;
    }

    /**
     * Avoids API request and generating a new token on remote server
     */
    private function saveToken(string $token): void
    {
        file_put_contents(
            self::TOKEN_PATH,
            (new \DateTime('now'))->getTimestamp() . self::TOKEN_SEPARATOR . $token
        );
    }
}
