<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\GameCheck\GameCheckServiceInterface;

class GameCheckTest extends TestCase
{
    public function test_service_provider_binds_correctly()
    {
        $service = app(GameCheckServiceInterface::class);
        $this->assertInstanceOf(\App\Services\GameCheck\MockGameCheckService::class, $service);
    }

    public function test_mock_service_validates_short_id()
    {
        $service = app(GameCheckServiceInterface::class);
        $result = $service->checkAccountId('any-game', '123'); // Length 3

        $this->assertFalse($result['isValid']);
        $this->assertNull($result['accountName']);
    }

    public function test_mock_service_validates_long_id()
    {
        $service = app(GameCheckServiceInterface::class);
        $result = $service->checkAccountId('any-game', '123456'); // Length 6

        $this->assertTrue($result['isValid'], 'ID > 5 chars should be valid');
        $this->assertStringContainsString('TestUser', $result['accountName']);
    }
}
