<?php

declare(strict_types=1);

namespace App\Services;

use Modules\ForgeAuth\Contracts\UserProviderInterface;
use Forge\Core\DI\Attributes\Service;

#[Service]
final class AdminUserService
{
    public function __construct(
        private readonly UserProviderInterface $userProvider,
    ) {
    }

    public function getUsersTableData(int $page = 1, int $perPage = 10): array
    {
        $paginator = $this->userProvider->paginate($page, $perPage);

        return [
            'columns' => ['id', 'identifier', 'email'],
            'rows' => array_map(function ($user) {
                return [
                    'id' => $user->getId(),
                    'identifier' => $user->getIdentifier(),
                    'email' => $user->getEmail(),
                ];
            }, $paginator->items()),
        ];
    }

    public function getUserDetails(int $id): ?array
    {
        $user = $this->userProvider->findById($id);

        if (!$user) {
            return null;
        }

        return [
            'id' => $user->getId(),
            'identifier' => $user->getIdentifier(),
            'email' => $user->getEmail(),
        ];
    }
}
