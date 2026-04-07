<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* @Maker/security/custom/Authenticator.tpl.php */
class __TwigTemplate_805c2d17894784643b7b8f0fdd9b83b8 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/security/custom/Authenticator.tpl.php"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/security/custom/Authenticator.tpl.php"));

        // line 1
        yield "<?= \"<?php\\n\" ?>

namespace <?= \$namespace; ?>;

<?= \$use_statements; ?>

/**
* @see https://symfony.com/doc/current/security/custom_authenticator.html
*/
class <?= \$class_short_name ?> extends AbstractAuthenticator
{
    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request \$request): ?bool
    {
        // return \$request->headers->has('X-AUTH-TOKEN');
    }

    public function authenticate(Request \$request): Passport
    {
        // \$apiToken = \$request->headers->get('X-AUTH-TOKEN');
        // if (null === \$apiToken) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 \"Unauthorized\"
            // throw new CustomUserMessageAuthenticationException('No API token provided');
        // }

        // implement your own logic to get the user identifier from `\$apiToken`
        // e.g. by looking up a user in the database using its API key
        // \$userIdentifier = /** ... */;

        // return new SelfValidatingPassport(new UserBadge(\$userIdentifier));
    }

    public function onAuthenticationSuccess(Request \$request, TokenInterface \$token, string \$firewallName): ?Response
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request \$request, AuthenticationException \$exception): ?Response
    {
        \$data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr(\$exception->getMessageKey(), \$exception->getMessageData())

            // or to translate this message
            // \$this->translator->trans(\$exception->getMessageKey(), \$exception->getMessageData())
        ];

        return new JsonResponse(\$data, Response::HTTP_UNAUTHORIZED);
    }

    // public function start(Request \$request, ?AuthenticationException \$authException = null): Response
    // {
    //     /*
    //      * If you would like this class to control what happens when an anonymous user accesses a
    //      * protected page (e.g. redirect to /login), uncomment this method and make this class
    //      * implement Symfony\\Component\\Security\\Http\\EntryPoint\\AuthenticationEntryPointInterface.
    //      *
    //      * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
    //      */
    // }
}
";
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "@Maker/security/custom/Authenticator.tpl.php";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  48 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<?= \"<?php\\n\" ?>

namespace <?= \$namespace; ?>;

<?= \$use_statements; ?>

/**
* @see https://symfony.com/doc/current/security/custom_authenticator.html
*/
class <?= \$class_short_name ?> extends AbstractAuthenticator
{
    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request \$request): ?bool
    {
        // return \$request->headers->has('X-AUTH-TOKEN');
    }

    public function authenticate(Request \$request): Passport
    {
        // \$apiToken = \$request->headers->get('X-AUTH-TOKEN');
        // if (null === \$apiToken) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 \"Unauthorized\"
            // throw new CustomUserMessageAuthenticationException('No API token provided');
        // }

        // implement your own logic to get the user identifier from `\$apiToken`
        // e.g. by looking up a user in the database using its API key
        // \$userIdentifier = /** ... */;

        // return new SelfValidatingPassport(new UserBadge(\$userIdentifier));
    }

    public function onAuthenticationSuccess(Request \$request, TokenInterface \$token, string \$firewallName): ?Response
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request \$request, AuthenticationException \$exception): ?Response
    {
        \$data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr(\$exception->getMessageKey(), \$exception->getMessageData())

            // or to translate this message
            // \$this->translator->trans(\$exception->getMessageKey(), \$exception->getMessageData())
        ];

        return new JsonResponse(\$data, Response::HTTP_UNAUTHORIZED);
    }

    // public function start(Request \$request, ?AuthenticationException \$authException = null): Response
    // {
    //     /*
    //      * If you would like this class to control what happens when an anonymous user accesses a
    //      * protected page (e.g. redirect to /login), uncomment this method and make this class
    //      * implement Symfony\\Component\\Security\\Http\\EntryPoint\\AuthenticationEntryPointInterface.
    //      *
    //      * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
    //      */
    // }
}
", "@Maker/security/custom/Authenticator.tpl.php", "/var/www/html/proyecto/vendor/symfony/maker-bundle/templates/security/custom/Authenticator.tpl.php");
    }
}
