<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * UserTimezoneService
 *
 * Servicio para manejar las zonas horarias por usuario.
 * Convierte fechas UTC a la zona horaria del usuario para mostrar.
 *
 * IMPORTANTE: Las fechas en la BD deben guardarse siempre en UTC.
 * Este servicio solo convierte para mostrar al usuario.
 */
class UserTimezoneService
{
    private TokenStorageInterface $tokenStorage;
    private string $systemTimezone;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        string $systemTimezone = 'America/Guayaquil'
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->systemTimezone = $systemTimezone;
    }

    /**
     * Obtiene la zona horaria del usuario autenticado
     *
     * Jerarquía: Usuario → Tenant → Sistema
     * 1. Si el usuario tiene timezone configurado, usa ese
     * 2. Si no, usa el timezone de su empresa (Tenant)
     * 3. Si no hay tenant, usa el timezone del sistema
     */
    public function getUserTimezone(): string
    {
        $token = $this->tokenStorage->getToken();
        if ($token && $token->getUser() instanceof User) {
            $user = $token->getUser();

            // 1. Prioridad: Timezone del usuario
            if ($user->getTimezone()) {
                return $user->getTimezone();
            }

            // 2. Fallback: Timezone del tenant (empresa)
            if ($user->getTenant() && $user->getTenant()->getTimezone()) {
                return $user->getTenant()->getTimezone();
            }
        }

        // 3. Fallback final: Timezone del sistema
        return $this->systemTimezone;
    }

    /**
     * Convierte una fecha UTC a la zona horaria del usuario
     *
     * @param \DateTimeInterface $datetime Fecha en UTC
     * @return \DateTime Fecha en timezone del usuario
     */
    public function convertToUserTimezone(\DateTimeInterface $datetime): \DateTime
    {
        $userTimezone = $this->getUserTimezone();
        $converted = \DateTime::createFromInterface($datetime);
        $converted->setTimezone(new \DateTimeZone($userTimezone));

        return $converted;
    }

    /**
     * Formatea una fecha en la zona horaria del usuario
     *
     * @param \DateTimeInterface $datetime Fecha en UTC
     * @param string $format Formato de salida
     * @return string Fecha formateada
     */
    public function formatInUserTimezone(\DateTimeInterface $datetime, string $format = 'd/m/Y H:i:s'): string
    {
        $converted = $this->convertToUserTimezone($datetime);
        return $converted->format($format);
    }

    /**
     * Convierte una fecha de la zona horaria del usuario a UTC para guardar en BD
     *
     * @param \DateTimeInterface $datetime Fecha en timezone del usuario
     * @return \DateTime Fecha en UTC
     */
    public function convertToUTC(\DateTimeInterface $datetime): \DateTime
    {
        $utc = \DateTime::createFromInterface($datetime);
        $utc->setTimezone(new \DateTimeZone('UTC'));

        return $utc;
    }

    /**
     * Crea una nueva fecha en UTC (para guardar en BD)
     */
    public function createUTCDateTime(string $datetime = 'now'): \DateTime
    {
        return new \DateTime($datetime, new \DateTimeZone('UTC'));
    }

    /**
     * Lista de zonas horarias comunes para el selector
     */
    public static function getCommonTimezones(): array
    {
        return [
            'America/Guayaquil' => 'Ecuador (ECT, UTC-5)',
            'America/New_York' => 'Nueva York (EST/EDT, UTC-5/-4)',
            'America/Chicago' => 'Chicago (CST/CDT, UTC-6/-5)',
            'America/Denver' => 'Denver (MST/MDT, UTC-7/-6)',
            'America/Los_Angeles' => 'Los Ángeles (PST/PDT, UTC-8/-7)',
            'America/Mexico_City' => 'Ciudad de México (CST, UTC-6)',
            'America/Bogota' => 'Bogotá (COT, UTC-5)',
            'America/Lima' => 'Lima (PET, UTC-5)',
            'America/Caracas' => 'Caracas (VET, UTC-4)',
            'America/Santiago' => 'Santiago (CLT, UTC-4/-3)',
            'America/Buenos_Aires' => 'Buenos Aires (ART, UTC-3)',
            'America/Sao_Paulo' => 'São Paulo (BRT, UTC-3)',
            'Europe/London' => 'Londres (GMT/BST, UTC+0/+1)',
            'Europe/Paris' => 'París (CET/CEST, UTC+1/+2)',
            'Europe/Madrid' => 'Madrid (CET/CEST, UTC+1/+2)',
            'Europe/Berlin' => 'Berlín (CET/CEST, UTC+1/+2)',
            'Europe/Moscow' => 'Moscú (MSK, UTC+3)',
            'Asia/Dubai' => 'Dubái (GST, UTC+4)',
            'Asia/Shanghai' => 'Shanghai (CST, UTC+8)',
            'Asia/Tokyo' => 'Tokio (JST, UTC+9)',
            'Australia/Sydney' => 'Sídney (AEDT/AEST, UTC+11/+10)',
            'Pacific/Auckland' => 'Auckland (NZDT/NZST, UTC+13/+12)',
        ];
    }
}
