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

/* partials/_sidebar.html.twig */
class __TwigTemplate_ae2cd9a870eb744671283ebcf0b1c3e1 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "partials/_sidebar.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "partials/_sidebar.html.twig"));

        // line 1
        yield "<div class=\"sidebar\" style=\"width: 250px;\">
    <div class=\"p-3\">
        <h4 class=\"mb-4\" style=\"color: var(--primary-color);\">
            <i class=\"bi bi-calculator\"></i> APU System
        </h4>

        <div class=\"mb-4\">
            <div class=\"d-flex align-items-center\">
                <div class=\"bg-primary rounded-circle text-white d-flex align-items-center justify-content-center\" style=\"width: 40px; height: 40px;\">
                    ";
        // line 10
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::first($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 10, $this->source); })()), "user", [], "any", false, false, false, 10), "firstName", [], "any", false, false, false, 10)), "html", null, true);
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::first($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 10, $this->source); })()), "user", [], "any", false, false, false, 10), "lastName", [], "any", false, false, false, 10)), "html", null, true);
        yield "
                </div>
                <div class=\"ms-2\">
                    <div class=\"fw-bold small\">";
        // line 13
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 13, $this->source); })()), "user", [], "any", false, false, false, 13), "fullName", [], "any", false, false, false, 13), "html", null, true);
        yield "</div>
                    ";
        // line 14
        if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_SUPER_ADMIN")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 15
            yield "                        <small class=\"text-muted\"><i class=\"bi bi-shield-fill\"></i> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.system_admin"), "html", null, true);
            yield "</small>
                    ";
        } else {
            // line 17
            yield "                        <small class=\"text-muted\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 17, $this->source); })()), "user", [], "any", false, false, false, 17), "tenant", [], "any", false, false, false, 17), "name", [], "any", false, false, false, 17), "html", null, true);
            yield "</small>
                    ";
        }
        // line 19
        yield "                </div>
            </div>
        </div>

        <nav class=\"nav flex-column\">
            ";
        // line 24
        if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_SUPER_ADMIN")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 25
            yield "                ";
            // line 26
            yield "                <small class=\"text-muted text-uppercase px-3 mb-2 d-block\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.system_management"), "html", null, true);
            yield "</small>

                <a class=\"nav-link ";
            // line 28
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 28, $this->source); })()), "request", [], "any", false, false, false, 28), "get", ["_route"], "method", false, false, false, 28) == "app_system")) {
                yield "active";
            }
            yield "\"
                   href=\"";
            // line 29
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system");
            yield "\">
                    <i class=\"bi bi-speedometer2\"></i> ";
            // line 30
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.dashboard"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link ";
            // line 32
            if ((is_string($_v0 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 32, $this->source); })()), "request", [], "any", false, false, false, 32), "get", ["_route"], "method", false, false, false, 32)) && is_string($_v1 = "app_system_tenants") && str_starts_with($_v0, $_v1))) {
                yield "active";
            }
            yield "\"
                   href=\"";
            // line 33
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_tenants");
            yield "\">
                    <i class=\"bi bi-building\"></i> ";
            // line 34
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.companies"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link ";
            // line 36
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 36, $this->source); })()), "request", [], "any", false, false, false, 36), "get", ["_route"], "method", false, false, false, 36) == "app_system_monitoring")) {
                yield "active";
            }
            yield "\"
                   href=\"";
            // line 37
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_monitoring");
            yield "\">
                    <i class=\"bi bi-activity\"></i> ";
            // line 38
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.monitoring"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link ";
            // line 40
            if ((is_string($_v2 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 40, $this->source); })()), "request", [], "any", false, false, false, 40), "get", ["_route"], "method", false, false, false, 40)) && is_string($_v3 = "app_admin") && str_starts_with($_v2, $_v3))) {
                yield "active";
            }
            yield "\"
                   href=\"";
            // line 41
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin");
            yield "\">
                    <i class=\"bi bi-shield-lock\"></i> ";
            // line 42
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.security_logs"), "html", null, true);
            yield "
                </a>

                <hr class=\"my-2\">

                <small class=\"text-muted text-uppercase px-3 mb-2 d-block\">";
            // line 47
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.tools"), "html", null, true);
            yield "</small>
                <a class=\"nav-link ";
            // line 48
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 48, $this->source); })()), "request", [], "any", false, false, false, 48), "get", ["_route"], "method", false, false, false, 48) == "app_system_errors")) {
                yield "active";
            }
            yield "\"
                   href=\"";
            // line 49
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_errors");
            yield "\">
                    <i class=\"bi bi-bug\"></i> ";
            // line 50
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.system_errors"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link ";
            // line 52
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 52, $this->source); })()), "request", [], "any", false, false, false, 52), "get", ["_route"], "method", false, false, false, 52) == "app_system_alerts")) {
                yield "active";
            }
            yield "\"
                   href=\"";
            // line 53
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_alerts");
            yield "\">
                    <i class=\"bi bi-bell\"></i> ";
            // line 54
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.alerts"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link ";
            // line 56
            if ((is_string($_v4 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 56, $this->source); })()), "request", [], "any", false, false, false, 56), "get", ["_route"], "method", false, false, false, 56)) && is_string($_v5 = "app_test") && str_starts_with($_v4, $_v5))) {
                yield "active";
            }
            yield "\"
                   href=\"";
            // line 57
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_test_logs");
            yield "\">
                    <i class=\"bi bi-terminal\"></i> ";
            // line 58
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.tests"), "html", null, true);
            yield "
                </a>
            ";
        } else {
            // line 61
            yield "                ";
            // line 62
            yield "                <a class=\"nav-link ";
            if ((is_string($_v6 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 62, $this->source); })()), "request", [], "any", false, false, false, 62), "get", ["_route"], "method", false, false, false, 62)) && is_string($_v7 = "app_dashboard") && str_starts_with($_v6, $_v7))) {
                yield "active";
            }
            yield "\"
                   href=\"";
            // line 63
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_dashboard");
            yield "\">
                    <i class=\"bi bi-speedometer2\"></i> ";
            // line 64
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.dashboard"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-folder\"></i> ";
            // line 67
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("dashboard.projects"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-file-earmark-bar-graph\"></i> ";
            // line 70
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("dashboard.apus"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-file-earmark-text\"></i> ";
            // line 73
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("dashboard.templates"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-tags\"></i> Rubros
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-box\"></i> Materiales
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-people\"></i> Mano de Obra
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-tools\"></i> Equipos
                </a>

                <hr class=\"my-2\">

                ";
            // line 90
            if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_ADMIN")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 91
                yield "                    <a class=\"nav-link ";
                if ((is_string($_v8 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 91, $this->source); })()), "request", [], "any", false, false, false, 91), "get", ["_route"], "method", false, false, false, 91)) && is_string($_v9 = "app_admin") && str_starts_with($_v8, $_v9))) {
                    yield "active";
                }
                yield "\"
                       href=\"";
                // line 92
                yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin");
                yield "\">
                        <i class=\"bi bi-gear\"></i> ";
                // line 93
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.admin"), "html", null, true);
                yield "
                    </a>
                ";
            }
            // line 96
            yield "            ";
        }
        // line 97
        yield "
            <a class=\"nav-link ";
        // line 98
        if (((is_string($_v10 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 98, $this->source); })()), "request", [], "any", false, false, false, 98), "get", ["_route"], "method", false, false, false, 98)) && is_string($_v11 = "app_profile") && str_starts_with($_v10, $_v11)) && (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 98, $this->source); })()), "request", [], "any", false, false, false, 98), "get", ["_route"], "method", false, false, false, 98) != "app_profile_preferences"))) {
            yield "active";
        }
        yield "\"
               href=\"";
        // line 99
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_profile");
        yield "\">
                <i class=\"bi bi-person-circle\"></i> ";
        // line 100
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.profile"), "html", null, true);
        yield "
            </a>

            <a class=\"nav-link ";
        // line 103
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 103, $this->source); })()), "request", [], "any", false, false, false, 103), "get", ["_route"], "method", false, false, false, 103) == "app_profile_preferences")) {
            yield "active";
        }
        yield "\"
               href=\"";
        // line 104
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_profile_preferences");
        yield "\">
                <i class=\"bi bi-palette\"></i> ";
        // line 105
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.title"), "html", null, true);
        yield "
            </a>

            <a class=\"nav-link ";
        // line 108
        if ((is_string($_v12 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 108, $this->source); })()), "request", [], "any", false, false, false, 108), "get", ["_route"], "method", false, false, false, 108)) && is_string($_v13 = "app_security") && str_starts_with($_v12, $_v13))) {
            yield "active";
        }
        yield "\"
               href=\"";
        // line 109
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_security");
        yield "\">
                <i class=\"bi bi-shield-check\"></i> ";
        // line 110
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.security"), "html", null, true);
        yield "
            </a>
            <a class=\"nav-link\" href=\"";
        // line 112
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_logout");
        yield "\">
                <i class=\"bi bi-box-arrow-right\"></i> ";
        // line 113
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.logout"), "html", null, true);
        yield "
            </a>
        </nav>
    </div>
</div>
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
        return "partials/_sidebar.html.twig";
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
        return array (  341 => 113,  337 => 112,  332 => 110,  328 => 109,  322 => 108,  316 => 105,  312 => 104,  306 => 103,  300 => 100,  296 => 99,  290 => 98,  287 => 97,  284 => 96,  278 => 93,  274 => 92,  267 => 91,  265 => 90,  245 => 73,  239 => 70,  233 => 67,  227 => 64,  223 => 63,  216 => 62,  214 => 61,  208 => 58,  204 => 57,  198 => 56,  193 => 54,  189 => 53,  183 => 52,  178 => 50,  174 => 49,  168 => 48,  164 => 47,  156 => 42,  152 => 41,  146 => 40,  141 => 38,  137 => 37,  131 => 36,  126 => 34,  122 => 33,  116 => 32,  111 => 30,  107 => 29,  101 => 28,  95 => 26,  93 => 25,  91 => 24,  84 => 19,  78 => 17,  72 => 15,  70 => 14,  66 => 13,  59 => 10,  48 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<div class=\"sidebar\" style=\"width: 250px;\">
    <div class=\"p-3\">
        <h4 class=\"mb-4\" style=\"color: var(--primary-color);\">
            <i class=\"bi bi-calculator\"></i> APU System
        </h4>

        <div class=\"mb-4\">
            <div class=\"d-flex align-items-center\">
                <div class=\"bg-primary rounded-circle text-white d-flex align-items-center justify-content-center\" style=\"width: 40px; height: 40px;\">
                    {{ app.user.firstName|first }}{{ app.user.lastName|first }}
                </div>
                <div class=\"ms-2\">
                    <div class=\"fw-bold small\">{{ app.user.fullName }}</div>
                    {% if is_granted('ROLE_SUPER_ADMIN') %}
                        <small class=\"text-muted\"><i class=\"bi bi-shield-fill\"></i> {{ 'nav.system_admin'|trans }}</small>
                    {% else %}
                        <small class=\"text-muted\">{{ app.user.tenant.name }}</small>
                    {% endif %}
                </div>
            </div>
        </div>

        <nav class=\"nav flex-column\">
            {% if is_granted('ROLE_SUPER_ADMIN') %}
                {# Menú para Super Administrador del Sistema #}
                <small class=\"text-muted text-uppercase px-3 mb-2 d-block\">{{ 'nav.system_management'|trans }}</small>

                <a class=\"nav-link {% if app.request.get('_route') == 'app_system' %}active{% endif %}\"
                   href=\"{{ path('app_system') }}\">
                    <i class=\"bi bi-speedometer2\"></i> {{ 'nav.dashboard'|trans }}
                </a>
                <a class=\"nav-link {% if app.request.get('_route') starts with 'app_system_tenants' %}active{% endif %}\"
                   href=\"{{ path('app_system_tenants') }}\">
                    <i class=\"bi bi-building\"></i> {{ 'nav.companies'|trans }}
                </a>
                <a class=\"nav-link {% if app.request.get('_route') == 'app_system_monitoring' %}active{% endif %}\"
                   href=\"{{ path('app_system_monitoring') }}\">
                    <i class=\"bi bi-activity\"></i> {{ 'nav.monitoring'|trans }}
                </a>
                <a class=\"nav-link {% if app.request.get('_route') starts with 'app_admin' %}active{% endif %}\"
                   href=\"{{ path('app_admin') }}\">
                    <i class=\"bi bi-shield-lock\"></i> {{ 'nav.security_logs'|trans }}
                </a>

                <hr class=\"my-2\">

                <small class=\"text-muted text-uppercase px-3 mb-2 d-block\">{{ 'nav.tools'|trans }}</small>
                <a class=\"nav-link {% if app.request.get('_route') == 'app_system_errors' %}active{% endif %}\"
                   href=\"{{ path('app_system_errors') }}\">
                    <i class=\"bi bi-bug\"></i> {{ 'nav.system_errors'|trans }}
                </a>
                <a class=\"nav-link {% if app.request.get('_route') == 'app_system_alerts' %}active{% endif %}\"
                   href=\"{{ path('app_system_alerts') }}\">
                    <i class=\"bi bi-bell\"></i> {{ 'nav.alerts'|trans }}
                </a>
                <a class=\"nav-link {% if app.request.get('_route') starts with 'app_test' %}active{% endif %}\"
                   href=\"{{ path('app_test_logs') }}\">
                    <i class=\"bi bi-terminal\"></i> {{ 'nav.tests'|trans }}
                </a>
            {% else %}
                {# Menú para usuarios de empresa #}
                <a class=\"nav-link {% if app.request.get('_route') starts with 'app_dashboard' %}active{% endif %}\"
                   href=\"{{ path('app_dashboard') }}\">
                    <i class=\"bi bi-speedometer2\"></i> {{ 'nav.dashboard'|trans }}
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-folder\"></i> {{ 'dashboard.projects'|trans }}
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-file-earmark-bar-graph\"></i> {{ 'dashboard.apus'|trans }}
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-file-earmark-text\"></i> {{ 'dashboard.templates'|trans }}
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-tags\"></i> Rubros
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-box\"></i> Materiales
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-people\"></i> Mano de Obra
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-tools\"></i> Equipos
                </a>

                <hr class=\"my-2\">

                {% if is_granted('ROLE_ADMIN') %}
                    <a class=\"nav-link {% if app.request.get('_route') starts with 'app_admin' %}active{% endif %}\"
                       href=\"{{ path('app_admin') }}\">
                        <i class=\"bi bi-gear\"></i> {{ 'nav.admin'|trans }}
                    </a>
                {% endif %}
            {% endif %}

            <a class=\"nav-link {% if app.request.get('_route') starts with 'app_profile' and app.request.get('_route') != 'app_profile_preferences' %}active{% endif %}\"
               href=\"{{ path('app_profile') }}\">
                <i class=\"bi bi-person-circle\"></i> {{ 'nav.profile'|trans }}
            </a>

            <a class=\"nav-link {% if app.request.get('_route') == 'app_profile_preferences' %}active{% endif %}\"
               href=\"{{ path('app_profile_preferences') }}\">
                <i class=\"bi bi-palette\"></i> {{ 'preferences.title'|trans }}
            </a>

            <a class=\"nav-link {% if app.request.get('_route') starts with 'app_security' %}active{% endif %}\"
               href=\"{{ path('app_security') }}\">
                <i class=\"bi bi-shield-check\"></i> {{ 'nav.security'|trans }}
            </a>
            <a class=\"nav-link\" href=\"{{ path('app_logout') }}\">
                <i class=\"bi bi-box-arrow-right\"></i> {{ 'nav.logout'|trans }}
            </a>
        </nav>
    </div>
</div>
", "partials/_sidebar.html.twig", "/var/www/html/proyecto/templates/partials/_sidebar.html.twig");
    }
}
