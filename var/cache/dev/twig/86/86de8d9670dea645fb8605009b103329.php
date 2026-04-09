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
                ";
        // line 9
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 9, $this->source); })()), "user", [], "any", false, false, false, 9), "avatar", [], "any", false, false, false, 9)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 10
            yield "                    <img src=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 10, $this->source); })()), "user", [], "any", false, false, false, 10), "avatar", [], "any", false, false, false, 10), "html", null, true);
            yield "\" alt=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 10, $this->source); })()), "user", [], "any", false, false, false, 10), "fullName", [], "any", false, false, false, 10), "html", null, true);
            yield "\" class=\"rounded-circle\" style=\"width:40px;height:40px;object-fit:cover;\">
                ";
        } else {
            // line 12
            yield "                    <div class=\"bg-primary rounded-circle text-white d-flex align-items-center justify-content-center\" style=\"width: 40px; height: 40px;\">
                        ";
            // line 13
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::first($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 13, $this->source); })()), "user", [], "any", false, false, false, 13), "firstName", [], "any", false, false, false, 13)), "html", null, true);
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::first($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 13, $this->source); })()), "user", [], "any", false, false, false, 13), "lastName", [], "any", false, false, false, 13)), "html", null, true);
            yield "
                    </div>
                ";
        }
        // line 16
        yield "                    <div class=\"ms-2\">
                    <div class=\"fw-bold small\">";
        // line 17
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 17, $this->source); })()), "user", [], "any", false, false, false, 17), "fullName", [], "any", false, false, false, 17), "html", null, true);
        yield "</div>
                    ";
        // line 18
        if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_SUPER_ADMIN")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 19
            yield "                        <small class=\"text-muted\"><i class=\"bi bi-shield-fill\"></i> ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.system_admin"), "html", null, true);
            yield "</small>
                    ";
        } else {
            // line 21
            yield "                        <small class=\"text-muted d-flex align-items-center\">
                            ";
            // line 22
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 22, $this->source); })()), "user", [], "any", false, false, false, 22), "tenant", [], "any", false, false, false, 22) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 22, $this->source); })()), "user", [], "any", false, false, false, 22), "tenant", [], "any", false, false, false, 22), "logoUrl", [], "any", false, false, false, 22))) {
                // line 23
                yield "                                <img src=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 23, $this->source); })()), "user", [], "any", false, false, false, 23), "tenant", [], "any", false, false, false, 23), "logoUrl", [], "any", false, false, false, 23), "html", null, true);
                yield "\" alt=\"";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 23, $this->source); })()), "user", [], "any", false, false, false, 23), "tenant", [], "any", false, false, false, 23), "name", [], "any", false, false, false, 23), "html", null, true);
                yield "\" style=\"width:20px;height:20px;object-fit:cover;margin-right:6px;border-radius:3px;\">
                            ";
            }
            // line 25
            yield "                            ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 25, $this->source); })()), "user", [], "any", false, false, false, 25), "tenant", [], "any", false, false, false, 25), "name", [], "any", false, false, false, 25), "html", null, true);
            yield "
                        </small>
                    ";
        }
        // line 28
        yield "                </div>
            </div>
        </div>

        <nav class=\"nav flex-column\">
            ";
        // line 33
        if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_SUPER_ADMIN")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 34
            yield "                ";
            // line 35
            yield "                <small class=\"text-muted text-uppercase px-3 mb-2 d-block\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.system_management"), "html", null, true);
            yield "</small>

                <a class=\"nav-link ";
            // line 37
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 37, $this->source); })()), "request", [], "any", false, false, false, 37), "get", ["_route"], "method", false, false, false, 37) == "app_system")) {
                yield "active";
            }
            yield "\"
                   href=\"";
            // line 38
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system");
            yield "\">
                    <i class=\"bi bi-speedometer2\"></i> ";
            // line 39
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.dashboard"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link ";
            // line 41
            if ((is_string($_v0 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 41, $this->source); })()), "request", [], "any", false, false, false, 41), "get", ["_route"], "method", false, false, false, 41)) && is_string($_v1 = "app_system_tenants") && str_starts_with($_v0, $_v1))) {
                yield "active";
            }
            yield "\"
                   href=\"";
            // line 42
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_tenants");
            yield "\">
                    <i class=\"bi bi-building\"></i> ";
            // line 43
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.companies"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link ";
            // line 45
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 45, $this->source); })()), "request", [], "any", false, false, false, 45), "get", ["_route"], "method", false, false, false, 45) == "app_system_monitoring")) {
                yield "active";
            }
            yield "\"
                   href=\"";
            // line 46
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_monitoring");
            yield "\">
                    <i class=\"bi bi-activity\"></i> ";
            // line 47
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.monitoring"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link ";
            // line 49
            if ((is_string($_v2 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 49, $this->source); })()), "request", [], "any", false, false, false, 49), "get", ["_route"], "method", false, false, false, 49)) && is_string($_v3 = "app_admin") && str_starts_with($_v2, $_v3))) {
                yield "active";
            }
            yield "\"
                   href=\"";
            // line 50
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin");
            yield "\">
                    <i class=\"bi bi-shield-lock\"></i> ";
            // line 51
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.security_logs"), "html", null, true);
            yield "
                </a>

                <hr class=\"my-2\">

                <small class=\"text-muted text-uppercase px-3 mb-2 d-block\">";
            // line 56
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.tools"), "html", null, true);
            yield "</small>
                <a class=\"nav-link ";
            // line 57
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 57, $this->source); })()), "request", [], "any", false, false, false, 57), "get", ["_route"], "method", false, false, false, 57) == "app_system_errors")) {
                yield "active";
            }
            yield "\"
                   href=\"";
            // line 58
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_errors");
            yield "\">
                    <i class=\"bi bi-bug\"></i> ";
            // line 59
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.system_errors"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link ";
            // line 61
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 61, $this->source); })()), "request", [], "any", false, false, false, 61), "get", ["_route"], "method", false, false, false, 61) == "app_system_alerts")) {
                yield "active";
            }
            yield "\"
                   href=\"";
            // line 62
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_alerts");
            yield "\">
                    <i class=\"bi bi-bell\"></i> ";
            // line 63
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.alerts"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link ";
            // line 65
            if ((is_string($_v4 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 65, $this->source); })()), "request", [], "any", false, false, false, 65), "get", ["_route"], "method", false, false, false, 65)) && is_string($_v5 = "app_test") && str_starts_with($_v4, $_v5))) {
                yield "active";
            }
            yield "\"
                   href=\"";
            // line 66
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_test_logs");
            yield "\">
                    <i class=\"bi bi-terminal\"></i> ";
            // line 67
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.tests"), "html", null, true);
            yield "
                </a>
            ";
        } else {
            // line 70
            yield "                ";
            // line 71
            yield "                <a class=\"nav-link ";
            if ((is_string($_v6 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 71, $this->source); })()), "request", [], "any", false, false, false, 71), "get", ["_route"], "method", false, false, false, 71)) && is_string($_v7 = "app_dashboard") && str_starts_with($_v6, $_v7))) {
                yield "active";
            }
            yield "\"
                   href=\"";
            // line 72
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_dashboard");
            yield "\">
                    <i class=\"bi bi-speedometer2\"></i> ";
            // line 73
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.dashboard"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-folder\"></i> ";
            // line 76
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("dashboard.projects"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-file-earmark-bar-graph\"></i> ";
            // line 79
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("dashboard.apus"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-file-earmark-text\"></i> ";
            // line 82
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("dashboard.templates"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-tags\"></i> ";
            // line 85
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("dashboard.rubros"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-box\"></i> ";
            // line 88
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("dashboard.materials"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-people\"></i> ";
            // line 91
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("dashboard.labor"), "html", null, true);
            yield "
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-tools\"></i> ";
            // line 94
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("dashboard.equipment"), "html", null, true);
            yield "
                </a>

                <hr class=\"my-2\">

                ";
            // line 99
            if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_ADMIN")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 100
                yield "                    <a class=\"nav-link ";
                if ((is_string($_v8 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 100, $this->source); })()), "request", [], "any", false, false, false, 100), "get", ["_route"], "method", false, false, false, 100)) && is_string($_v9 = "app_admin") && str_starts_with($_v8, $_v9))) {
                    yield "active";
                }
                yield "\"
                       href=\"";
                // line 101
                yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin");
                yield "\">
                        <i class=\"bi bi-gear\"></i> ";
                // line 102
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.admin"), "html", null, true);
                yield "
                    </a>
                ";
            }
            // line 105
            yield "            ";
        }
        // line 106
        yield "
            <a class=\"nav-link ";
        // line 107
        if (((is_string($_v10 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 107, $this->source); })()), "request", [], "any", false, false, false, 107), "get", ["_route"], "method", false, false, false, 107)) && is_string($_v11 = "app_profile") && str_starts_with($_v10, $_v11)) && (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 107, $this->source); })()), "request", [], "any", false, false, false, 107), "get", ["_route"], "method", false, false, false, 107) != "app_profile_preferences"))) {
            yield "active";
        }
        yield "\"
               href=\"";
        // line 108
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_profile");
        yield "\">
                <i class=\"bi bi-person-circle\"></i> ";
        // line 109
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.profile"), "html", null, true);
        yield "
            </a>

            <a class=\"nav-link ";
        // line 112
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 112, $this->source); })()), "request", [], "any", false, false, false, 112), "get", ["_route"], "method", false, false, false, 112) == "app_profile_preferences")) {
            yield "active";
        }
        yield "\"
               href=\"";
        // line 113
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_profile_preferences");
        yield "\">
                <i class=\"bi bi-palette\"></i> ";
        // line 114
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.title"), "html", null, true);
        yield "
            </a>

            <a class=\"nav-link ";
        // line 117
        if ((is_string($_v12 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 117, $this->source); })()), "request", [], "any", false, false, false, 117), "get", ["_route"], "method", false, false, false, 117)) && is_string($_v13 = "app_security") && str_starts_with($_v12, $_v13))) {
            yield "active";
        }
        yield "\"
               href=\"";
        // line 118
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_security");
        yield "\">
                <i class=\"bi bi-shield-check\"></i> ";
        // line 119
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("nav.security"), "html", null, true);
        yield "
            </a>
            <a class=\"nav-link\" href=\"";
        // line 121
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_logout");
        yield "\">
                <i class=\"bi bi-box-arrow-right\"></i> ";
        // line 122
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
        return array (  382 => 122,  378 => 121,  373 => 119,  369 => 118,  363 => 117,  357 => 114,  353 => 113,  347 => 112,  341 => 109,  337 => 108,  331 => 107,  328 => 106,  325 => 105,  319 => 102,  315 => 101,  308 => 100,  306 => 99,  298 => 94,  292 => 91,  286 => 88,  280 => 85,  274 => 82,  268 => 79,  262 => 76,  256 => 73,  252 => 72,  245 => 71,  243 => 70,  237 => 67,  233 => 66,  227 => 65,  222 => 63,  218 => 62,  212 => 61,  207 => 59,  203 => 58,  197 => 57,  193 => 56,  185 => 51,  181 => 50,  175 => 49,  170 => 47,  166 => 46,  160 => 45,  155 => 43,  151 => 42,  145 => 41,  140 => 39,  136 => 38,  130 => 37,  124 => 35,  122 => 34,  120 => 33,  113 => 28,  106 => 25,  98 => 23,  96 => 22,  93 => 21,  87 => 19,  85 => 18,  81 => 17,  78 => 16,  71 => 13,  68 => 12,  60 => 10,  58 => 9,  48 => 1,);
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
                {% if app.user.avatar %}
                    <img src=\"{{ app.user.avatar }}\" alt=\"{{ app.user.fullName }}\" class=\"rounded-circle\" style=\"width:40px;height:40px;object-fit:cover;\">
                {% else %}
                    <div class=\"bg-primary rounded-circle text-white d-flex align-items-center justify-content-center\" style=\"width: 40px; height: 40px;\">
                        {{ app.user.firstName|first }}{{ app.user.lastName|first }}
                    </div>
                {% endif %}
                    <div class=\"ms-2\">
                    <div class=\"fw-bold small\">{{ app.user.fullName }}</div>
                    {% if is_granted('ROLE_SUPER_ADMIN') %}
                        <small class=\"text-muted\"><i class=\"bi bi-shield-fill\"></i> {{ 'nav.system_admin'|trans }}</small>
                    {% else %}
                        <small class=\"text-muted d-flex align-items-center\">
                            {% if app.user.tenant and app.user.tenant.logoUrl %}
                                <img src=\"{{ app.user.tenant.logoUrl }}\" alt=\"{{ app.user.tenant.name }}\" style=\"width:20px;height:20px;object-fit:cover;margin-right:6px;border-radius:3px;\">
                            {% endif %}
                            {{ app.user.tenant.name }}
                        </small>
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
                    <i class=\"bi bi-tags\"></i> {{ 'dashboard.rubros'|trans }}
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-box\"></i> {{ 'dashboard.materials'|trans }}
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-people\"></i> {{ 'dashboard.labor'|trans }}
                </a>
                <a class=\"nav-link\" href=\"#\">
                    <i class=\"bi bi-tools\"></i> {{ 'dashboard.equipment'|trans }}
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
