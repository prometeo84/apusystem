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

/* profile/edit.html.twig */
class __TwigTemplate_ad1d03a7bde46e9e590c6e2aed9e5068 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "profile/edit.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "profile/edit.html.twig"));

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

        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("profile.edit_title"), "html", null, true);
        yield " - APU System";
        
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
        yield "<div class=\"d-flex\">
    ";
        // line 7
        yield from $this->load("partials/_sidebar.html.twig", 7)->unwrap()->yield($context);
        // line 8
        yield "
    <div class=\"flex-grow-1\">
        ";
        // line 10
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("profile.edit_title")]));
        // line 11
        yield "
        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"row justify-content-center\">
                <div class=\"col-md-8\">
                    <div class=\"card\">
                        <div class=\"card-body p-4\">
                            <h4 class=\"card-title mb-4\">
                                <i class=\"bi bi-pencil-square\"></i> ";
        // line 18
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.edit_personal_info"), "html", null, true);
        yield "
                            </h4>

                            <form method=\"post\" enctype=\"multipart/form-data\">
                                ";
        // line 23
        yield "                                <div class=\"mb-4 text-center\">
                                    <label class=\"form-label d-block\">";
        // line 24
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.image_profile"), "html", null, true);
        yield "</label>
                                    <div class=\"mb-3\">
                                        ";
        // line 26
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 26, $this->source); })()), "avatar", [], "any", false, false, false, 26)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 27
            yield "                                            <img src=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 27, $this->source); })()), "avatar", [], "any", false, false, false, 27), "html", null, true);
            yield "\" alt=\"Avatar\" class=\"rounded-circle\" style=\"width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--primary-color);\">
                                        ";
        } else {
            // line 29
            yield "                                            <div class=\"rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center\" style=\"width: 120px; height: 120px; font-size: 48px;\">
                                                ";
            // line 30
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::first($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 30, $this->source); })()), "firstName", [], "any", false, false, false, 30)), "html", null, true);
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::first($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 30, $this->source); })()), "lastName", [], "any", false, false, false, 30)), "html", null, true);
            yield "
                                            </div>
                                        ";
        }
        // line 33
        yield "                                    </div>
                                    <input type=\"file\" class=\"form-control\" id=\"avatar\" name=\"avatar\" accept=\"image/jpeg,image/png,image/gif,image/webp\">
                                    <small class=\"text-muted\">";
        // line 35
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.allowed_formats"), "html", null, true);
        yield ". ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.max_size"), "html", null, true);
        yield ".</small>
                                </div>

                                <div class=\"row mb-3\">
                                    <div class=\"col-md-6\">
                                        <label for=\"first_name\" class=\"form-label\">";
        // line 40
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("profile.first_name"), "html", null, true);
        yield " *</label>
                                        <input type=\"text\" class=\"form-control\" id=\"first_name\" name=\"first_name\"
                                               value=\"";
        // line 42
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 42, $this->source); })()), "firstName", [], "any", false, false, false, 42), "html", null, true);
        yield "\" required>
                                    </div>
                                    <div class=\"col-md-6\">
                                        <label for=\"last_name\" class=\"form-label\">";
        // line 45
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("profile.last_name"), "html", null, true);
        yield " *</label>
                                        <input type=\"text\" class=\"form-control\" id=\"last_name\" name=\"last_name\"
                                               value=\"";
        // line 47
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 47, $this->source); })()), "lastName", [], "any", false, false, false, 47), "html", null, true);
        yield "\" required>
                                    </div>
                                </div>

                                <div class=\"mb-3\">
                                    <label for=\"phone\" class=\"form-label\">";
        // line 52
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("profile.phone"), "html", null, true);
        yield "</label>
                                    <input type=\"tel\" class=\"form-control\" id=\"phone\" name=\"phone\"
                                           value=\"";
        // line 54
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 54, $this->source); })()), "phone", [], "any", false, false, false, 54), "html", null, true);
        yield "\">
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">";
        // line 58
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("profile.email"), "html", null, true);
        yield " (";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.not_editable"), "html", null, true);
        yield ")</label>
                                    <input type=\"text\" class=\"form-control\" value=\"";
        // line 59
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 59, $this->source); })()), "email", [], "any", false, false, false, 59), "html", null, true);
        yield "\" disabled>
                                    <small class=\"text-muted\">";
        // line 60
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.email_not_modifiable"), "html", null, true);
        yield "</small>
                                </div>

                                <div class=\"d-flex justify-content-between\">
                                    <a href=\"";
        // line 64
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_profile");
        yield "\" class=\"btn btn-outline-secondary\">
                                        <i class=\"bi bi-arrow-left\"></i> ";
        // line 65
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("buttons.cancel"), "html", null, true);
        yield "
                                    </a>
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"bi bi-check-circle\"></i> ";
        // line 68
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("profile.save"), "html", null, true);
        yield "
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
        return "profile/edit.html.twig";
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
        return array (  231 => 68,  225 => 65,  221 => 64,  214 => 60,  210 => 59,  204 => 58,  197 => 54,  192 => 52,  184 => 47,  179 => 45,  173 => 42,  168 => 40,  158 => 35,  154 => 33,  147 => 30,  144 => 29,  138 => 27,  136 => 26,  131 => 24,  128 => 23,  121 => 18,  112 => 11,  110 => 10,  106 => 8,  104 => 7,  101 => 6,  88 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}{{ 'profile.edit_title'|trans }} - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'profile.edit_title'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"row justify-content-center\">
                <div class=\"col-md-8\">
                    <div class=\"card\">
                        <div class=\"card-body p-4\">
                            <h4 class=\"card-title mb-4\">
                                <i class=\"bi bi-pencil-square\"></i> {{ 'common.edit_personal_info'|trans }}
                            </h4>

                            <form method=\"post\" enctype=\"multipart/form-data\">
                                {# Avatar / Imagen de Perfil #}
                                <div class=\"mb-4 text-center\">
                                    <label class=\"form-label d-block\">{{ 'common.image_profile'|trans }}</label>
                                    <div class=\"mb-3\">
                                        {% if user.avatar %}
                                            <img src=\"{{ user.avatar }}\" alt=\"Avatar\" class=\"rounded-circle\" style=\"width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--primary-color);\">
                                        {% else %}
                                            <div class=\"rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center\" style=\"width: 120px; height: 120px; font-size: 48px;\">
                                                {{ user.firstName|first }}{{ user.lastName|first }}
                                            </div>
                                        {% endif %}
                                    </div>
                                    <input type=\"file\" class=\"form-control\" id=\"avatar\" name=\"avatar\" accept=\"image/jpeg,image/png,image/gif,image/webp\">
                                    <small class=\"text-muted\">{{ 'common.allowed_formats'|trans }}. {{ 'common.max_size'|trans }}.</small>
                                </div>

                                <div class=\"row mb-3\">
                                    <div class=\"col-md-6\">
                                        <label for=\"first_name\" class=\"form-label\">{{ 'profile.first_name'|trans }} *</label>
                                        <input type=\"text\" class=\"form-control\" id=\"first_name\" name=\"first_name\"
                                               value=\"{{ user.firstName }}\" required>
                                    </div>
                                    <div class=\"col-md-6\">
                                        <label for=\"last_name\" class=\"form-label\">{{ 'profile.last_name'|trans }} *</label>
                                        <input type=\"text\" class=\"form-control\" id=\"last_name\" name=\"last_name\"
                                               value=\"{{ user.lastName }}\" required>
                                    </div>
                                </div>

                                <div class=\"mb-3\">
                                    <label for=\"phone\" class=\"form-label\">{{ 'profile.phone'|trans }}</label>
                                    <input type=\"tel\" class=\"form-control\" id=\"phone\" name=\"phone\"
                                           value=\"{{ user.phone }}\">
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">{{ 'profile.email'|trans }} ({{ 'common.not_editable'|trans }})</label>
                                    <input type=\"text\" class=\"form-control\" value=\"{{ user.email }}\" disabled>
                                    <small class=\"text-muted\">{{ 'common.email_not_modifiable'|trans }}</small>
                                </div>

                                <div class=\"d-flex justify-content-between\">
                                    <a href=\"{{ path('app_profile') }}\" class=\"btn btn-outline-secondary\">
                                        <i class=\"bi bi-arrow-left\"></i> {{ 'buttons.cancel'|trans }}
                                    </a>
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"bi bi-check-circle\"></i> {{ 'profile.save'|trans }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
", "profile/edit.html.twig", "/var/www/html/proyecto/templates/profile/edit.html.twig");
    }
}
