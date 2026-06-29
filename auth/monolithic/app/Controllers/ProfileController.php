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
final class ProfileController
{
    use ResponseHelper;
    use ViewHelper;
    use SecurityHelper;

    public function __construct(
        private readonly \Modules\ForgeAuth\Contracts\UserContextInterface $userContext,
    ) {
    }

    #[Route("/admin/profile")]
    #[Layout("ForgeComponents:wrappers/admin-default")]
    public function editProfile(): Response
    {
        return $this->view(view: "admin/profile", data: [
            'currentUser' => $this->userContext->current(),
        ]);
    }

    #[Route("/admin/profile", "POST")]
    public function saveProfile(Request $request): Response
    {
        $data = $this->sanitize($request->postData);

        Flash::set("success", "Profile updated successfully.");
        return Redirect::to('/admin/profile');
    }
}
