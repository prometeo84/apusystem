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
                    // Build safe path from parsed components (avoid redirecting to an absolute URL)
                    $path = isset($parsed['path']) ? $parsed['path'] : '/';
                    if (isset($parsed['query'])) {
                        $path .= '?'.$parsed['query'];
                    }
                    return $this->redirect($path);
                }
            } elseif (isset($parsed['path']) && strpos($parsed['path'], '/') === 0) {
                // Relative path starting with / is safe
                $path = $parsed['path'];
                if (isset($parsed['query'])) {
                    $path .= '?'.$parsed['query'];
                }
                return $this->redirect($path);
            }
            // Otherwise ignore referer to avoid open redirect
        }

        return $this->redirectToRoute('app_login');
    }
}
