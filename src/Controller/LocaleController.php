<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class LocaleController extends AbstractController
{
    #[Route('/set-locale/{locale}', name: 'app_set_locale')]
    public function setLocale(Request $request, string $locale): RedirectResponse
    {
        $allowed = ['en', 'es'];
        if (!in_array($locale, $allowed, true)) {
            $locale = $request->getSession()->get('_locale') ?? $this->getParameter('kernel.default_locale');
        }

        $request->getSession()->set('_locale', $locale);

        // Removed ad-hoc debug logging.

        $referer = $request->headers->get('referer');
        if ($referer) {
            // Parse referer and only redirect to safe internal locations.
            $parsed = parse_url($referer);

            // If referer contains a host, ensure it matches current host and scheme is http/https
            if (isset($parsed['host'])) {
                $scheme = isset($parsed['scheme']) ? strtolower($parsed['scheme']) : 'http';
                if ($parsed['host'] === $request->getHost() && in_array($scheme, ['http', 'https'], true)) {
                    // Build safe path: normalize to prevent protocol-relative redirects (// attack)
                    $rawPath = isset($parsed['path']) ? $parsed['path'] : '/';
                    // Remove control characters and ensure single leading slash
                    $rawPath = preg_replace('/[\x00-\x1F\x7F]+/u', '', $rawPath);
                    $path = '/' . ltrim($rawPath, '/');

                    // Safely rebuild query string to avoid injection
                    if (isset($parsed['query'])) {
                        parse_str($parsed['query'], $qarr);
                        $qs = http_build_query($qarr);
                        if ($qs !== '') {
                            $path .= '?' . $qs;
                        }
                    }

                    return $this->redirect($path);
                }
            } elseif (isset($parsed['path']) && strpos($parsed['path'], '/') === 0) {
                // Relative path: normalize to prevent // protocol-relative trick
                $rawPath = $parsed['path'];
                $rawPath = preg_replace('/[\x00-\x1F\x7F]+/u', '', $rawPath);
                $path = '/' . ltrim($rawPath, '/');
                if (isset($parsed['query'])) {
                    parse_str($parsed['query'], $qarr);
                    $qs = http_build_query($qarr);
                    if ($qs !== '') {
                        $path .= '?' . $qs;
                    }
                }
                return $this->redirect($path);
            }
            // Otherwise ignore referer to avoid open redirect
        }

        return $this->redirectToRoute('app_login');
    }
}
