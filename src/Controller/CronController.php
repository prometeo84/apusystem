<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CronController extends AbstractController
{
    private ManagerRegistry $doctrine;
    private ?string $apiKey;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->apiKey = $_ENV['CRON_JOB_API_KEY'] ?? getenv('CRON_JOB_API_KEY') ?: null;
    }

    #[Route('/cron/run', name: 'cron_run', methods: ['POST'])]
    public function run(Request $request): JsonResponse
    {
        $provided = $request->headers->get('X-Cron-Api-Key') ?? $request->get('api_key');

        if (!$this->apiKey || $provided !== $this->apiKey) {
            return new JsonResponse(['status' => 'error', 'message' => 'invalid api key'], 403);
        }

        try {
            $conn = $this->doctrine->getConnection();
            $affected = $conn->executeStatement('UPDATE login_sessions SET is_active = 0 WHERE expires_at < NOW()');
            return new JsonResponse(['status' => 'ok', 'updated' => $affected]);
        } catch (\Throwable $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
