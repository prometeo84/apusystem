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

/* revit/upload.html.twig */
class __TwigTemplate_bfcac491c3d721b17d48414d6a974ff0 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "revit/upload.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "revit/upload.html.twig"));

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

        yield "Subir Archivo Revit";
        
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
    <div class=\"row\">
        <div class=\"col-md-8 offset-md-2\">
            <h1><i class=\"bi bi-cloud-upload\"></i> Subir Archivo de Revit</h1>
            <p class=\"text-muted\">Suba archivos IFC, JSON o RVT para generar automáticamente APUs</p>

            ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 12, $this->source); })()), "flashes", ["error"], "method", false, false, false, 12));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 13
            yield "                <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                    <i class=\"bi bi-exclamation-triangle\"></i> ";
            // line 14
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 18
        yield "
            ";
        // line 19
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 19, $this->source); })()), "flashes", ["success"], "method", false, false, false, 19));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 20
            yield "                <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                    <i class=\"bi bi-check-circle\"></i> ";
            // line 21
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 25
        yield "
            <div class=\"card\">
                <div class=\"card-body\">
                    <form method=\"POST\" enctype=\"multipart/form-data\" id=\"uploadForm\">
                        <div class=\"mb-3\">
                            <label for=\"revit_file\" class=\"form-label\">Seleccionar Archivo</label>
                            <input type=\"file\"
                                   class=\"form-control\"
                                   id=\"revit_file\"
                                   name=\"revit_file\"
                                   accept=\".ifc,.json,.rvt\"
                                   required>
                            <div class=\"form-text\">
                                Formatos permitidos: IFC, JSON, RVT (máx. 100 MB)
                            </div>
                        </div>

                        <div id=\"fileInfo\" class=\"alert alert-info\" style=\"display: none;\">
                            <strong>Archivo seleccionado:</strong>
                            <ul class=\"mb-0 mt-2\">
                                <li>Nombre: <span id=\"fileName\"></span></li>
                                <li>Tamaño: <span id=\"fileSize\"></span></li>
                                <li>Tipo: <span id=\"fileType\"></span></li>
                            </ul>
                        </div>

                        <div class=\"card bg-light mb-3\">
                            <div class=\"card-body\">
                                <h6 class=\"card-title\">
                                    <i class=\"bi bi-info-circle\"></i> Información
                                </h6>
                                <ul class=\"small mb-0\">
                                    <li><strong>IFC (Industry Foundation Classes):</strong> Formato estándar BIM</li>
                                    <li><strong>JSON:</strong> Datos exportados desde Revit API</li>
                                    <li><strong>RVT:</strong> Archivo nativo de Revit (análisis básico)</li>
                                </ul>
                            </div>
                        </div>

                        <div class=\"d-grid gap-2\">
                            <button type=\"submit\" class=\"btn btn-primary btn-lg\" id=\"submitBtn\">
                                <i class=\"bi bi-cloud-upload\"></i> Subir y Procesar
                            </button>
                            <a href=\"";
        // line 68
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_revit_files");
        yield "\" class=\"btn btn-outline-secondary\">
                                <i class=\"bi bi-list\"></i> Ver Archivos Subidos
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class=\"mt-4\">
                <div class=\"card\">
                    <div class=\"card-header\">
                        <i class=\"bi bi-lightbulb\"></i> ¿Cómo funciona?
                    </div>
                    <div class=\"card-body\">
                        <ol>
                            <li>Exporte los datos desde Revit en formato IFC o JSON</li>
                            <li>Suba el archivo usando este formulario</li>
                            <li>El sistema procesará automáticamente:
                                <ul>
                                    <li>Extracción de elementos (muros, losas, columnas)</li>
                                    <li>Cálculo de cantidades y volúmenes</li>
                                    <li>Generación de APUs basados en los datos</li>
                                </ul>
                            </li>
                            <li>Revise y ajuste los APUs generados</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('revit_file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const fileInfo = document.getElementById('fileInfo');

    if (file) {
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = formatFileSize(file.size);
        document.getElementById('fileType').textContent = file.type || 'Desconocido';
        fileInfo.style.display = 'block';
    } else {
        fileInfo.style.display = 'none';
    }
});

document.getElementById('uploadForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class=\"spinner-border spinner-border-sm\" role=\"status\"></span> Subiendo...';
});

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}
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
        return "revit/upload.html.twig";
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
        return array (  190 => 68,  145 => 25,  135 => 21,  132 => 20,  128 => 19,  125 => 18,  115 => 14,  112 => 13,  108 => 12,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Subir Archivo Revit{% endblock %}

{% block body %}
<div class=\"container mt-4\">
    <div class=\"row\">
        <div class=\"col-md-8 offset-md-2\">
            <h1><i class=\"bi bi-cloud-upload\"></i> Subir Archivo de Revit</h1>
            <p class=\"text-muted\">Suba archivos IFC, JSON o RVT para generar automáticamente APUs</p>

            {% for message in app.flashes('error') %}
                <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
                    <i class=\"bi bi-exclamation-triangle\"></i> {{ message }}
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            {% endfor %}

            {% for message in app.flashes('success') %}
                <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
                    <i class=\"bi bi-check-circle\"></i> {{ message }}
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            {% endfor %}

            <div class=\"card\">
                <div class=\"card-body\">
                    <form method=\"POST\" enctype=\"multipart/form-data\" id=\"uploadForm\">
                        <div class=\"mb-3\">
                            <label for=\"revit_file\" class=\"form-label\">Seleccionar Archivo</label>
                            <input type=\"file\"
                                   class=\"form-control\"
                                   id=\"revit_file\"
                                   name=\"revit_file\"
                                   accept=\".ifc,.json,.rvt\"
                                   required>
                            <div class=\"form-text\">
                                Formatos permitidos: IFC, JSON, RVT (máx. 100 MB)
                            </div>
                        </div>

                        <div id=\"fileInfo\" class=\"alert alert-info\" style=\"display: none;\">
                            <strong>Archivo seleccionado:</strong>
                            <ul class=\"mb-0 mt-2\">
                                <li>Nombre: <span id=\"fileName\"></span></li>
                                <li>Tamaño: <span id=\"fileSize\"></span></li>
                                <li>Tipo: <span id=\"fileType\"></span></li>
                            </ul>
                        </div>

                        <div class=\"card bg-light mb-3\">
                            <div class=\"card-body\">
                                <h6 class=\"card-title\">
                                    <i class=\"bi bi-info-circle\"></i> Información
                                </h6>
                                <ul class=\"small mb-0\">
                                    <li><strong>IFC (Industry Foundation Classes):</strong> Formato estándar BIM</li>
                                    <li><strong>JSON:</strong> Datos exportados desde Revit API</li>
                                    <li><strong>RVT:</strong> Archivo nativo de Revit (análisis básico)</li>
                                </ul>
                            </div>
                        </div>

                        <div class=\"d-grid gap-2\">
                            <button type=\"submit\" class=\"btn btn-primary btn-lg\" id=\"submitBtn\">
                                <i class=\"bi bi-cloud-upload\"></i> Subir y Procesar
                            </button>
                            <a href=\"{{ path('app_revit_files') }}\" class=\"btn btn-outline-secondary\">
                                <i class=\"bi bi-list\"></i> Ver Archivos Subidos
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class=\"mt-4\">
                <div class=\"card\">
                    <div class=\"card-header\">
                        <i class=\"bi bi-lightbulb\"></i> ¿Cómo funciona?
                    </div>
                    <div class=\"card-body\">
                        <ol>
                            <li>Exporte los datos desde Revit en formato IFC o JSON</li>
                            <li>Suba el archivo usando este formulario</li>
                            <li>El sistema procesará automáticamente:
                                <ul>
                                    <li>Extracción de elementos (muros, losas, columnas)</li>
                                    <li>Cálculo de cantidades y volúmenes</li>
                                    <li>Generación de APUs basados en los datos</li>
                                </ul>
                            </li>
                            <li>Revise y ajuste los APUs generados</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('revit_file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const fileInfo = document.getElementById('fileInfo');

    if (file) {
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = formatFileSize(file.size);
        document.getElementById('fileType').textContent = file.type || 'Desconocido';
        fileInfo.style.display = 'block';
    } else {
        fileInfo.style.display = 'none';
    }
});

document.getElementById('uploadForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class=\"spinner-border spinner-border-sm\" role=\"status\"></span> Subiendo...';
});

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}
</script>
{% endblock %}
", "revit/upload.html.twig", "/var/www/html/proyecto/templates/revit/upload.html.twig");
    }
}
