<?php
declare(strict_types=1);

namespace tests\Service\Token;

use App\Service\Token\TokenProvider;
use tests\BaseTestCase;

class TokenProviderTest extends BaseTestCase
{
    private TokenProvider $tokenProvider;

    public function setUp(): void
    {
        parent::setUp();

        $this->tokenProvider = $this->container->getService('tokenProvider');
    }

    public function testRegisterToken(): void
    {
        self::assertNotEmpty($this->tokenProvider->registerToken());
        self::assertTrue($this->tokenProvider->isSavedTokenReusable());
    }
}
