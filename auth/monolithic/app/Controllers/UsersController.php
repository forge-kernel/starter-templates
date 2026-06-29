<?php

declare(strict_types=1);

namespace App\Controllers;

use Modules\ForgeRouter\Helpers\Redirect;
use Modules\ForgeRouter\Http\Attributes\Middleware;
use Modules\ForgeRouter\Http\Response;
use Modules\ForgeRouter\Attributes\Layout;
use Modules\ForgeRouter\Routing\Route;
use Modules\ForgeRouter\Traits\ResponseHelper;
use Modules\ForgeView\Traits\ViewHelper;
use Modules\ForgeAuth\Contracts\UserContextInterface;
use App\Services\AdminUserService;
use Forge\Core\DI\Attributes\Service;
use Forge\Core\Helpers\Flash;

#[Service]
#[Middleware('web')]
#[Middleware('auth')]
final class UsersController
{
    use ResponseHelper;
    use ViewHelper;

    public function __construct(
        private readonly AdminUserService $userService,
        private readonly UserContextInterface $userContext,
    ) {
    }

    #[Route("/admin/users")]
    #[Layout("ForgeComponents:wrappers/admin-default")]
    public function listUsers(): Response
    {
        $usersData = $this->userService->getUsersTableData();

        return $this->view(view: "admin/users/list", data: [
            'columns' => $usersData['columns'],
            'rows' => $usersData['rows'],
            'currentUser' => $this->userContext->current(),
        ]);
    }

    #[Route("/admin/users/{id}")]
    #[Layout("ForgeComponents:wrappers/admin-default")]
    public function viewUser(int $id): Response
    {
        $user = $this->userService->getUserDetails($id);

        if (!$user) {
            Flash::set("error", "User not found.");
            return Redirect::to('/admin/users');
        }

        return $this->view(view: "admin/users/user-detail", data: [
            'user' => $user,
            'currentUser' => $this->userContext->current(),
        ]);
    }
}
