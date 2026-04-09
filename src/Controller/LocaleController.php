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
            return $this->redirect($referer);
        }

        return $this->redirectToRoute('app_login');
    }
}
