<?php declare(strict_types=1);

namespace HW\Tests;

use HW\Lib\Storage;
use HW\Lib\UserService;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private static string $username = "John";
    private static string $email = "john@example.com";
    private static string $json;

    public static function setUpBeforeClass(): void
    {
        self::$json = json_encode([
            'username' => self::$username,
            'email' => self::$email
        ], JSON_THROW_ON_ERROR);
    }

    public function testCreateUserSaveCalled()
    {
        // Mock storage->save()
        $mockStorage = $this->createMock(Storage::class);
        $mockStorage->expects($this->once())
                    ->method("save")
                    ->with($this->anything(), self::$json);

        // Create UserService
        $userService = new UserService($mockStorage);

        // Test createUser()
        $userService->createUser(self::$username, self::$email);
    }

    public function testGetUsernameReturnsUsername()
    {
        // Mock storage->get()
        $mockStorage = $this->createMock(Storage::class);
        $mockStorage->expects($this->once())
                    ->method("get")
                    ->willReturn(self::$json);

        // Create UserService
        $userService = new UserService($mockStorage);

        // Test getUsername()
        $this->assertEquals(self::$username, $userService->getUsername(42));
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
            ->willReturn(self::$json);

        // Create UserService
        $userService = new UserService($mockStorage);

        // Test getUsername()
        $this->assertEquals(self::$email, $userService->getEmail(42));
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
