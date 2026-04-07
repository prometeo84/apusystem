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

/* profile/preferences.html.twig */
class __TwigTemplate_3276b4a30ec1214661df9563b7ec82cc extends Template
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

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "profile/preferences.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "profile/preferences.html.twig"));

        $this->parent = $this->load("base.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.title"), "html", null, true);
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 6
        yield "<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-md-3\">
            ";
        // line 9
        yield from $this->load("partials/_sidebar.html.twig", 9)->unwrap()->yield($context);
        // line 10
        yield "        </div>

        <div class=\"col-md-9\">
            <div class=\"d-flex justify-content-between align-items-center mb-4\">
                <h1 class=\"h3\">";
        // line 14
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.title"), "html", null, true);
        yield "</h1>
                <a href=\"";
        // line 15
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_profile");
        yield "\" class=\"btn btn-secondary\">
                    <i class=\"fas fa-arrow-left\"></i> ";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("buttons.cancel"), "html", null, true);
        yield "
                </a>
            </div>

            ";
        // line 20
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 20, $this->source); })()), "flashes", [], "any", false, false, false, 20));
        foreach ($context['_seq'] as $context["label"] => $context["messages"]) {
            // line 21
            yield "                ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable($context["messages"]);
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 22
                yield "                    <div class=\"alert alert-";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["label"], "html", null, true);
                yield " alert-dismissible fade show\" role=\"alert\">
                        ";
                // line 23
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
                yield "
                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                    </div>
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 27
            yield "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['label'], $context['messages'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 28
        yield "
            <div class=\"row\">
                <!-- Idioma y Zona Horaria -->
                <div class=\"col-lg-6 mb-4\">
                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">
                                <i class=\"fas fa-globe\"></i> ";
        // line 35
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.language"), "html", null, true);
        yield " & ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.timezone"), "html", null, true);
        yield "
                            </h5>

                            <form method=\"post\" action=\"";
        // line 38
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_profile_preferences");
        yield "\">
                                <div class=\"mb-3\">
                                    <label for=\"locale\" class=\"form-label\">";
        // line 40
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.language"), "html", null, true);
        yield "</label>
                                    <select name=\"locale\" id=\"locale\" class=\"form-select\" required>
                                        <option value=\"es\" ";
        // line 42
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 42, $this->source); })()), "locale", [], "any", false, false, false, 42) == "es")) {
            yield "selected";
        }
        yield ">🇪🇸 Español</option>
                                        <option value=\"en\" ";
        // line 43
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 43, $this->source); })()), "locale", [], "any", false, false, false, 43) == "en")) {
            yield "selected";
        }
        yield ">🇺🇸 English</option>
                                    </select>
                                    <div class=\"form-text\">
                                        ";
        // line 46
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.interface_language"), "html", null, true);
        yield "
                                    </div>
                                </div>

                                <div class=\"mb-3\">
                                    <label for=\"timezone\" class=\"form-label\">";
        // line 51
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.timezone"), "html", null, true);
        yield "</label>
                                    <select name=\"timezone\" id=\"timezone\" class=\"form-select\" required>
                                        <optgroup label=\"América\">
                                            <option value=\"America/Guayaquil\" ";
        // line 54
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 54, $this->source); })()), "timezone", [], "any", false, false, false, 54) == "America/Guayaquil")) {
            yield "selected";
        }
        yield ">Ecuador (UTC-5)</option>
                                            <option value=\"America/New_York\" ";
        // line 55
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 55, $this->source); })()), "timezone", [], "any", false, false, false, 55) == "America/New_York")) {
            yield "selected";
        }
        yield ">Nueva York (UTC-5/-4)</option>
                                            <option value=\"America/Chicago\" ";
        // line 56
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 56, $this->source); })()), "timezone", [], "any", false, false, false, 56) == "America/Chicago")) {
            yield "selected";
        }
        yield ">Chicago (UTC-6/-5)</option>
                                            <option value=\"America/Los_Angeles\" ";
        // line 57
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 57, $this->source); })()), "timezone", [], "any", false, false, false, 57) == "America/Los_Angeles")) {
            yield "selected";
        }
        yield ">Los Ángeles (UTC-8/-7)</option>
                                            <option value=\"America/Mexico_City\" ";
        // line 58
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 58, $this->source); })()), "timezone", [], "any", false, false, false, 58) == "America/Mexico_City")) {
            yield "selected";
        }
        yield ">Ciudad de México (UTC-6)</option>
                                            <option value=\"America/Bogota\" ";
        // line 59
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 59, $this->source); })()), "timezone", [], "any", false, false, false, 59) == "America/Bogota")) {
            yield "selected";
        }
        yield ">Bogotá (UTC-5)</option>
                                            <option value=\"America/Lima\" ";
        // line 60
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 60, $this->source); })()), "timezone", [], "any", false, false, false, 60) == "America/Lima")) {
            yield "selected";
        }
        yield ">Lima (UTC-5)</option>
                                            <option value=\"America/Santiago\" ";
        // line 61
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 61, $this->source); })()), "timezone", [], "any", false, false, false, 61) == "America/Santiago")) {
            yield "selected";
        }
        yield ">Santiago (UTC-4/-3)</option>
                                            <option value=\"America/Buenos_Aires\" ";
        // line 62
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 62, $this->source); })()), "timezone", [], "any", false, false, false, 62) == "America/Buenos_Aires")) {
            yield "selected";
        }
        yield ">Buenos Aires (UTC-3)</option>
                                        </optgroup>
                                        <optgroup label=\"Europa\">
                                            <option value=\"Europe/London\" ";
        // line 65
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 65, $this->source); })()), "timezone", [], "any", false, false, false, 65) == "Europe/London")) {
            yield "selected";
        }
        yield ">Londres (UTC+0/+1)</option>
                                            <option value=\"Europe/Paris\" ";
        // line 66
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 66, $this->source); })()), "timezone", [], "any", false, false, false, 66) == "Europe/Paris")) {
            yield "selected";
        }
        yield ">París (UTC+1/+2)</option>
                                            <option value=\"Europe/Madrid\" ";
        // line 67
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 67, $this->source); })()), "timezone", [], "any", false, false, false, 67) == "Europe/Madrid")) {
            yield "selected";
        }
        yield ">Madrid (UTC+1/+2)</option>
                                            <option value=\"Europe/Berlin\" ";
        // line 68
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 68, $this->source); })()), "timezone", [], "any", false, false, false, 68) == "Europe/Berlin")) {
            yield "selected";
        }
        yield ">Berlín (UTC+1/+2)</option>
                                        </optgroup>
                                        <optgroup label=\"Asia\">
                                            <option value=\"Asia/Dubai\" ";
        // line 71
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 71, $this->source); })()), "timezone", [], "any", false, false, false, 71) == "Asia/Dubai")) {
            yield "selected";
        }
        yield ">Dubái (UTC+4)</option>
                                            <option value=\"Asia/Shanghai\" ";
        // line 72
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 72, $this->source); })()), "timezone", [], "any", false, false, false, 72) == "Asia/Shanghai")) {
            yield "selected";
        }
        yield ">Shanghai (UTC+8)</option>
                                            <option value=\"Asia/Tokyo\" ";
        // line 73
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 73, $this->source); })()), "timezone", [], "any", false, false, false, 73) == "Asia/Tokyo")) {
            yield "selected";
        }
        yield ">Tokio (UTC+9)</option>
                                        </optgroup>
                                    </select>
                                    <div class=\"form-text\">
                                        ";
        // line 77
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.timezone_description"), "html", null, true);
        yield "
                                    </div>
                                </div>

                                <input type=\"hidden\" name=\"theme_primary_color\" value=\"";
        // line 81
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 81, $this->source); })()), "themePrimaryColor", [], "any", false, false, false, 81), "html", null, true);
        yield "\">
                                <input type=\"hidden\" name=\"theme_secondary_color\" value=\"";
        // line 82
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 82, $this->source); })()), "themeSecondaryColor", [], "any", false, false, false, 82), "html", null, true);
        yield "\">
                                <input type=\"hidden\" name=\"theme_mode\" value=\"";
        // line 83
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 83, $this->source); })()), "themeMode", [], "any", false, false, false, 83), "html", null, true);
        yield "\">

                                <button type=\"submit\" class=\"btn btn-primary\">
                                    <i class=\"fas fa-save\"></i> ";
        // line 86
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("buttons.save"), "html", null, true);
        yield "
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Personalización de Tema -->
                <div class=\"col-lg-6 mb-4\">
                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">
                                <i class=\"fas fa-palette\"></i> ";
        // line 98
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.theme"), "html", null, true);
        yield "
                            </h5>

                            <form method=\"post\" action=\"";
        // line 101
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_profile_preferences");
        yield "\" id=\"themeForm\">
                                <div class=\"mb-3\">
                                    <label for=\"theme_primary_color\" class=\"form-label\">";
        // line 103
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.primary_color"), "html", null, true);
        yield "</label>
                                    <div class=\"input-group\">
                                        <input type=\"color\" name=\"theme_primary_color\" id=\"theme_primary_color\"
                                               class=\"form-control form-control-color\"
                                               value=\"";
        // line 107
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 107, $this->source); })()), "themePrimaryColor", [], "any", false, false, false, 107), "html", null, true);
        yield "\"
                                               title=\"Seleccionar color primario\">
                                        <input type=\"text\" class=\"form-control\" id=\"primaryColorHex\"
                                               value=\"";
        // line 110
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 110, $this->source); })()), "themePrimaryColor", [], "any", false, false, false, 110), "html", null, true);
        yield "\" readonly>
                                    </div>
                                    <div class=\"form-text\">
                                        ";
        // line 113
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.primary_color_description"), "html", null, true);
        yield "
                                    </div>
                                </div>

                                <div class=\"mb-3\">
                                    <label for=\"theme_secondary_color\" class=\"form-label\">";
        // line 118
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.secondary_color"), "html", null, true);
        yield "</label>
                                    <div class=\"input-group\">
                                        <input type=\"color\" name=\"theme_secondary_color\" id=\"theme_secondary_color\"
                                               class=\"form-control form-control-color\"
                                               value=\"";
        // line 122
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 122, $this->source); })()), "themeSecondaryColor", [], "any", false, false, false, 122), "html", null, true);
        yield "\"
                                               title=\"";
        // line 123
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.select_secondary"), "html", null, true);
        yield "\">
                                        <input type=\"text\" class=\"form-control\" id=\"secondaryColorHex\"
                                               value=\"";
        // line 125
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 125, $this->source); })()), "themeSecondaryColor", [], "any", false, false, false, 125), "html", null, true);
        yield "\" readonly>
                                    </div>
                                    <div class=\"form-text\">
                                        ";
        // line 128
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.secondary_color_description"), "html", null, true);
        yield "
                                    </div>
                                </div>

                                <div class=\"mb-3\">
                                    <label for=\"theme_mode\" class=\"form-label\">";
        // line 133
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.theme_mode"), "html", null, true);
        yield "</label>
                                    <select name=\"theme_mode\" id=\"theme_mode\" class=\"form-select\">
                                        <option value=\"light\" ";
        // line 135
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 135, $this->source); })()), "themeMode", [], "any", false, false, false, 135) == "light")) {
            yield "selected";
        }
        yield ">
                                            <i class=\"fas fa-sun\"></i> ";
        // line 136
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.light"), "html", null, true);
        yield "
                                        </option>
                                        <option value=\"dark\" ";
        // line 138
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 138, $this->source); })()), "themeMode", [], "any", false, false, false, 138) == "dark")) {
            yield "selected";
        }
        yield ">
                                            <i class=\"fas fa-moon\"></i> ";
        // line 139
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.dark"), "html", null, true);
        yield "
                                        </option>
                                        <option value=\"auto\" ";
        // line 141
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 141, $this->source); })()), "themeMode", [], "any", false, false, false, 141) == "auto")) {
            yield "selected";
        }
        yield ">
                                            <i class=\"fas fa-adjust\"></i> ";
        // line 142
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.auto"), "html", null, true);
        yield "
                                        </option>
                                    </select>
                                </div>

                                <div class=\"d-flex gap-2\">
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"fas fa-save\"></i> ";
        // line 149
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("buttons.save"), "html", null, true);
        yield "
                                    </button>

                                    <button type=\"button\" class=\"btn btn-secondary\" onclick=\"resetTheme()\">
                                        <i class=\"fas fa-undo\"></i> ";
        // line 153
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.reset_colors"), "html", null, true);
        yield "
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Vista Previa -->
                    <div class=\"card mt-3\">
                        <div class=\"card-body\">
                            <h6 class=\"card-title\">";
        // line 163
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.preview"), "html", null, true);
        yield "</h6>
                            <div id=\"preview\" class=\"p-3 rounded\">
                                <button class=\"btn btn-sm mb-2\" id=\"previewBtn\" style=\"background: linear-gradient(135deg, ";
        // line 165
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 165, $this->source); })()), "themePrimaryColor", [], "any", false, false, false, 165), "html", null, true);
        yield " 0%, ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 165, $this->source); })()), "themeSecondaryColor", [], "any", false, false, false, 165), "html", null, true);
        yield " 100%); color: white;\">
                                    ";
        // line 166
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.example_button"), "html", null, true);
        yield "
                                </button>
                                <div class=\"alert mb-0\" style=\"background-color: ";
        // line 168
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 168, $this->source); })()), "themePrimaryColor", [], "any", false, false, false, 168), "html", null, true);
        yield "22; border-color: ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 168, $this->source); })()), "themePrimaryColor", [], "any", false, false, false, 168), "html", null, true);
        yield "; color: ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 168, $this->source); })()), "themePrimaryColor", [], "any", false, false, false, 168), "html", null, true);
        yield ";\">
                                    <strong>";
        // line 169
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.example_text"), "html", null, true);
        yield "</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Actual -->
            <div class=\"card\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\"><i class=\"fas fa-info-circle\"></i> ";
        // line 180
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.current_config"), "html", null, true);
        yield "</h5>
                    <div class=\"row\">
                        <div class=\"col-md-4\">
                            <strong>";
        // line 183
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.language"), "html", null, true);
        yield ":</strong><br>
                            ";
        // line 184
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 184, $this->source); })()), "locale", [], "any", false, false, false, 184) == "es")) {
            yield "🇪🇸 Español";
        } else {
            yield "🇺🇸 English";
        }
        // line 185
        yield "                        </div>
                        <div class=\"col-md-4\">
                            <strong>";
        // line 187
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("preferences.timezone"), "html", null, true);
        yield ":</strong><br>
                            ";
        // line 188
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 188, $this->source); })()), "timezone", [], "any", false, false, false, 188), "html", null, true);
        yield "
                        </div>
                        <div class=\"col-md-4\">
                            <strong>";
        // line 191
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.current_time"), "html", null, true);
        yield ":</strong><br>
                            <span id=\"currentTime\"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Actualizar preview de colores en tiempo real
document.getElementById('theme_primary_color').addEventListener('input', function(e) {
    const primary = e.target.value;
    document.getElementById('primaryColorHex').value = primary;
    updatePreview(primary, document.getElementById('theme_secondary_color').value);
});

document.getElementById('theme_secondary_color').addEventListener('input', function(e) {
    const secondary = e.target.value;
    document.getElementById('secondaryColorHex').value = secondary;
    updatePreview(document.getElementById('theme_primary_color').value, secondary);
});

function updatePreview(primary, secondary) {
    const btn = document.getElementById('previewBtn');
    btn.style.background = `linear-gradient(135deg, \${primary} 0%, \${secondary} 100%)`;

    const alert = document.querySelector('#preview .alert');
    alert.style.backgroundColor = primary + '22';
    alert.style.borderColor = primary;
    alert.style.color = primary;
}

function resetTheme() {
    if (confirm('";
        // line 226
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.reset_theme_confirm"), "html", null, true);
        yield "')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '";
        // line 229
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_profile_reset_theme");
        yield "';
        document.body.appendChild(form);
        form.submit();
    }
}

// Actualizar hora actual cada segundo
function updateCurrentTime() {
    const now = new Date();
    document.getElementById('currentTime').textContent = now.toLocaleString('";
        // line 238
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 238, $this->source); })()), "locale", [], "any", false, false, false, 238), "html", null, true);
        yield "', {
        timeZone: '";
        // line 239
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 239, $this->source); })()), "timezone", [], "any", false, false, false, 239), "html", null, true);
        yield "',
        dateStyle: 'short',
        timeStyle: 'medium'
    });
}

updateCurrentTime();
setInterval(updateCurrentTime, 1000);
</script>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "profile/preferences.html.twig";
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
        return array (  611 => 239,  607 => 238,  595 => 229,  589 => 226,  551 => 191,  545 => 188,  541 => 187,  537 => 185,  531 => 184,  527 => 183,  521 => 180,  507 => 169,  499 => 168,  494 => 166,  488 => 165,  483 => 163,  470 => 153,  463 => 149,  453 => 142,  447 => 141,  442 => 139,  436 => 138,  431 => 136,  425 => 135,  420 => 133,  412 => 128,  406 => 125,  401 => 123,  397 => 122,  390 => 118,  382 => 113,  376 => 110,  370 => 107,  363 => 103,  358 => 101,  352 => 98,  337 => 86,  331 => 83,  327 => 82,  323 => 81,  316 => 77,  307 => 73,  301 => 72,  295 => 71,  287 => 68,  281 => 67,  275 => 66,  269 => 65,  261 => 62,  255 => 61,  249 => 60,  243 => 59,  237 => 58,  231 => 57,  225 => 56,  219 => 55,  213 => 54,  207 => 51,  199 => 46,  191 => 43,  185 => 42,  180 => 40,  175 => 38,  167 => 35,  158 => 28,  152 => 27,  142 => 23,  137 => 22,  132 => 21,  128 => 20,  121 => 16,  117 => 15,  113 => 14,  107 => 10,  105 => 9,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}{{ 'preferences.title'|trans }}{% endblock %}

{% block body %}
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-md-3\">
            {% include 'partials/_sidebar.html.twig' %}
        </div>

        <div class=\"col-md-9\">
            <div class=\"d-flex justify-content-between align-items-center mb-4\">
                <h1 class=\"h3\">{{ 'preferences.title'|trans }}</h1>
                <a href=\"{{ path('app_profile') }}\" class=\"btn btn-secondary\">
                    <i class=\"fas fa-arrow-left\"></i> {{ 'buttons.cancel'|trans }}
                </a>
            </div>

            {% for label, messages in app.flashes %}
                {% for message in messages %}
                    <div class=\"alert alert-{{ label }} alert-dismissible fade show\" role=\"alert\">
                        {{ message }}
                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                    </div>
                {% endfor %}
            {% endfor %}

            <div class=\"row\">
                <!-- Idioma y Zona Horaria -->
                <div class=\"col-lg-6 mb-4\">
                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">
                                <i class=\"fas fa-globe\"></i> {{ 'preferences.language'|trans }} & {{ 'preferences.timezone'|trans }}
                            </h5>

                            <form method=\"post\" action=\"{{ path('app_profile_preferences') }}\">
                                <div class=\"mb-3\">
                                    <label for=\"locale\" class=\"form-label\">{{ 'preferences.language'|trans }}</label>
                                    <select name=\"locale\" id=\"locale\" class=\"form-select\" required>
                                        <option value=\"es\" {% if user.locale == 'es' %}selected{% endif %}>🇪🇸 Español</option>
                                        <option value=\"en\" {% if user.locale == 'en' %}selected{% endif %}>🇺🇸 English</option>
                                    </select>
                                    <div class=\"form-text\">
                                        {{ 'common.interface_language'|trans }}
                                    </div>
                                </div>

                                <div class=\"mb-3\">
                                    <label for=\"timezone\" class=\"form-label\">{{ 'preferences.timezone'|trans }}</label>
                                    <select name=\"timezone\" id=\"timezone\" class=\"form-select\" required>
                                        <optgroup label=\"América\">
                                            <option value=\"America/Guayaquil\" {% if user.timezone == 'America/Guayaquil' %}selected{% endif %}>Ecuador (UTC-5)</option>
                                            <option value=\"America/New_York\" {% if user.timezone == 'America/New_York' %}selected{% endif %}>Nueva York (UTC-5/-4)</option>
                                            <option value=\"America/Chicago\" {% if user.timezone == 'America/Chicago' %}selected{% endif %}>Chicago (UTC-6/-5)</option>
                                            <option value=\"America/Los_Angeles\" {% if user.timezone == 'America/Los_Angeles' %}selected{% endif %}>Los Ángeles (UTC-8/-7)</option>
                                            <option value=\"America/Mexico_City\" {% if user.timezone == 'America/Mexico_City' %}selected{% endif %}>Ciudad de México (UTC-6)</option>
                                            <option value=\"America/Bogota\" {% if user.timezone == 'America/Bogota' %}selected{% endif %}>Bogotá (UTC-5)</option>
                                            <option value=\"America/Lima\" {% if user.timezone == 'America/Lima' %}selected{% endif %}>Lima (UTC-5)</option>
                                            <option value=\"America/Santiago\" {% if user.timezone == 'America/Santiago' %}selected{% endif %}>Santiago (UTC-4/-3)</option>
                                            <option value=\"America/Buenos_Aires\" {% if user.timezone == 'America/Buenos_Aires' %}selected{% endif %}>Buenos Aires (UTC-3)</option>
                                        </optgroup>
                                        <optgroup label=\"Europa\">
                                            <option value=\"Europe/London\" {% if user.timezone == 'Europe/London' %}selected{% endif %}>Londres (UTC+0/+1)</option>
                                            <option value=\"Europe/Paris\" {% if user.timezone == 'Europe/Paris' %}selected{% endif %}>París (UTC+1/+2)</option>
                                            <option value=\"Europe/Madrid\" {% if user.timezone == 'Europe/Madrid' %}selected{% endif %}>Madrid (UTC+1/+2)</option>
                                            <option value=\"Europe/Berlin\" {% if user.timezone == 'Europe/Berlin' %}selected{% endif %}>Berlín (UTC+1/+2)</option>
                                        </optgroup>
                                        <optgroup label=\"Asia\">
                                            <option value=\"Asia/Dubai\" {% if user.timezone == 'Asia/Dubai' %}selected{% endif %}>Dubái (UTC+4)</option>
                                            <option value=\"Asia/Shanghai\" {% if user.timezone == 'Asia/Shanghai' %}selected{% endif %}>Shanghai (UTC+8)</option>
                                            <option value=\"Asia/Tokyo\" {% if user.timezone == 'Asia/Tokyo' %}selected{% endif %}>Tokio (UTC+9)</option>
                                        </optgroup>
                                    </select>
                                    <div class=\"form-text\">
                                        {{ 'common.timezone_description'|trans }}
                                    </div>
                                </div>

                                <input type=\"hidden\" name=\"theme_primary_color\" value=\"{{ user.themePrimaryColor }}\">
                                <input type=\"hidden\" name=\"theme_secondary_color\" value=\"{{ user.themeSecondaryColor }}\">
                                <input type=\"hidden\" name=\"theme_mode\" value=\"{{ user.themeMode }}\">

                                <button type=\"submit\" class=\"btn btn-primary\">
                                    <i class=\"fas fa-save\"></i> {{ 'buttons.save'|trans }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Personalización de Tema -->
                <div class=\"col-lg-6 mb-4\">
                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">
                                <i class=\"fas fa-palette\"></i> {{ 'preferences.theme'|trans }}
                            </h5>

                            <form method=\"post\" action=\"{{ path('app_profile_preferences') }}\" id=\"themeForm\">
                                <div class=\"mb-3\">
                                    <label for=\"theme_primary_color\" class=\"form-label\">{{ 'preferences.primary_color'|trans }}</label>
                                    <div class=\"input-group\">
                                        <input type=\"color\" name=\"theme_primary_color\" id=\"theme_primary_color\"
                                               class=\"form-control form-control-color\"
                                               value=\"{{ user.themePrimaryColor }}\"
                                               title=\"Seleccionar color primario\">
                                        <input type=\"text\" class=\"form-control\" id=\"primaryColorHex\"
                                               value=\"{{ user.themePrimaryColor }}\" readonly>
                                    </div>
                                    <div class=\"form-text\">
                                        {{ 'common.primary_color_description'|trans }}
                                    </div>
                                </div>

                                <div class=\"mb-3\">
                                    <label for=\"theme_secondary_color\" class=\"form-label\">{{ 'preferences.secondary_color'|trans }}</label>
                                    <div class=\"input-group\">
                                        <input type=\"color\" name=\"theme_secondary_color\" id=\"theme_secondary_color\"
                                               class=\"form-control form-control-color\"
                                               value=\"{{ user.themeSecondaryColor }}\"
                                               title=\"{{ 'common.select_secondary'|trans }}\">
                                        <input type=\"text\" class=\"form-control\" id=\"secondaryColorHex\"
                                               value=\"{{ user.themeSecondaryColor }}\" readonly>
                                    </div>
                                    <div class=\"form-text\">
                                        {{ 'common.secondary_color_description'|trans }}
                                    </div>
                                </div>

                                <div class=\"mb-3\">
                                    <label for=\"theme_mode\" class=\"form-label\">{{ 'preferences.theme_mode'|trans }}</label>
                                    <select name=\"theme_mode\" id=\"theme_mode\" class=\"form-select\">
                                        <option value=\"light\" {% if user.themeMode == 'light' %}selected{% endif %}>
                                            <i class=\"fas fa-sun\"></i> {{ 'preferences.light'|trans }}
                                        </option>
                                        <option value=\"dark\" {% if user.themeMode == 'dark' %}selected{% endif %}>
                                            <i class=\"fas fa-moon\"></i> {{ 'preferences.dark'|trans }}
                                        </option>
                                        <option value=\"auto\" {% if user.themeMode == 'auto' %}selected{% endif %}>
                                            <i class=\"fas fa-adjust\"></i> {{ 'preferences.auto'|trans }}
                                        </option>
                                    </select>
                                </div>

                                <div class=\"d-flex gap-2\">
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"fas fa-save\"></i> {{ 'buttons.save'|trans }}
                                    </button>

                                    <button type=\"button\" class=\"btn btn-secondary\" onclick=\"resetTheme()\">
                                        <i class=\"fas fa-undo\"></i> {{ 'preferences.reset_colors'|trans }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Vista Previa -->
                    <div class=\"card mt-3\">
                        <div class=\"card-body\">
                            <h6 class=\"card-title\">{{ 'common.preview'|trans }}</h6>
                            <div id=\"preview\" class=\"p-3 rounded\">
                                <button class=\"btn btn-sm mb-2\" id=\"previewBtn\" style=\"background: linear-gradient(135deg, {{ user.themePrimaryColor }} 0%, {{ user.themeSecondaryColor }} 100%); color: white;\">
                                    {{ 'common.example_button'|trans }}
                                </button>
                                <div class=\"alert mb-0\" style=\"background-color: {{ user.themePrimaryColor }}22; border-color: {{ user.themePrimaryColor }}; color: {{ user.themePrimaryColor }};\">
                                    <strong>{{ 'common.example_text'|trans }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Actual -->
            <div class=\"card\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\"><i class=\"fas fa-info-circle\"></i> {{ 'common.current_config'|trans }}</h5>
                    <div class=\"row\">
                        <div class=\"col-md-4\">
                            <strong>{{ 'preferences.language'|trans }}:</strong><br>
                            {% if user.locale == 'es' %}🇪🇸 Español{% else %}🇺🇸 English{% endif %}
                        </div>
                        <div class=\"col-md-4\">
                            <strong>{{ 'preferences.timezone'|trans }}:</strong><br>
                            {{ user.timezone }}
                        </div>
                        <div class=\"col-md-4\">
                            <strong>{{ 'common.current_time'|trans }}:</strong><br>
                            <span id=\"currentTime\"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Actualizar preview de colores en tiempo real
document.getElementById('theme_primary_color').addEventListener('input', function(e) {
    const primary = e.target.value;
    document.getElementById('primaryColorHex').value = primary;
    updatePreview(primary, document.getElementById('theme_secondary_color').value);
});

document.getElementById('theme_secondary_color').addEventListener('input', function(e) {
    const secondary = e.target.value;
    document.getElementById('secondaryColorHex').value = secondary;
    updatePreview(document.getElementById('theme_primary_color').value, secondary);
});

function updatePreview(primary, secondary) {
    const btn = document.getElementById('previewBtn');
    btn.style.background = `linear-gradient(135deg, \${primary} 0%, \${secondary} 100%)`;

    const alert = document.querySelector('#preview .alert');
    alert.style.backgroundColor = primary + '22';
    alert.style.borderColor = primary;
    alert.style.color = primary;
}

function resetTheme() {
    if (confirm('{{ 'common.reset_theme_confirm'|trans }}')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ path('app_profile_reset_theme') }}';
        document.body.appendChild(form);
        form.submit();
    }
}

// Actualizar hora actual cada segundo
function updateCurrentTime() {
    const now = new Date();
    document.getElementById('currentTime').textContent = now.toLocaleString('{{ user.locale }}', {
        timeZone: '{{ user.timezone }}',
        dateStyle: 'short',
        timeStyle: 'medium'
    });
}

updateCurrentTime();
setInterval(updateCurrentTime, 1000);
</script>
{% endblock %}
", "profile/preferences.html.twig", "/var/www/html/proyecto/templates/profile/preferences.html.twig");
    }
}
