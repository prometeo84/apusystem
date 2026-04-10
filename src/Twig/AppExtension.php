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
            new TwigFunction('vite_entry_link_tags', [$this, 'viteEntryLinkTags'], ['is_safe' => ['html']]),
            new TwigFunction('vite_entry_script_tags', [$this, 'viteEntryScriptTags'], ['is_safe' => ['html']]),
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

    /**
     * Genera los tags <link> para los CSS de un entry de Vite leyendo el manifest.json
     */
    public function viteEntryLinkTags(string $entryName): string
    {
        $assets = $this->readViteManifest($entryName);
        $html = '';
        foreach ($assets['css'] as $cssFile) {
            $html .= sprintf('<link rel="stylesheet" href="/build/%s">', htmlspecialchars($cssFile, ENT_QUOTES));
        }
        return $html;
    }

    /**
     * Genera los tags <script> para los JS de un entry de Vite leyendo el manifest.json
     */
    public function viteEntryScriptTags(string $entryName): string
    {
        $assets = $this->readViteManifest($entryName);
        $html = '';
        if ($assets['js']) {
            $html .= sprintf('<script type="module" src="/build/%s"></script>', htmlspecialchars($assets['js'], ENT_QUOTES));
        }
        return $html;
    }

    private function readViteManifest(string $entryName): array
    {
        static $manifest = null;
        if ($manifest === null) {
            $manifestPath = dirname(__DIR__, 2) . '/public/build/.vite/manifest.json';
            if (!file_exists($manifestPath)) {
                return ['css' => [], 'js' => null];
            }
            $manifest = json_decode(file_get_contents($manifestPath), true) ?? [];
        }

        $css = [];
        $js  = null;

        // Search by entry source path (e.g. "assets/app.js") or by name
        foreach ($manifest as $src => $entry) {
            if (($entry['name'] ?? '') === $entryName || str_ends_with($src, "/{$entryName}.js") || $src === "assets/{$entryName}.js") {
                $js  = $entry['file'] ?? null;
                $css = $entry['css'] ?? [];
                break;
            }
        }

        return ['css' => $css, 'js' => $js];
    }
}
