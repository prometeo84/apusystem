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

/* admin/users_create.html.twig */
class __TwigTemplate_dbc729da2be6ce9f0493cc750463d974 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/users_create.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/users_create.html.twig"));

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

        yield "Crear Usuario - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.create_user")]));
        // line 11
        yield "
        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"row justify-content-center\">
                <div class=\"col-md-8\">
                    ";
        // line 15
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 15, $this->source); })()), "flashes", ["error"], "method", false, false, false, 15));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 16
            yield "                        <div class=\"alert alert-danger alert-dismissible fade show\">
                            <i class=\"bi bi-exclamation-triangle-fill\"></i> ";
            // line 17
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "
                            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                        </div>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 21
        yield "
                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-person-plus\"></i> ";
        // line 24
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.new_user"), "html", null, true);
        yield "</h5>
                        </div>
                        <div class=\"card-body\">
                            <form method=\"post\" action=\"";
        // line 27
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin_users_create");
        yield "\">
                                <div class=\"row\">
                                    <div class=\"col-md-6 mb-3\">
                                        <label class=\"form-label\">";
        // line 30
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.first_name"), "html", null, true);
        yield "</label>
                                        <input type=\"text\" name=\"first_name\" class=\"form-control\" required>
                                    </div>
                                    <div class=\"col-md-6 mb-3\">
                                        <label class=\"form-label\">";
        // line 34
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.last_name"), "html", null, true);
        yield "</label>
                                        <input type=\"text\" name=\"last_name\" class=\"form-control\" required>
                                    </div>
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">Email</label>
                                    <input type=\"email\" name=\"email\" class=\"form-control\" required>
                                    <small class=\"text-muted\">";
        // line 42
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.email_username"), "html", null, true);
        yield "</small>
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">";
        // line 46
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.phone"), "html", null, true);
        yield "</label>
                                    <input type=\"tel\" name=\"phone\" class=\"form-control\">
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">";
        // line 51
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.new"), "html", null, true);
        yield "</label>
                                    <input type=\"password\" name=\"password\" class=\"form-control\" required minlength=\"8\">
                                    <small class=\"text-muted\">";
        // line 53
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.min_8_chars"), "html", null, true);
        yield "</small>
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">";
        // line 57
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.confirm_password"), "html", null, true);
        yield "</label>
                                    <input type=\"password\" name=\"password_confirm\" class=\"form-control\" required minlength=\"8\">
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">";
        // line 62
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.role"), "html", null, true);
        yield "</label>
                                    <select name=\"role\" class=\"form-select\" required>
                                        <option value=\"ROLE_USER\">";
        // line 64
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.user"), "html", null, true);
        yield "</option>
                                        <option value=\"ROLE_MANAGER\">Manager</option>
                                        ";
        // line 66
        if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_SUPER_ADMIN")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 67
            yield "                                            <option value=\"ROLE_ADMIN\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.admin"), "html", null, true);
            yield "</option>
                                            <option value=\"ROLE_SUPER_ADMIN\">";
            // line 68
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.super_admin"), "html", null, true);
            yield "</option>
                                        ";
        }
        // line 70
        yield "                                    </select>
                                </div>

                                <div class=\"form-check mb-3\">
                                    <input type=\"checkbox\" name=\"is_active\" class=\"form-check-input\" id=\"isActive\" checked>
                                    <label class=\"form-check-label\" for=\"isActive\">
                                        ";
        // line 76
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.user_active"), "html", null, true);
        yield "
                                    </label>
                                </div>

                                <div class=\"alert alert-info\">
                                    <i class=\"bi bi-info-circle\"></i>
                                    ";
        // line 82
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.email_notification"), "html", null, true);
        yield "
                                </div>

                                <div class=\"d-flex gap-2\">
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"bi bi-save\"></i> ";
        // line 87
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.create_user"), "html", null, true);
        yield "
                                    </button>
                                    <a href=\"";
        // line 89
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin_users");
        yield "\" class=\"btn btn-outline-secondary\">
                                        <i class=\"bi bi-x-circle\"></i> ";
        // line 90
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("buttons.cancel"), "html", null, true);
        yield "
                                    </a>
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
        return "admin/users_create.html.twig";
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
        return array (  260 => 90,  256 => 89,  251 => 87,  243 => 82,  234 => 76,  226 => 70,  221 => 68,  216 => 67,  214 => 66,  209 => 64,  204 => 62,  196 => 57,  189 => 53,  184 => 51,  176 => 46,  169 => 42,  158 => 34,  151 => 30,  145 => 27,  139 => 24,  134 => 21,  124 => 17,  121 => 16,  117 => 15,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Crear Usuario - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'admin.create_user'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"row justify-content-center\">
                <div class=\"col-md-8\">
                    {% for message in app.flashes('error') %}
                        <div class=\"alert alert-danger alert-dismissible fade show\">
                            <i class=\"bi bi-exclamation-triangle-fill\"></i> {{ message }}
                            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                        </div>
                    {% endfor %}

                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-person-plus\"></i> {{ 'admin.new_user'|trans }}</h5>
                        </div>
                        <div class=\"card-body\">
                            <form method=\"post\" action=\"{{ path('app_admin_users_create') }}\">
                                <div class=\"row\">
                                    <div class=\"col-md-6 mb-3\">
                                        <label class=\"form-label\">{{ 'admin.first_name'|trans }}</label>
                                        <input type=\"text\" name=\"first_name\" class=\"form-control\" required>
                                    </div>
                                    <div class=\"col-md-6 mb-3\">
                                        <label class=\"form-label\">{{ 'admin.last_name'|trans }}</label>
                                        <input type=\"text\" name=\"last_name\" class=\"form-control\" required>
                                    </div>
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">Email</label>
                                    <input type=\"email\" name=\"email\" class=\"form-control\" required>
                                    <small class=\"text-muted\">{{ 'admin.email_username'|trans }}</small>
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">{{ 'admin.phone'|trans }}</label>
                                    <input type=\"tel\" name=\"phone\" class=\"form-control\">
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">{{ 'password.new'|trans }}</label>
                                    <input type=\"password\" name=\"password\" class=\"form-control\" required minlength=\"8\">
                                    <small class=\"text-muted\">{{ 'admin.min_8_chars'|trans }}</small>
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">{{ 'admin.confirm_password'|trans }}</label>
                                    <input type=\"password\" name=\"password_confirm\" class=\"form-control\" required minlength=\"8\">
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">{{ 'admin.role'|trans }}</label>
                                    <select name=\"role\" class=\"form-select\" required>
                                        <option value=\"ROLE_USER\">{{ 'admin.user'|trans }}</option>
                                        <option value=\"ROLE_MANAGER\">Manager</option>
                                        {% if is_granted('ROLE_SUPER_ADMIN') %}
                                            <option value=\"ROLE_ADMIN\">{{ 'admin.admin'|trans }}</option>
                                            <option value=\"ROLE_SUPER_ADMIN\">{{ 'admin.super_admin'|trans }}</option>
                                        {% endif %}
                                    </select>
                                </div>

                                <div class=\"form-check mb-3\">
                                    <input type=\"checkbox\" name=\"is_active\" class=\"form-check-input\" id=\"isActive\" checked>
                                    <label class=\"form-check-label\" for=\"isActive\">
                                        {{ 'admin.user_active'|trans }}
                                    </label>
                                </div>

                                <div class=\"alert alert-info\">
                                    <i class=\"bi bi-info-circle\"></i>
                                    {{ 'admin.email_notification'|trans }}
                                </div>

                                <div class=\"d-flex gap-2\">
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"bi bi-save\"></i> {{ 'admin.create_user'|trans }}
                                    </button>
                                    <a href=\"{{ path('app_admin_users') }}\" class=\"btn btn-outline-secondary\">
                                        <i class=\"bi bi-x-circle\"></i> {{ 'buttons.cancel'|trans }}
                                    </a>
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
", "admin/users_create.html.twig", "/var/www/html/proyecto/templates/admin/users_create.html.twig");
    }
}
