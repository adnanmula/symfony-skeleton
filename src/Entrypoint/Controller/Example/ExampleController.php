<?php declare(strict_types=1);

namespace AdnanMula\Skeleton\Entrypoint\Controller\Example;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ExampleController
{
    public function __invoke(Request $request): Response
    {
        return new Response();
    }
}
