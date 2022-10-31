<?php declare(strict_types=1);

namespace HW\Lib;

class UserService
{
    private Storage $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function createUser($username, $email)
    {
        $id = uniqid('', true);
        $this->storage->save($id, json_encode([
            'username' => $username,
            'email' => $email
        ], JSON_THROW_ON_ERROR));
        return $id;
    }

    /**
     * @throws \JsonException
     */
    public function getUsername($id)
    {
        $user = $this->storage->get($id);
        if (!$user) {
            return null;
        }
        return json_decode($user, true, 512, JSON_THROW_ON_ERROR)['username'];
    }

    /**
     * @throws \JsonException
     */
    public function getEmail($id)
    {
        $user = $this->storage->get($id);
        if (!$user) {
            return null;
        }
        return json_decode($user, true, 512, JSON_THROW_ON_ERROR)['email'];
    }
}
