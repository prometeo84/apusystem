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

/* system/tenants_create.html.twig */
class __TwigTemplate_28851ec630a19ad772d8368c8dfc15f9 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "system/tenants_create.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "system/tenants_create.html.twig"));

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

        yield "Crear Empresa - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system_tenants.create_tenant_form")]));
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
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.new_tenant_title"), "html", null, true);
        yield "</h5>
                        </div>
                        <div class=\"card-body\">
                            <form method=\"post\" action=\"";
        // line 30
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_tenants_create");
        yield "\">
                                <div class=\"row\">
                                    <div class=\"col-md-6 mb-3\">
                                        <label for=\"name\" class=\"form-label\">";
        // line 33
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.company_name"), "html", null, true);
        yield " *</label>
                                        <input type=\"text\" class=\"form-control\" id=\"name\" name=\"name\" required>
                                        <div class=\"form-text\">";
        // line 35
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.commercial_name"), "html", null, true);
        yield "</div>
                                    </div>

                                    <div class=\"col-md-6 mb-3\">
                                        <label for=\"slug\" class=\"form-label\">";
        // line 39
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.company_code"), "html", null, true);
        yield " *</label>
                                        <input type=\"text\" class=\"form-control\" id=\"slug\" name=\"slug\" required pattern=\"[a-z0-9-]+\">
                                        <div class=\"form-text\">";
        // line 41
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.company_code_hint"), "html", null, true);
        yield "</div>
                                    </div>
                                </div>

                                <div class=\"row\">
                                    <div class=\"col-md-4 mb-3\">
                                        <label for=\"plan\" class=\"form-label\">Plan *</label>
                                        <select class=\"form-select\" id=\"plan\" name=\"plan\" required onchange=\"updateLimits()\">
                                            <option value=\"basic\">Basic</option>
                                            <option value=\"professional\">Professional</option>
                                            <option value=\"enterprise\">Enterprise</option>
                                        </select>
                                    </div>

                                    <div class=\"col-md-4 mb-3\">
                                        <label for=\"max_users\" class=\"form-label\">";
        // line 56
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.max_users"), "html", null, true);
        yield "</label>
                                        <input type=\"number\" class=\"form-control\" id=\"max_users\" name=\"max_users\" value=\"5\" min=\"1\" max=\"1000\">
                                    </div>

                                    <div class=\"col-md-4 mb-3\">
                                        <label for=\"max_projects\" class=\"form-label\">";
        // line 61
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.max_projects"), "html", null, true);
        yield "</label>
                                        <input type=\"number\" class=\"form-control\" id=\"max_projects\" name=\"max_projects\" value=\"10\" min=\"1\" max=\"10000\">
                                    </div>
                                </div>

                                <div class=\"row\">
                                    <div class=\"col-md-6 mb-3\">
                                        <label for=\"plan_months\" class=\"form-label\">";
        // line 68
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.plan_validity"), "html", null, true);
        yield "</label>
                                        <select class=\"form-select\" id=\"plan_months\" name=\"plan_months\">
                                            <option value=\"0\">";
        // line 70
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.no_limit"), "html", null, true);
        yield "</option>
                                            <option value=\"1\">1 mes (Prueba)</option>
                                            <option value=\"3\">3 meses</option>
                                            <option value=\"6\">6 meses</option>
                                            <option value=\"12\" selected>12 meses (1 año)</option>
                                            <option value=\"24\">24 meses (2 años)</option>
                                            <option value=\"36\">36 meses (3 años)</option>
                                        </select>
                                        <div class=\"form-text\">Duración del plan antes de expirar</div>
                                    </div>
                                </div>

                                <hr>

                                <div class=\"alert alert-info\">
                                    <h6><i class=\"bi bi-info-circle\"></i> Información de Planes</h6>
                                    <ul class=\"mb-0\">
                                        <li><strong>Basic:</strong> 5 usuarios, 10 proyectos</li>
                                        <li><strong>Professional:</strong> 25 usuarios, 100 proyectos</li>
                                        <li><strong>Enterprise:</strong> Usuarios y proyectos ilimitados</li>
                                    </ul>
                                </div>

                                <div class=\"d-flex gap-2\">
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"bi bi-check-lg\"></i> Crear Empresa
                                    </button>
                                    <a href=\"";
        // line 97
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

<script>
function updateLimits() {
    const plan = document.getElementById('plan').value;
    const maxUsers = document.getElementById('max_users');
    const maxProjects = document.getElementById('max_projects');

    if (plan === 'basic') {
        maxUsers.value = 5;
        maxProjects.value = 10;
    } else if (plan === 'professional') {
        maxUsers.value = 25;
        maxProjects.value = 100;
    } else if (plan === 'enterprise') {
        maxUsers.value = 999;
        maxProjects.value = 9999;
    }
}

// Auto-generate company code from name
document.getElementById('name').addEventListener('input', function(e) {
    const slug = e.target.value
        .toLowerCase()
        .normalize('NFD').replace(/[\\u0300-\\u036f]/g, '') // Remove accents
        .replace(/[^a-z0-9\\s-]/g, '') // Remove special chars
        .replace(/\\s+/g, '-') // Spaces to hyphens
        .replace(/-+/g, '-'); // Multiple hyphens to single
    document.getElementById('slug').value = slug;
});
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
        return "system/tenants_create.html.twig";
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
        return array (  253 => 97,  223 => 70,  218 => 68,  208 => 61,  200 => 56,  182 => 41,  177 => 39,  170 => 35,  165 => 33,  159 => 30,  153 => 27,  146 => 22,  140 => 21,  130 => 17,  125 => 16,  120 => 15,  116 => 14,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Crear Empresa - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'system_tenants.create_tenant_form'|trans} %}

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
                            <h5 class=\"mb-0\"><i class=\"bi bi-building\"></i> {{ 'system.new_tenant_title'|trans }}</h5>
                        </div>
                        <div class=\"card-body\">
                            <form method=\"post\" action=\"{{ path('app_system_tenants_create') }}\">
                                <div class=\"row\">
                                    <div class=\"col-md-6 mb-3\">
                                        <label for=\"name\" class=\"form-label\">{{ 'system.company_name'|trans }} *</label>
                                        <input type=\"text\" class=\"form-control\" id=\"name\" name=\"name\" required>
                                        <div class=\"form-text\">{{ 'system.commercial_name'|trans }}</div>
                                    </div>

                                    <div class=\"col-md-6 mb-3\">
                                        <label for=\"slug\" class=\"form-label\">{{ 'system.company_code'|trans }} *</label>
                                        <input type=\"text\" class=\"form-control\" id=\"slug\" name=\"slug\" required pattern=\"[a-z0-9-]+\">
                                        <div class=\"form-text\">{{ 'system.company_code_hint'|trans }}</div>
                                    </div>
                                </div>

                                <div class=\"row\">
                                    <div class=\"col-md-4 mb-3\">
                                        <label for=\"plan\" class=\"form-label\">Plan *</label>
                                        <select class=\"form-select\" id=\"plan\" name=\"plan\" required onchange=\"updateLimits()\">
                                            <option value=\"basic\">Basic</option>
                                            <option value=\"professional\">Professional</option>
                                            <option value=\"enterprise\">Enterprise</option>
                                        </select>
                                    </div>

                                    <div class=\"col-md-4 mb-3\">
                                        <label for=\"max_users\" class=\"form-label\">{{ 'system.max_users'|trans }}</label>
                                        <input type=\"number\" class=\"form-control\" id=\"max_users\" name=\"max_users\" value=\"5\" min=\"1\" max=\"1000\">
                                    </div>

                                    <div class=\"col-md-4 mb-3\">
                                        <label for=\"max_projects\" class=\"form-label\">{{ 'system.max_projects'|trans }}</label>
                                        <input type=\"number\" class=\"form-control\" id=\"max_projects\" name=\"max_projects\" value=\"10\" min=\"1\" max=\"10000\">
                                    </div>
                                </div>

                                <div class=\"row\">
                                    <div class=\"col-md-6 mb-3\">
                                        <label for=\"plan_months\" class=\"form-label\">{{ 'system.plan_validity'|trans }}</label>
                                        <select class=\"form-select\" id=\"plan_months\" name=\"plan_months\">
                                            <option value=\"0\">{{ 'system.no_limit'|trans }}</option>
                                            <option value=\"1\">1 mes (Prueba)</option>
                                            <option value=\"3\">3 meses</option>
                                            <option value=\"6\">6 meses</option>
                                            <option value=\"12\" selected>12 meses (1 año)</option>
                                            <option value=\"24\">24 meses (2 años)</option>
                                            <option value=\"36\">36 meses (3 años)</option>
                                        </select>
                                        <div class=\"form-text\">Duración del plan antes de expirar</div>
                                    </div>
                                </div>

                                <hr>

                                <div class=\"alert alert-info\">
                                    <h6><i class=\"bi bi-info-circle\"></i> Información de Planes</h6>
                                    <ul class=\"mb-0\">
                                        <li><strong>Basic:</strong> 5 usuarios, 10 proyectos</li>
                                        <li><strong>Professional:</strong> 25 usuarios, 100 proyectos</li>
                                        <li><strong>Enterprise:</strong> Usuarios y proyectos ilimitados</li>
                                    </ul>
                                </div>

                                <div class=\"d-flex gap-2\">
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"bi bi-check-lg\"></i> Crear Empresa
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

<script>
function updateLimits() {
    const plan = document.getElementById('plan').value;
    const maxUsers = document.getElementById('max_users');
    const maxProjects = document.getElementById('max_projects');

    if (plan === 'basic') {
        maxUsers.value = 5;
        maxProjects.value = 10;
    } else if (plan === 'professional') {
        maxUsers.value = 25;
        maxProjects.value = 100;
    } else if (plan === 'enterprise') {
        maxUsers.value = 999;
        maxProjects.value = 9999;
    }
}

// Auto-generate company code from name
document.getElementById('name').addEventListener('input', function(e) {
    const slug = e.target.value
        .toLowerCase()
        .normalize('NFD').replace(/[\\u0300-\\u036f]/g, '') // Remove accents
        .replace(/[^a-z0-9\\s-]/g, '') // Remove special chars
        .replace(/\\s+/g, '-') // Spaces to hyphens
        .replace(/-+/g, '-'); // Multiple hyphens to single
    document.getElementById('slug').value = slug;
});
</script>
{% endblock %}
", "system/tenants_create.html.twig", "/var/www/html/proyecto/templates/system/tenants_create.html.twig");
    }
}
