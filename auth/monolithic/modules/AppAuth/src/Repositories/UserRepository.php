<?php

declare(strict_types=1);

namespace Modules\AppAuth\Repositories;

use Modules\AppAuth\Models\User;
use Modules\ForgeAuth\Contracts\AuthUserInterface;
use Modules\ForgeAuth\Contracts\UserProviderInterface;
use Modules\ForgeSqlOrm\ORM\Paginator;
use Modules\ForgeSqlOrm\Repositories\RecordRepository;
use Forge\Core\DI\Attributes\NoCache;

#[NoCache]
class UserRepository extends RecordRepository implements UserProviderInterface
{

    protected function getModelClass(): string
    {
        return User::class;
    }

    public function findById(int $id): ?AuthUserInterface
    {
        return parent::find($id);
    }

    public function findByIdentifier(string $identifier): ?AuthUserInterface
    {
        return User::query()->where('identifier', '=', $identifier)->first();
    }

    public function findByEmail(string $email): ?AuthUserInterface
    {
        return User::query()->where('email', '=', $email)->first();
    }

    public function verifyCredentials(string $identifier, string $password): ?AuthUserInterface
    {
        $user = User::query()->where('identifier', '=', $identifier)->first();
        if (!$user || !password_verify($password, $user->password)) {
            return null;
        }
        return $user;
    }

    public function createUser(array $credentials): AuthUserInterface
    {
        $user = new User();
        $user->identifier = $credentials['identifier'];
        $user->email = $credentials['email'];
        $user->password = password_hash($credentials['password'], PASSWORD_BCRYPT);
        $user->status = $credentials['status'] ?? 'active';
        $user->save();
        $this->cache->invalidate($this->tableName);

        return $user;
    }

    public function paginate(int $page = 1, int $perPage = 10, array $options = []): Paginator
    {
        return parent::paginate($page, $perPage, $options);
    }
}
