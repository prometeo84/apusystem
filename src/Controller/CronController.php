<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class CronController extends AbstractController
{
    private ManagerRegistry $doctrine;
    private ?string $apiKey;
    private KernelInterface $kernel;

    public function __construct(ManagerRegistry $doctrine, KernelInterface $kernel)
    {
        $this->doctrine = $doctrine;
        $this->kernel = $kernel;
        $this->apiKey = $_ENV['CRON_JOB_API_KEY'] ?? getenv('CRON_JOB_API_KEY') ?: null;
        // If no env var present (e.g., webserver didn't load .env), try to read .env file in project root
        if (!$this->apiKey) {
            $root = dirname(__DIR__, 2);
            $envFile = $root . '/.env';
            if (is_readable($envFile)) {
                $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
                foreach ($lines as $line) {
                    if (str_starts_with(trim($line), 'CRON_JOB_API_KEY=')) {
                        $parts = explode('=', $line, 2);
                        $val = $parts[1] ?? '';
                        $val = trim($val, " \t\"'\n\r");
                        if ($val !== '') {
                            $this->apiKey = $val;
                        }
                        break;
                    }
                }
            }
        }
    }

    #[Route('/cron/run', name: 'cron_run', methods: ['POST'])]
    public function run(Request $request): JsonResponse
    {
        $provided = $request->headers->get('X-Cron-Api-Key') ?? $request->get('api_key');

        if (!$this->apiKey || $provided !== $this->apiKey) {
            return new JsonResponse(['status' => 'error', 'message' => 'invalid api key'], 403);
        }

        // load schedules from env (JSON). Format example:
        // {"purge_sessions":{"hours":[3]}, "scan_anomalies":{"hours":[0,6,12,18]}}
        $schedulesRaw = $_ENV['CRON_JOB_SCHEDULES'] ?? getenv('CRON_JOB_SCHEDULES') ?: null;
        $schedules = [];
        if ($schedulesRaw) {
            $decoded = json_decode($schedulesRaw, true);
            if (is_array($decoded)) {
                $schedules = $decoded;
            }
        }

        $tz = $_ENV['CRON_TIMEZONE'] ?? getenv('CRON_TIMEZONE') ?: 'UTC';
        try {
            $now = new \DateTimeImmutable('now', new \DateTimeZone($tz));
        } catch (\Throwable $e) {
            $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        }
        $currentHour = (int) $now->format('G');

        $jobsToRun = [];
        $requestedJob = $request->get('job');
        $force = (bool) $request->get('force');

        // mapping job names to console commands
        $jobMap = [
            'purge_sessions' => ['command' => 'app:session:purge-old'],
            'scan_anomalies' => ['command' => 'app:session:scan-anomalies'],
        ];

        if ($requestedJob) {
            if (!isset($jobMap[$requestedJob])) {
                return new JsonResponse(['status' => 'error', 'message' => 'unknown job'], 400);
            }
            // if force=true, run regardless of schedule
            if ($force) {
                $jobsToRun[] = $requestedJob;
            } else {
                $jobSchedule = $schedules[$requestedJob] ?? null;
                $hours = $jobSchedule['hours'] ?? null;
                if (!$hours || in_array($currentHour, $hours, true)) {
                    $jobsToRun[] = $requestedJob;
                } else {
                    return new JsonResponse(['status' => 'skipped', 'message' => 'not scheduled at this hour', 'hour' => $currentHour]);
                }
            }
        } else {
            // no specific job requested — run all scheduled for this hour
            foreach ($schedules as $name => $cfg) {
                $hours = $cfg['hours'] ?? null;
                if ($hours && in_array($currentHour, $hours, true)) {
                    if (isset($jobMap[$name])) {
                        $jobsToRun[] = $name;
                    }
                }
            }
        }

        if (empty($jobsToRun)) {
            return new JsonResponse(['status' => 'ok', 'message' => 'no jobs scheduled for this hour', 'hour' => $currentHour]);
        }

        $results = [];
        // run requested jobs via Console Application to reuse commands
        try {
            // Prefer running via ConsoleApplication when kernel service is available.
            if (true) {
                $application = new Application($this->kernel);
                $application->setAutoExit(false);

                foreach ($jobsToRun as $job) {
                    $cmd = $jobMap[$job]['command'];
                    $args = ['command' => $cmd];
                    $cfg = $schedules[$job] ?? [];
                    if ($job === 'purge_sessions') {
                        $days = $cfg['days'] ?? ($_ENV['PURGE_DEFAULT_DAYS'] ?? 15);
                        $args['--days'] = (int) $days;
                        $args['--no-interaction'] = true;
                    }

                    $input = new ArrayInput($args);
                    $output = new BufferedOutput();
                    $exit = $application->run($input, $output);
                    $out = $output->fetch();
                    $results[$job] = ['exit' => $exit, 'output' => $out];
                }
            } else {
                // Fallback: call CLI commands via shell (php bin/console ...)
                $root = dirname(__DIR__, 2);
                foreach ($jobsToRun as $job) {
                    $cmd = $jobMap[$job]['command'];
                    $cfg = $schedules[$job] ?? [];
                    $cmdline = sprintf('php %s/bin/console %s', escapeshellarg($root), $cmd);
                    if ($job === 'purge_sessions') {
                        $days = $cfg['days'] ?? ($_ENV['PURGE_DEFAULT_DAYS'] ?? 15);
                        $cmdline .= ' --days=' . (int) $days . ' --no-interaction';
                    }
                    $cmdline .= ' 2>&1';
                    $outputLines = [];
                    $rc = 0;
                    exec($cmdline, $outputLines, $rc);
                    $results[$job] = ['exit' => $rc, 'output' => implode("\n", $outputLines)];
                }
            }

            return new JsonResponse(['status' => 'ok', 'executed' => $results]);
        } catch (\Throwable $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
