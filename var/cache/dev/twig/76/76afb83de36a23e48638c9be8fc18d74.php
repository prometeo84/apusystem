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

/* @Maker/authenticator/LoginFormAuthenticator.tpl.php */
class __TwigTemplate_bee7812289f61abfe8b1aa680950f21e extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/authenticator/LoginFormAuthenticator.tpl.php"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/authenticator/LoginFormAuthenticator.tpl.php"));

        // line 1
        yield "<?= \"<?php\\n\" ?>

namespace <?= \$namespace ?>;

<?= \$use_statements; ?>

class <?= \$class_name; ?> extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface \$urlGenerator)
    {
    }

    public function authenticate(Request \$request): Passport
    {
        \$<?= \$username_field_var ?> = \$request->getPayload()->getString('<?= \$username_field ?>');

        \$request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, \$<?= \$username_field_var ?>);

        return new Passport(
            new UserBadge(\$<?= \$username_field_var ?>),
            new PasswordCredentials(\$request->getPayload()->getString('password')),
            [
                new CsrfTokenBadge('authenticate', \$request->getPayload()->getString('_csrf_token')),<?= \$remember_me_badge ? \"
                new RememberMeBadge(),\\n\" : \"\" ?>
            ]
        );
    }

    public function onAuthenticationSuccess(Request \$request, TokenInterface \$token, string \$firewallName): ?Response
    {
        if (\$targetPath = \$this->getTargetPath(\$request->getSession(), \$firewallName)) {
            return new RedirectResponse(\$targetPath);
        }

        // For example:
        // return new RedirectResponse(\$this->urlGenerator->generate('some_route'));
        throw new \\Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl(Request \$request): string
    {
        return \$this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
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
        return "@Maker/authenticator/LoginFormAuthenticator.tpl.php";
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

namespace <?= \$namespace ?>;

<?= \$use_statements; ?>

class <?= \$class_name; ?> extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface \$urlGenerator)
    {
    }

    public function authenticate(Request \$request): Passport
    {
        \$<?= \$username_field_var ?> = \$request->getPayload()->getString('<?= \$username_field ?>');

        \$request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, \$<?= \$username_field_var ?>);

        return new Passport(
            new UserBadge(\$<?= \$username_field_var ?>),
            new PasswordCredentials(\$request->getPayload()->getString('password')),
            [
                new CsrfTokenBadge('authenticate', \$request->getPayload()->getString('_csrf_token')),<?= \$remember_me_badge ? \"
                new RememberMeBadge(),\\n\" : \"\" ?>
            ]
        );
    }

    public function onAuthenticationSuccess(Request \$request, TokenInterface \$token, string \$firewallName): ?Response
    {
        if (\$targetPath = \$this->getTargetPath(\$request->getSession(), \$firewallName)) {
            return new RedirectResponse(\$targetPath);
        }

        // For example:
        // return new RedirectResponse(\$this->urlGenerator->generate('some_route'));
        throw new \\Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl(Request \$request): string
    {
        return \$this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
", "@Maker/authenticator/LoginFormAuthenticator.tpl.php", "/var/www/html/proyecto/vendor/symfony/maker-bundle/templates/authenticator/LoginFormAuthenticator.tpl.php");
    }
}
