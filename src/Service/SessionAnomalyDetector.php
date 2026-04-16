<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\LoginSession;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class SessionAnomalyDetector
{
    private const ANOMALY_THRESHOLD = 3;
    private const MULTIPLE_SESSIONS_WINDOW = 600; // 10 minutes
    private const BOT_REQUEST_THRESHOLD = 50; // requests per minute
    private const BOT_STDDEV_THRESHOLD = 0.15;

    public function __construct(
        private EntityManagerInterface $em,
        private SecurityLogger $securityLogger,
        private RequestStack $requestStack
    ) {}

    /**
     * Detecta anomalías en la sesión del usuario
     * Retorna true si se detecta una anomalía que requiere re-autenticación
     */
    public function detect(User $user, string $sessionId): bool
    {
        $score = 0;
        $anomalies = [];

        $request = $this->requestStack->getCurrentRequest();
        if (!$request) {
            return false;
        }

        $currentIp = $request->getClientIp();
        $currentUserAgent = $request->headers->get('User-Agent');

        $session = $this->em->getRepository(LoginSession::class)
            ->findOneBy(['sessionId' => $sessionId, 'isActive' => true]);

        if (!$session) {
            return false;
        }

        // 1. Detectar cambio de IP (+2)
        if ($this->detectIpChange($session, $currentIp)) {
            $score += 2;
            $anomalies[] = 'ip_change';
        }

        // 2. Detectar cambio de User-Agent (+1)
        if ($this->detectUserAgentChange($session, $currentUserAgent)) {
            $score += 1;
            $anomalies[] = 'user_agent_change';
        }

        // 3. Detectar sesiones múltiples (+2)
        if ($this->detectMultipleSessions($user)) {
            $score += 2;
            $anomalies[] = 'multiple_sessions';
        }

        // 4. Detectar patrón de bot (+1)
        if ($this->detectBotPattern($user)) {
            $score += 1;
            $anomalies[] = 'bot_pattern';
        }

        // 5. Threat Intelligence (+2)
        if ($this->checkThreatIntelligence($currentIp)) {
            $score += 2;
            $anomalies[] = 'threat_intel';
        }

        // Si el score >= threshold, registrar y retornar true
        if ($score >= self::ANOMALY_THRESHOLD) {
            $this->securityLogger->logSessionAnomalyDetected($user, [
                'score' => $score,
                'anomalies' => $anomalies,
                'session_id' => $sessionId
            ]);
            return true;
        }

        return false;
    }

    /**
     * Detecta anomalías para todas las sesiones activas de un usuario.
     * Retorna un array asociativo [sessionId => [anomalies...]] para sesiones sospechosas.
     */
    public function detectForUser(User $user): array
    {
        $results = [];

        $sessions = $this->em->getRepository(LoginSession::class)
            ->findBy(['user' => $user, 'isActive' => true]);

        foreach ($sessions as $s) {
            // Reusar detect() por sesión
            if ($this->detect($user, $s->getSessionId())) {
                $results[$s->getId()] = [
                    'sessionId' => $s->getSessionId(),
                    'ip' => $s->getIpAddress(),
                    'userAgent' => $s->getUserAgent(),
                    'lastActivityAt' => $s->getLastActivityAt(),
                ];
            }
        }

        return $results;
    }

    private function detectIpChange(LoginSession $session, ?string $currentIp): bool
    {
        if (!$currentIp) {
            return false;
        }
        return $session->getIpAddress() !== $currentIp;
    }

    private function detectUserAgentChange(LoginSession $session, ?string $currentUserAgent): bool
    {
        if (!$currentUserAgent) {
            return false;
        }
        return $session->getUserAgent() !== $currentUserAgent;
    }

    private function detectMultipleSessions(User $user): bool
    {
        $cutoffTime = new \DateTime('-' . self::MULTIPLE_SESSIONS_WINDOW . ' seconds');

        $qb = $this->em->createQueryBuilder();
        $qb->select('COUNT(DISTINCT ls.ipAddress)')
            ->from(LoginSession::class, 'ls')
            ->where('ls.user = :user')
            ->andWhere('ls.isActive = true')
            ->andWhere('ls.lastActivityAt > :cutoff')
            ->setParameter('user', $user)
            ->setParameter('cutoff', $cutoffTime);

        $distinctIpCount = $qb->getQuery()->getSingleScalarResult();

        return $distinctIpCount >= 3;
    }

    private function detectBotPattern(User $user): bool
    {
        // Obtener requests del último minuto
        $cutoffTime = new \DateTime('-1 minute');

        $qb = $this->em->createQueryBuilder();
        $qb->select('COUNT(ls.id)')
            ->from(LoginSession::class, 'ls')
            ->where('ls.user = :user')
            ->andWhere('ls.lastActivityAt > :cutoff')
            ->setParameter('user', $user)
            ->setParameter('cutoff', $cutoffTime);

        $requestCount = $qb->getQuery()->getSingleScalarResult();

        // Más de 50 requests por minuto es sospechoso
        if ($requestCount > self::BOT_REQUEST_THRESHOLD) {
            return true;
        }

        // Analizar desviación estándar de intervalos de tiempo
        // (Bots tienen patrones muy regulares, humanos son más aleatorios)
        // Simplificación: si hay actividad muy constante, es sospechoso

        return false; // Implementación simplificada
    }

    private function checkThreatIntelligence(string $ipAddress): bool
    {
        // Verificar si la IP está en la lista de IPs bloqueadas
        $qb = $this->em->createQueryBuilder();
        $qb->select('COUNT(bi.id)')
            ->from(\App\Entity\BlockedIp::class, 'bi')
            ->where('bi.ipAddress = :ip')
            ->andWhere('bi.riskScore > 70')
            ->andWhere('(bi.blockedUntil IS NULL OR bi.blockedUntil > :now)')
            ->setParameter('ip', $ipAddress)
            ->setParameter('now', new \DateTime());

        try {
            $count = $qb->getQuery()->getSingleScalarResult();
            return $count > 0;
        } catch (\Exception $e) {
            // Tabla no existe aún
            return false;
        }
    }
}
