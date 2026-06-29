<?php

declare(strict_types=1);

namespace App\Controllers;

use Modules\ForgeRouter\Helpers\Redirect;
use Modules\ForgeRouter\Http\Attributes\Middleware;
use Modules\ForgeRouter\Http\Request;
use Modules\ForgeRouter\Http\Response;
use Modules\ForgeRouter\Attributes\Layout;
use Modules\ForgeRouter\Routing\Route;
use Modules\ForgeRouter\Traits\ResponseHelper;
use Modules\ForgeView\Traits\ViewHelper;
use Forge\Core\DI\Attributes\Service;
use Forge\Core\Helpers\Flash;
use Forge\Traits\SecurityHelper;

#[Service]
#[Middleware('web')]
#[Middleware('auth')]
final class AccountController
{
    use ResponseHelper;
    use ViewHelper;
    use SecurityHelper;

    public function __construct(
        private readonly \Modules\ForgeAuth\Contracts\UserContextInterface $userContext,
    ) {
    }

    #[Route("/admin/account")]
    #[Layout("ForgeComponents:wrappers/admin-default")]
    public function editAccount(): Response
    {
        return $this->view(view: "admin/account", data: [
            'currentUser' => $this->userContext->current(),
        ]);
    }

    #[Route("/admin/account", "POST")]
    public function saveAccount(Request $request): Response
    {
        $data = $this->sanitize($request->postData);

        Flash::set("success", "Account settings saved successfully.");
        return Redirect::to('/admin/account');
    }
}
