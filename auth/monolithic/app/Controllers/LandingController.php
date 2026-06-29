<?php

declare(strict_types=1);

namespace App\Controllers;

use Modules\ForgeAuth\Contracts\UserContextInterface;
use Modules\ForgeRouter\Http\Attributes\Middleware;
use Modules\ForgeRouter\Http\Response;
use Modules\ForgeRouter\Attributes\Layout;
use Modules\ForgeRouter\Routing\Route;
use Modules\ForgeRouter\Traits\ResponseHelper;
use Modules\ForgeView\Traits\ViewHelper;
use Forge\Core\DI\Attributes\Service;

#[Service]
#[Middleware('web')]
final class LandingController
{
    use ResponseHelper;
    use ViewHelper;

    public function __construct(
        private readonly UserContextInterface $userContext,
    ) {
    }

    #[Route("/")]
    #[Layout("ForgeComponents:public")]
    public function welcome(): Response
    {
        return $this->view(view: "welcome", data: [
            'currentUser' => $this->userContext->current(),
        ]);
    }
}
