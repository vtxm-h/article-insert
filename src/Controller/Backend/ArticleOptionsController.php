<?php

namespace ArticleInsert\Controller\Backend;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\Database;
use Contao\RequestToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleOptionsController extends AbstractController
{
    private ContaoFramework $framework;

    public function __construct(ContaoFramework $framework)
    {
        $this->framework = $framework;
    }

    /**
     * @Route(
     *   "/contao/_article_insert/articles",
     *   name="article_insert_articles",
     *   methods={"POST"}
     * )
     */
    public function __invoke(Request $request): JsonResponse
    {
        // Contao-Framework booten (DB, etc.)
        $this->framework->initialize();

        // RequestToken validieren
        $token = (string) $request->request->get('REQUEST_TOKEN', '');
        if (!RequestToken::validate($token)) {
            return new JsonResponse(['error' => 'invalid_token'], 403);
        }

        $pageId = (int) $request->request->get('pageId', 0);
        if ($pageId <= 0) {
            return new JsonResponse([]);
        }

        $stmt = Database::getInstance()
            ->prepare('SELECT id, title, inColumn FROM tl_article WHERE pid=? ORDER BY sorting')
            ->execute($pageId);

        $out = [];

        while ($stmt->next()) {
            $label = $stmt->title;
            if ($stmt->inColumn) {
                $label .= ' [' . $stmt->inColumn . ']';
            }

            $out[] = [
                'id'    => (int) $stmt->id,
                'label' => $label,
            ];
        }

        return new JsonResponse($out);
    }
}
