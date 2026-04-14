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
            // Only allow redirects to the same host or relative paths to avoid open redirect
            $parsed = parse_url($referer);
            if (isset($parsed['host'])) {
                if ($parsed['host'] === $request->getHost()) {
                    return $this->redirect($referer);
                }
            } else {
                // relative path
                return $this->redirect($referer);
            }
        }

        return $this->redirectToRoute('app_login');
    }
}
