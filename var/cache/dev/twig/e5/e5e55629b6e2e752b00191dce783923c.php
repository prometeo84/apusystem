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

/* apu/index.html.twig */
class __TwigTemplate_424b9078fd59585817e34877e3e04835 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "apu/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "apu/index.html.twig"));

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

        yield "APU - Análisis de Precios Unitarios";
        
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
        yield "<div class=\"container-fluid mt-4\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1><i class=\"bi bi-calculator\"></i> Análisis de Precios Unitarios</h1>
        <a href=\"";
        // line 9
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_apu_create");
        yield "\" class=\"btn btn-primary\">
            <i class=\"bi bi-plus-circle\"></i> Nuevo APU
        </a>
    </div>

    ";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 14, $this->source); })()), "flashes", ["success"], "method", false, false, false, 14));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 15
            yield "        <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
            ";
            // line 16
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "
            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
        </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 20
        yield "
    ";
        // line 21
        if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["apu_items"]) || array_key_exists("apu_items", $context) ? $context["apu_items"] : (function () { throw new RuntimeError('Variable "apu_items" does not exist.', 21, $this->source); })())) > 0)) {
            // line 22
            yield "        <div class=\"card\">
            <div class=\"card-body\">
                <table class=\"table table-hover\">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Unidad</th>
                            <th>K(H/U)</th>
                            <th>Rend. u/h</th>
                            <th class=\"text-end\">Costo Total</th>
                            <th>Fecha</th>
                            <th class=\"text-center\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        ";
            // line 37
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["apu_items"]) || array_key_exists("apu_items", $context) ? $context["apu_items"] : (function () { throw new RuntimeError('Variable "apu_items" does not exist.', 37, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 38
                yield "                            <tr>
                                <td>";
                // line 39
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "description", [], "any", false, false, false, 39), "html", null, true);
                yield "</td>
                                <td><span class=\"badge bg-secondary\">";
                // line 40
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "unit", [], "any", false, false, false, 40), "html", null, true);
                yield "</span></td>
                                <td>";
                // line 41
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "khu", [], "any", false, false, false, 41), 4), "html", null, true);
                yield "</td>
                                <td>";
                // line 42
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "rendimientoUh", [], "any", false, false, false, 42), 4), "html", null, true);
                yield "</td>
                                <td class=\"text-end\">
                                    <strong>\$";
                // line 44
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatNumber(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "totalCost", [], "any", false, false, false, 44), 2), "html", null, true);
                yield "</strong>
                                </td>
                                <td>";
                // line 46
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "createdAt", [], "any", false, false, false, 46), "d/m/Y"), "html", null, true);
                yield "</td>
                                <td class=\"text-center\">
                                    <a href=\"";
                // line 48
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_apu_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, false, 48)]), "html", null, true);
                yield "\" class=\"btn btn-sm btn-outline-primary\" title=\"Editar\">
                                        <i class=\"bi bi-pencil\"></i>
                                    </a>
                                    <a href=\"";
                // line 51
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_apu_export_excel", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, false, 51)]), "html", null, true);
                yield "\" class=\"btn btn-sm btn-outline-success\" title=\"Exportar Excel\">
                                        <i class=\"bi bi-file-earmark-excel\"></i>
                                    </a>
                                </td>
                            </tr>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['item'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 57
            yield "                    </tbody>
                </table>
            </div>
        </div>
    ";
        } else {
            // line 62
            yield "        <div class=\"alert alert-info\">
            <i class=\"bi bi-info-circle\"></i> No hay APUs registrados.
            <a href=\"";
            // line 64
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_apu_create");
            yield "\" class=\"alert-link\">Crear el primero</a>
        </div>
    ";
        }
        // line 67
        yield "</div>
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
        return "apu/index.html.twig";
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
        return array (  221 => 67,  215 => 64,  211 => 62,  204 => 57,  192 => 51,  186 => 48,  181 => 46,  176 => 44,  171 => 42,  167 => 41,  163 => 40,  159 => 39,  156 => 38,  152 => 37,  135 => 22,  133 => 21,  130 => 20,  120 => 16,  117 => 15,  113 => 14,  105 => 9,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}APU - Análisis de Precios Unitarios{% endblock %}

{% block body %}
<div class=\"container-fluid mt-4\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1><i class=\"bi bi-calculator\"></i> Análisis de Precios Unitarios</h1>
        <a href=\"{{ path('app_apu_create') }}\" class=\"btn btn-primary\">
            <i class=\"bi bi-plus-circle\"></i> Nuevo APU
        </a>
    </div>

    {% for message in app.flashes('success') %}
        <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
            {{ message }}
            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
        </div>
    {% endfor %}

    {% if apu_items|length > 0 %}
        <div class=\"card\">
            <div class=\"card-body\">
                <table class=\"table table-hover\">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Unidad</th>
                            <th>K(H/U)</th>
                            <th>Rend. u/h</th>
                            <th class=\"text-end\">Costo Total</th>
                            <th>Fecha</th>
                            <th class=\"text-center\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {% for item in apu_items %}
                            <tr>
                                <td>{{ item.description }}</td>
                                <td><span class=\"badge bg-secondary\">{{ item.unit }}</span></td>
                                <td>{{ item.khu|number_format(4) }}</td>
                                <td>{{ item.rendimientoUh|number_format(4) }}</td>
                                <td class=\"text-end\">
                                    <strong>\${{ item.totalCost|number_format(2) }}</strong>
                                </td>
                                <td>{{ item.createdAt|date('d/m/Y') }}</td>
                                <td class=\"text-center\">
                                    <a href=\"{{ path('app_apu_edit', {id: item.id}) }}\" class=\"btn btn-sm btn-outline-primary\" title=\"Editar\">
                                        <i class=\"bi bi-pencil\"></i>
                                    </a>
                                    <a href=\"{{ path('app_apu_export_excel', {id: item.id}) }}\" class=\"btn btn-sm btn-outline-success\" title=\"Exportar Excel\">
                                        <i class=\"bi bi-file-earmark-excel\"></i>
                                    </a>
                                </td>
                            </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    {% else %}
        <div class=\"alert alert-info\">
            <i class=\"bi bi-info-circle\"></i> No hay APUs registrados.
            <a href=\"{{ path('app_apu_create') }}\" class=\"alert-link\">Crear el primero</a>
        </div>
    {% endif %}
</div>
{% endblock %}
", "apu/index.html.twig", "/var/www/html/proyecto/templates/apu/index.html.twig");
    }
}
