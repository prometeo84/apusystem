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

/* apu/edit.html.twig */
class __TwigTemplate_ce88c382f960679b121482d5d67188f6 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "apu/edit.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "apu/edit.html.twig"));

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

        yield "Editar APU";
        
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
        yield "<div class=\"container mt-4\">
    <h1><i class=\"bi bi-pencil\"></i> Editar Análisis de Precios Unitarios</h1>

    <form method=\"POST\" id=\"apuForm\">
        <div class=\"card mb-3\">
            <div class=\"card-header bg-primary text-white\">
                Datos Principales
            </div>
            <div class=\"card-body\">
                <div class=\"row\">
                    <div class=\"col-md-8\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">Descripción del Rubro</label>
                            <input type=\"text\" class=\"form-control\" name=\"description\"
                                   value=\"";
        // line 20
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["apu_item"]) || array_key_exists("apu_item", $context) ? $context["apu_item"] : (function () { throw new RuntimeError('Variable "apu_item" does not exist.', 20, $this->source); })()), "description", [], "any", false, false, false, 20), "html", null, true);
        yield "\" required>
                        </div>
                    </div>
                    <div class=\"col-md-4\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">Unidad</label>
                            <select class=\"form-select\" name=\"unit\" required>
                                <option value=\"\">Seleccionar...</option>
                                <option value=\"m²\" ";
        // line 28
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["apu_item"]) || array_key_exists("apu_item", $context) ? $context["apu_item"] : (function () { throw new RuntimeError('Variable "apu_item" does not exist.', 28, $this->source); })()), "unit", [], "any", false, false, false, 28) == "m²")) {
            yield "selected";
        }
        yield ">m²</option>
                                <option value=\"m³\" ";
        // line 29
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["apu_item"]) || array_key_exists("apu_item", $context) ? $context["apu_item"] : (function () { throw new RuntimeError('Variable "apu_item" does not exist.', 29, $this->source); })()), "unit", [], "any", false, false, false, 29) == "m³")) {
            yield "selected";
        }
        yield ">m³</option>
                                <option value=\"m\" ";
        // line 30
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["apu_item"]) || array_key_exists("apu_item", $context) ? $context["apu_item"] : (function () { throw new RuntimeError('Variable "apu_item" does not exist.', 30, $this->source); })()), "unit", [], "any", false, false, false, 30) == "m")) {
            yield "selected";
        }
        yield ">m (metro lineal)</option>
                                <option value=\"kg\" ";
        // line 31
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["apu_item"]) || array_key_exists("apu_item", $context) ? $context["apu_item"] : (function () { throw new RuntimeError('Variable "apu_item" does not exist.', 31, $this->source); })()), "unit", [], "any", false, false, false, 31) == "kg")) {
            yield "selected";
        }
        yield ">kg</option>
                                <option value=\"u\" ";
        // line 32
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["apu_item"]) || array_key_exists("apu_item", $context) ? $context["apu_item"] : (function () { throw new RuntimeError('Variable "apu_item" does not exist.', 32, $this->source); })()), "unit", [], "any", false, false, false, 32) == "u")) {
            yield "selected";
        }
        yield ">u (unidad)</option>
                                <option value=\"GLB\" ";
        // line 33
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["apu_item"]) || array_key_exists("apu_item", $context) ? $context["apu_item"] : (function () { throw new RuntimeError('Variable "apu_item" does not exist.', 33, $this->source); })()), "unit", [], "any", false, false, false, 33) == "GLB")) {
            yield "selected";
        }
        yield ">GLB (global)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">K(H/U)</label>
                            <input type=\"number\" step=\"0.0001\" class=\"form-control\" name=\"khu\"
                                   value=\"";
        // line 44
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["apu_item"]) || array_key_exists("apu_item", $context) ? $context["apu_item"] : (function () { throw new RuntimeError('Variable "apu_item" does not exist.', 44, $this->source); })()), "khu", [], "any", false, false, false, 44), "html", null, true);
        yield "\" required>
                        </div>
                    </div>
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">Rend. u/h</label>
                            <input type=\"number\" step=\"0.0001\" class=\"form-control\" name=\"rendimiento_uh\"
                                   value=\"";
        // line 51
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["apu_item"]) || array_key_exists("apu_item", $context) ? $context["apu_item"] : (function () { throw new RuntimeError('Variable "apu_item" does not exist.', 51, $this->source); })()), "rendimientoUh", [], "any", false, false, false, 51), "html", null, true);
        yield "\" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secciones Equipo, Labor, Materials, Transport igual que create.html.twig -->
        <!-- Por brevedad, usar mismo código JavaScript -->

        <div class=\"text-end\">
            <a href=\"";
        // line 62
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_apu_index");
        yield "\" class=\"btn btn-outline-secondary\">Cancelar</a>
            <button type=\"submit\" class=\"btn btn-primary\">
                <i class=\"bi bi-save\"></i> Actualizar APU
            </button>
        </div>
    </form>
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
        return "apu/edit.html.twig";
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
        return array (  197 => 62,  183 => 51,  173 => 44,  157 => 33,  151 => 32,  145 => 31,  139 => 30,  133 => 29,  127 => 28,  116 => 20,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Editar APU{% endblock %}

{% block body %}
<div class=\"container mt-4\">
    <h1><i class=\"bi bi-pencil\"></i> Editar Análisis de Precios Unitarios</h1>

    <form method=\"POST\" id=\"apuForm\">
        <div class=\"card mb-3\">
            <div class=\"card-header bg-primary text-white\">
                Datos Principales
            </div>
            <div class=\"card-body\">
                <div class=\"row\">
                    <div class=\"col-md-8\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">Descripción del Rubro</label>
                            <input type=\"text\" class=\"form-control\" name=\"description\"
                                   value=\"{{ apu_item.description }}\" required>
                        </div>
                    </div>
                    <div class=\"col-md-4\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">Unidad</label>
                            <select class=\"form-select\" name=\"unit\" required>
                                <option value=\"\">Seleccionar...</option>
                                <option value=\"m²\" {% if apu_item.unit == 'm²' %}selected{% endif %}>m²</option>
                                <option value=\"m³\" {% if apu_item.unit == 'm³' %}selected{% endif %}>m³</option>
                                <option value=\"m\" {% if apu_item.unit == 'm' %}selected{% endif %}>m (metro lineal)</option>
                                <option value=\"kg\" {% if apu_item.unit == 'kg' %}selected{% endif %}>kg</option>
                                <option value=\"u\" {% if apu_item.unit == 'u' %}selected{% endif %}>u (unidad)</option>
                                <option value=\"GLB\" {% if apu_item.unit == 'GLB' %}selected{% endif %}>GLB (global)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">K(H/U)</label>
                            <input type=\"number\" step=\"0.0001\" class=\"form-control\" name=\"khu\"
                                   value=\"{{ apu_item.khu }}\" required>
                        </div>
                    </div>
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">Rend. u/h</label>
                            <input type=\"number\" step=\"0.0001\" class=\"form-control\" name=\"rendimiento_uh\"
                                   value=\"{{ apu_item.rendimientoUh }}\" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secciones Equipo, Labor, Materials, Transport igual que create.html.twig -->
        <!-- Por brevedad, usar mismo código JavaScript -->

        <div class=\"text-end\">
            <a href=\"{{ path('app_apu_index') }}\" class=\"btn btn-outline-secondary\">Cancelar</a>
            <button type=\"submit\" class=\"btn btn-primary\">
                <i class=\"bi bi-save\"></i> Actualizar APU
            </button>
        </div>
    </form>
</div>
{% endblock %}
", "apu/edit.html.twig", "/var/www/html/proyecto/templates/apu/edit.html.twig");
    }
}
