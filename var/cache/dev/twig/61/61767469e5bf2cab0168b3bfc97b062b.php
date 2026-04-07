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

/* system/tenants_edit.html.twig */
class __TwigTemplate_0a6639c14b328d68b3b9229fe91d671a extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "system/tenants_edit.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "system/tenants_edit.html.twig"));

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

        yield "Editar Empresa - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system_tenants.edit_tenant_form")]));
        // line 11
        yield "
        <div class=\"container-fluid p-4 content-wrapper\">

            ";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 14, $this->source); })()), "flashes", [], "any", false, false, false, 14));
        foreach ($context['_seq'] as $context["label"] => $context["messages"]) {
            // line 15
            yield "                ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable($context["messages"]);
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 16
                yield "                    <div class=\"alert alert-";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["label"], "html", null, true);
                yield " alert-dismissible fade show\" role=\"alert\">
                        ";
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
            yield "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['label'], $context['messages'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 22
        yield "
            <div class=\"row justify-content-center\">
                <div class=\"col-lg-8\">
                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-building\"></i> ";
        // line 27
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.edit"), "html", null, true);
        yield ": ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 27, $this->source); })()), "name", [], "any", false, false, false, 27), "html", null, true);
        yield "</h5>
                        </div>
                        <div class=\"card-body\">
                            <form method=\"post\" action=\"";
        // line 30
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_tenants_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 30, $this->source); })()), "id", [], "any", false, false, false, 30)]), "html", null, true);
        yield "\">
                                <div class=\"row\">
                                    <div class=\"col-md-6 mb-3\">
                                        <label for=\"name\" class=\"form-label\">Nombre de la Empresa *</label>
                                        <input type=\"text\" class=\"form-control\" id=\"name\" name=\"name\" value=\"";
        // line 34
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 34, $this->source); })()), "name", [], "any", false, false, false, 34), "html", null, true);
        yield "\" required>
                                    </div>

                                    <div class=\"col-md-6 mb-3\">
                                        <label for=\"slug\" class=\"form-label\">";
        // line 38
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.company_code"), "html", null, true);
        yield "</label>
                                        <input type=\"text\" class=\"form-control\" id=\"slug\" value=\"";
        // line 39
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 39, $this->source); })()), "slug", [], "any", false, false, false, 39), "html", null, true);
        yield "\" disabled>
                                        <div class=\"form-text\">";
        // line 40
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.company_code_no_change"), "html", null, true);
        yield "</div>
                                    </div>
                                </div>

                                <div class=\"row\">
                                    <div class=\"col-md-4 mb-3\">
                                        <label for=\"plan\" class=\"form-label\">Plan *</label>
                                        <select class=\"form-select\" id=\"plan\" name=\"plan\" required>
                                            <option value=\"basic\" ";
        // line 48
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 48, $this->source); })()), "plan", [], "any", false, false, false, 48) == "basic")) {
            yield "selected";
        }
        yield ">Basic</option>
                                            <option value=\"professional\" ";
        // line 49
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 49, $this->source); })()), "plan", [], "any", false, false, false, 49) == "professional")) {
            yield "selected";
        }
        yield ">Professional</option>
                                            <option value=\"enterprise\" ";
        // line 50
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 50, $this->source); })()), "plan", [], "any", false, false, false, 50) == "enterprise")) {
            yield "selected";
        }
        yield ">Enterprise</option>
                                        </select>
                                    </div>

                                    <div class=\"col-md-4 mb-3\">
                                        <label for=\"max_users\" class=\"form-label\">Máximo de Usuarios</label>
                                        <input type=\"number\" class=\"form-control\" id=\"max_users\" name=\"max_users\" value=\"";
        // line 56
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 56, $this->source); })()), "maxUsers", [], "any", false, false, false, 56), "html", null, true);
        yield "\" min=\"1\" max=\"1000\">
                                    </div>

                                    <div class=\"col-md-4 mb-3\">
                                        <label for=\"max_projects\" class=\"form-label\">Máximo de Proyectos</label>
                                        <input type=\"number\" class=\"form-control\" id=\"max_projects\" name=\"max_projects\" value=\"";
        // line 61
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 61, $this->source); })()), "maxProjects", [], "any", false, false, false, 61), "html", null, true);
        yield "\" min=\"1\" max=\"10000\">
                                    </div>
                                </div>

                                <div class=\"row\">
                                    <div class=\"col-md-6 mb-3\">
                                        <label for=\"plan_months\" class=\"form-label\">";
        // line 67
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.extend_validity"), "html", null, true);
        yield "</label>
                                        <select class=\"form-select\" id=\"plan_months\" name=\"plan_months\">
                                            <option value=\"0\">";
        // line 69
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.no_modify"), "html", null, true);
        yield "</option>
                                            <option value=\"1\">+1 mes</option>
                                            <option value=\"3\">+3 meses</option>
                                            <option value=\"6\">+6 meses</option>
                                            <option value=\"12\">+12 meses (1 año)</option>
                                            <option value=\"24\">+24 meses (2 años)</option>
                                        </select>
                                        <div class=\"form-text\">
                                            ";
        // line 77
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 77, $this->source); })()), "planExpiresAt", [], "any", false, false, false, 77)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 78
            yield "                                                Vence: ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 78, $this->source); })()), "planExpiresAt", [], "any", false, false, false, 78), "d/m/Y"), "html", null, true);
            yield "
                                                ";
            // line 79
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 79, $this->source); })()), "isPlanExpired", [], "any", false, false, false, 79)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 80
                yield "                                                    <span class=\"text-danger\">(EXPIRADO)</span>
                                                ";
            } else {
                // line 82
                yield "                                                    (";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 82, $this->source); })()), "daysUntilExpiration", [], "any", false, false, false, 82), "html", null, true);
                yield " días)
                                                ";
            }
            // line 84
            yield "                                            ";
        } else {
            // line 85
            yield "                                                Sin límite de tiempo
                                            ";
        }
        // line 87
        yield "                                        </div>
                                    </div>

                                    <div class=\"col-md-6 mb-3\">
                                        <label class=\"form-label\">Estado</label>
                                        <div class=\"form-check form-switch\">
                                            <input class=\"form-check-input\" type=\"checkbox\" id=\"is_active\" name=\"is_active\" value=\"1\" ";
        // line 93
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 93, $this->source); })()), "isActive", [], "any", false, false, false, 93)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "checked";
        }
        yield ">
                                            <label class=\"form-check-label\" for=\"is_active\">
                                                Empresa Activa
                                            </label>
                                        </div>
                                        <div class=\"form-text\">
                                            ";
        // line 99
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 99, $this->source); })()), "isActive", [], "any", false, false, false, 99)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 100
            yield "                                                <span class=\"text-success\">✓ Activa</span>
                                            ";
        } else {
            // line 102
            yield "                                                <span class=\"text-danger\">✗ Inactiva</span>
                                            ";
        }
        // line 104
        yield "                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class=\"row\">
                                    <div class=\"col-md-6\">
                                        <h6>Estadísticas</h6>
                                        <ul>
                                            <li>Usuarios: ";
        // line 114
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 114, $this->source); })()), "users", [], "any", false, false, false, 114)), "html", null, true);
        yield " / ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 114, $this->source); })()), "maxUsers", [], "any", false, false, false, 114), "html", null, true);
        yield "</li>
                                            <li>Proyectos: 0 / ";
        // line 115
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 115, $this->source); })()), "maxProjects", [], "any", false, false, false, 115), "html", null, true);
        yield "</li>
                                            <li>Creado: ";
        // line 116
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 116, $this->source); })()), "createdAt", [], "any", false, false, false, 116), "d/m/Y H:i"), "html", null, true);
        yield "</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class=\"d-flex gap-2\">
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"bi bi-check-lg\"></i> Guardar Cambios
                                    </button>
                                    <a href=\"";
        // line 125
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_tenants");
        yield "\" class=\"btn btn-secondary\">
                                        <i class=\"bi bi-x-lg\"></i> Cancelar
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
        return "system/tenants_edit.html.twig";
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
        return array (  339 => 125,  327 => 116,  323 => 115,  317 => 114,  305 => 104,  301 => 102,  297 => 100,  295 => 99,  284 => 93,  276 => 87,  272 => 85,  269 => 84,  263 => 82,  259 => 80,  257 => 79,  252 => 78,  250 => 77,  239 => 69,  234 => 67,  225 => 61,  217 => 56,  206 => 50,  200 => 49,  194 => 48,  183 => 40,  179 => 39,  175 => 38,  168 => 34,  161 => 30,  153 => 27,  146 => 22,  140 => 21,  130 => 17,  125 => 16,  120 => 15,  116 => 14,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Editar Empresa - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'system_tenants.edit_tenant_form'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">

            {% for label, messages in app.flashes %}
                {% for message in messages %}
                    <div class=\"alert alert-{{ label }} alert-dismissible fade show\" role=\"alert\">
                        {{ message }}
                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                    </div>
                {% endfor %}
            {% endfor %}

            <div class=\"row justify-content-center\">
                <div class=\"col-lg-8\">
                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-building\"></i> {{ 'common.edit'|trans }}: {{ tenant.name }}</h5>
                        </div>
                        <div class=\"card-body\">
                            <form method=\"post\" action=\"{{ path('app_system_tenants_edit', {id: tenant.id}) }}\">
                                <div class=\"row\">
                                    <div class=\"col-md-6 mb-3\">
                                        <label for=\"name\" class=\"form-label\">Nombre de la Empresa *</label>
                                        <input type=\"text\" class=\"form-control\" id=\"name\" name=\"name\" value=\"{{ tenant.name }}\" required>
                                    </div>

                                    <div class=\"col-md-6 mb-3\">
                                        <label for=\"slug\" class=\"form-label\">{{ 'system.company_code'|trans }}</label>
                                        <input type=\"text\" class=\"form-control\" id=\"slug\" value=\"{{ tenant.slug }}\" disabled>
                                        <div class=\"form-text\">{{ 'system.company_code_no_change'|trans }}</div>
                                    </div>
                                </div>

                                <div class=\"row\">
                                    <div class=\"col-md-4 mb-3\">
                                        <label for=\"plan\" class=\"form-label\">Plan *</label>
                                        <select class=\"form-select\" id=\"plan\" name=\"plan\" required>
                                            <option value=\"basic\" {% if tenant.plan == 'basic' %}selected{% endif %}>Basic</option>
                                            <option value=\"professional\" {% if tenant.plan == 'professional' %}selected{% endif %}>Professional</option>
                                            <option value=\"enterprise\" {% if tenant.plan == 'enterprise' %}selected{% endif %}>Enterprise</option>
                                        </select>
                                    </div>

                                    <div class=\"col-md-4 mb-3\">
                                        <label for=\"max_users\" class=\"form-label\">Máximo de Usuarios</label>
                                        <input type=\"number\" class=\"form-control\" id=\"max_users\" name=\"max_users\" value=\"{{ tenant.maxUsers }}\" min=\"1\" max=\"1000\">
                                    </div>

                                    <div class=\"col-md-4 mb-3\">
                                        <label for=\"max_projects\" class=\"form-label\">Máximo de Proyectos</label>
                                        <input type=\"number\" class=\"form-control\" id=\"max_projects\" name=\"max_projects\" value=\"{{ tenant.maxProjects }}\" min=\"1\" max=\"10000\">
                                    </div>
                                </div>

                                <div class=\"row\">
                                    <div class=\"col-md-6 mb-3\">
                                        <label for=\"plan_months\" class=\"form-label\">{{ 'system.extend_validity'|trans }}</label>
                                        <select class=\"form-select\" id=\"plan_months\" name=\"plan_months\">
                                            <option value=\"0\">{{ 'system.no_modify'|trans }}</option>
                                            <option value=\"1\">+1 mes</option>
                                            <option value=\"3\">+3 meses</option>
                                            <option value=\"6\">+6 meses</option>
                                            <option value=\"12\">+12 meses (1 año)</option>
                                            <option value=\"24\">+24 meses (2 años)</option>
                                        </select>
                                        <div class=\"form-text\">
                                            {% if tenant.planExpiresAt %}
                                                Vence: {{ tenant.planExpiresAt|date('d/m/Y') }}
                                                {% if tenant.isPlanExpired %}
                                                    <span class=\"text-danger\">(EXPIRADO)</span>
                                                {% else %}
                                                    ({{ tenant.daysUntilExpiration }} días)
                                                {% endif %}
                                            {% else %}
                                                Sin límite de tiempo
                                            {% endif %}
                                        </div>
                                    </div>

                                    <div class=\"col-md-6 mb-3\">
                                        <label class=\"form-label\">Estado</label>
                                        <div class=\"form-check form-switch\">
                                            <input class=\"form-check-input\" type=\"checkbox\" id=\"is_active\" name=\"is_active\" value=\"1\" {% if tenant.isActive %}checked{% endif %}>
                                            <label class=\"form-check-label\" for=\"is_active\">
                                                Empresa Activa
                                            </label>
                                        </div>
                                        <div class=\"form-text\">
                                            {% if tenant.isActive %}
                                                <span class=\"text-success\">✓ Activa</span>
                                            {% else %}
                                                <span class=\"text-danger\">✗ Inactiva</span>
                                            {% endif %}
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class=\"row\">
                                    <div class=\"col-md-6\">
                                        <h6>Estadísticas</h6>
                                        <ul>
                                            <li>Usuarios: {{ tenant.users|length }} / {{ tenant.maxUsers }}</li>
                                            <li>Proyectos: 0 / {{ tenant.maxProjects }}</li>
                                            <li>Creado: {{ tenant.createdAt|date('d/m/Y H:i') }}</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class=\"d-flex gap-2\">
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"bi bi-check-lg\"></i> Guardar Cambios
                                    </button>
                                    <a href=\"{{ path('app_system_tenants') }}\" class=\"btn btn-secondary\">
                                        <i class=\"bi bi-x-lg\"></i> Cancelar
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
", "system/tenants_edit.html.twig", "/var/www/html/proyecto/templates/system/tenants_edit.html.twig");
    }
}
