<?php declare(strict_types=1);

namespace HW\Tests;

use HW\Lib\Storage;
use HW\Lib\UserService;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private string $username = "John";
    private string $email = "john@example.com";
    private string $json;

    protected function setUp(): void
    {
        $this->json = json_encode([
            'username' => $this->username,
            'email' => $this->email
        ], JSON_THROW_ON_ERROR);
    }

    public function testCreateUserSaveCalled()
    {
        // Mock storage->save()
        $mockStorage = $this->createMock(Storage::class);
        $mockStorage->expects($this->once())
                    ->method("save")
                    ->with($this->anything(), $this->json);

        // Create UserService
        $userService = new UserService($mockStorage);

        // Test createUser()
        $userService->createUser($this->username, $this->email);
    }

    public function testGetUsernameReturnsUsername()
    {
        // Mock storage->get()
        $mockStorage = $this->createMock(Storage::class);
        $mockStorage->expects($this->once())
                    ->method("get")
                    ->willReturn($this->json);

        // Create UserService
        $userService = new UserService($mockStorage);

        // Test getUsername()
        $this->assertEquals($this->username, $userService->getUsername(42));
    }

    public function testGetUsernameReturnsNull()
    {
        // Mock storage->get()
        $mockStorage = $this->createMock(Storage::class);
        $mockStorage->expects($this->once())
                    ->method("get")
                    ->willReturn(null);

        // Create UserService
        $userService = new UserService($mockStorage);

        // Test getUsername()
        $this->assertEquals(null, $userService->getUsername(42));
    }

    public function testGetEmailReturnsEmail()
    {
        // Mock storage->get()
        $mockStorage = $this->createMock(Storage::class);
        $mockStorage->expects($this->once())
            ->method("get")
            ->willReturn($this->json);

        // Create UserService
        $userService = new UserService($mockStorage);

        // Test getUsername()
        $this->assertEquals($this->email, $userService->getEmail(42));
    }

    public function testGetEmailReturnsNull()
    {
        // Mock storage->get()
        $mockStorage = $this->createMock(Storage::class);
        $mockStorage->expects($this->once())
            ->method("get")
            ->willReturn(null);

        // Create UserService
        $userService = new UserService($mockStorage);

        // Test getUsername()
        $this->assertEquals(null, $userService->getEmail(42));
    }
}
