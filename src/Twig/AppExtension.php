<?php

namespace App\Twig;

use App\Service\UserTimezoneService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * AppExtension
 *
 * Extensión Twig para filtros y funciones personalizadas.
 * Incluye filtros para formatear fechas con zona horaria del usuario.
 */
class AppExtension extends AbstractExtension
{
    private UserTimezoneService $timezoneService;

    public function __construct(UserTimezoneService $timezoneService)
    {
        $this->timezoneService = $timezoneService;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('user_timezone', [$this, 'formatUserTimezone']),
            new TwigFilter('user_date', [$this, 'formatUserDate']),
            new TwigFilter('user_datetime', [$this, 'formatUserDateTime']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('user_timezone', [$this, 'getUserTimezone']),
        ];
    }

    /**
     * Formatea una fecha con formato personalizado en timezone del usuario
     */
    public function formatUserTimezone(\DateTimeInterface $datetime, string $format = 'd/m/Y H:i:s'): string
    {
        return $this->timezoneService->formatInUserTimezone($datetime, $format);
    }

    /**
     * Formatea una fecha (solo día) en timezone del usuario
     */
    public function formatUserDate(\DateTimeInterface $datetime): string
    {
        return $this->timezoneService->formatInUserTimezone($datetime, 'd/m/Y');
    }

    /**
     * Formatea una fecha y hora en timezone del usuario
     */
    public function formatUserDateTime(\DateTimeInterface $datetime): string
    {
        return $this->timezoneService->formatInUserTimezone($datetime, 'd/m/Y H:i:s');
    }

    /**
     * Obtiene la zona horaria del usuario autenticado
     */
    public function getUserTimezone(): string
    {
        return $this->timezoneService->getUserTimezone();
    }
}
