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

/* partials/_navbar.html.twig */
class __TwigTemplate_195e7d70615122033d26f8115c4c6efd extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "partials/_navbar.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "partials/_navbar.html.twig"));

        // line 1
        $macros["btn"] = $this->macros["btn"] = $this->load("partials/_button.html.twig", 1)->unwrap();
        // line 2
        yield "
<nav class=\"navbar navbar-expand-lg navbar-light bg-white\">
    <div class=\"container-fluid\">
        <span class=\"navbar-brand mb-0 h1\">";
        // line 5
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((array_key_exists("title", $context)) ? (Twig\Extension\CoreExtension::default((isset($context["title"]) || array_key_exists("title", $context) ? $context["title"] : (function () { throw new RuntimeError('Variable "title" does not exist.', 5, $this->source); })()), "Dashboard")) : ("Dashboard")), "html", null, true);
        yield "</span>

        <div class=\"d-flex align-items-center\">
            <span class=\"badge bg-secondary me-3\">";
        // line 8
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 8, $this->source); })()), "user", [], "any", false, false, false, 8), "tenant", [], "any", false, false, false, 8), "plan", [], "any", false, false, false, 8)), "html", null, true);
        yield "</span>
            <span class=\"text-muted me-3\">
                <i class=\"bi bi-calendar\"></i> ";
        // line 10
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "d/m/Y"), "html", null, true);
        yield "
            </span>
            <div class=\"dropdown\">
                ";
        // line 13
        yield $macros["btn"]->getTemplateForMacro("macro_button", $context, 13, $this->getSourceContext())->macro_button(...["", "link", null, ["type" => "button", "class" => "btn-link text-decoration-none dropdown-toggle", "id" => "userDropdown", "data-bs-toggle" => "dropdown"]]);
        yield "
                <ul class=\"dropdown-menu dropdown-menu-end\">
                    <li><a class=\"dropdown-item\" href=\"";
        // line 15
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_profile");
        yield "\">
                        <i class=\"bi bi-person\"></i> ";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.profile"), "html", null, true);
        yield "
                    </a></li>
                    <li><a class=\"dropdown-item\" href=\"";
        // line 18
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_security");
        yield "\">
                        <i class=\"bi bi-shield-check\"></i> ";
        // line 19
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.security"), "html", null, true);
        yield "
                    </a></li>
                    <li><hr class=\"dropdown-divider\"></li>
                    <li><a class=\"dropdown-item\" href=\"";
        // line 22
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_logout");
        yield "\">
                        <i class=\"bi bi-box-arrow-right\"></i> ";
        // line 23
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("auth.logout"), "html", null, true);
        yield "
                    </a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
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
        return "partials/_navbar.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  100 => 23,  96 => 22,  90 => 19,  86 => 18,  81 => 16,  77 => 15,  72 => 13,  66 => 10,  61 => 8,  55 => 5,  50 => 2,  48 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% import 'partials/_button.html.twig' as btn %}

<nav class=\"navbar navbar-expand-lg navbar-light bg-white\">
    <div class=\"container-fluid\">
        <span class=\"navbar-brand mb-0 h1\">{{ title|default('Dashboard') }}</span>

        <div class=\"d-flex align-items-center\">
            <span class=\"badge bg-secondary me-3\">{{ app.user.tenant.plan|upper }}</span>
            <span class=\"text-muted me-3\">
                <i class=\"bi bi-calendar\"></i> {{ 'now'|date('d/m/Y') }}
            </span>
            <div class=\"dropdown\">
                {{ btn.button('', 'link', null, {'type':'button','class':'btn-link text-decoration-none dropdown-toggle','id':'userDropdown','data-bs-toggle':'dropdown'}) }}
                <ul class=\"dropdown-menu dropdown-menu-end\">
                    <li><a class=\"dropdown-item\" href=\"{{ path('app_profile') }}\">
                        <i class=\"bi bi-person\"></i> {{ 'nav.profile'|trans }}
                    </a></li>
                    <li><a class=\"dropdown-item\" href=\"{{ path('app_security') }}\">
                        <i class=\"bi bi-shield-check\"></i> {{ 'nav.security'|trans }}
                    </a></li>
                    <li><hr class=\"dropdown-divider\"></li>
                    <li><a class=\"dropdown-item\" href=\"{{ path('app_logout') }}\">
                        <i class=\"bi bi-box-arrow-right\"></i> {{ 'auth.logout'|trans }}
                    </a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
", "partials/_navbar.html.twig", "/var/www/html/proyecto/templates/partials/_navbar.html.twig");
    }
}
