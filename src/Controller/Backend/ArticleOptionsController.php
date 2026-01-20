<?php

namespace ArticleInsert\Controller\Backend;

use Contao\CoreBundle\Framework\ContaoFramework;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ArticleOptionsController
{
    private ContaoFramework $framework;

    public function __construct(ContaoFramework $framework)
    {
        $this->framework = $framework;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->framework->initialize();

        return new JsonResponse(['ok' => true]);
    }
}
