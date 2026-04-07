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

/* revit/files.html.twig */
class __TwigTemplate_791bf6892da8957823e2f19dfa6c2ce6 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "revit/files.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "revit/files.html.twig"));

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

        yield "Archivos de Revit";
        
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
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1><i class=\"bi bi-folder\"></i> Archivos de Revit</h1>
        <a href=\"";
        // line 9
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_revit_upload");
        yield "\" class=\"btn btn-primary\">
            <i class=\"bi bi-cloud-upload\"></i> Subir Nuevo Archivo
        </a>
    </div>

    ";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 14, $this->source); })()), "flashes", ["error"], "method", false, false, false, 14));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 15
            yield "        <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
            <i class=\"bi bi-exclamation-triangle\"></i> ";
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
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 21, $this->source); })()), "flashes", ["success"], "method", false, false, false, 21));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 22
            yield "        <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
            <i class=\"bi bi-check-circle\"></i> ";
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
        yield "
    ";
        // line 28
        if (Twig\Extension\CoreExtension::testEmpty((isset($context["files"]) || array_key_exists("files", $context) ? $context["files"] : (function () { throw new RuntimeError('Variable "files" does not exist.', 28, $this->source); })()))) {
            // line 29
            yield "        <div class=\"alert alert-info\">
            <i class=\"bi bi-info-circle\"></i> No hay archivos subidos aún.
            <a href=\"";
            // line 31
            yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_revit_upload");
            yield "\" class=\"alert-link\">Suba su primer archivo aquí</a>.
        </div>
    ";
        } else {
            // line 34
            yield "        <div class=\"card\">
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-hover\">
                        <thead>
                            <tr>
                                <th width=\"5%\"><i class=\"bi bi-file-earmark\"></i></th>
                                <th width=\"30%\">Archivo</th>
                                <th width=\"10%\">Tipo</th>
                                <th width=\"10%\">Tamaño</th>
                                <th width=\"15%\">Estado</th>
                                <th width=\"15%\">Fecha</th>
                                <th width=\"15%\" class=\"text-end\">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            ";
            // line 50
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable((isset($context["files"]) || array_key_exists("files", $context) ? $context["files"] : (function () { throw new RuntimeError('Variable "files" does not exist.', 50, $this->source); })()));
            foreach ($context['_seq'] as $context["_key"] => $context["file"]) {
                // line 51
                yield "                                <tr>
                                    <td class=\"text-center\">
                                        ";
                // line 53
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["file"], "fileType", [], "any", false, false, false, 53) == "ifc")) {
                    // line 54
                    yield "                                            <i class=\"bi bi-file-code text-primary fs-4\"></i>
                                        ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 55
$context["file"], "fileType", [], "any", false, false, false, 55) == "json")) {
                    // line 56
                    yield "                                            <i class=\"bi bi-file-code-fill text-success fs-4\"></i>
                                        ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 57
$context["file"], "fileType", [], "any", false, false, false, 57) == "rvt")) {
                    // line 58
                    yield "                                            <i class=\"bi bi-file-earmark-binary text-info fs-4\"></i>
                                        ";
                } else {
                    // line 60
                    yield "                                            <i class=\"bi bi-file-earmark text-secondary fs-4\"></i>
                                        ";
                }
                // line 62
                yield "                                    </td>
                                    <td>
                                        <strong>";
                // line 64
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["file"], "originalFilename", [], "any", false, false, false, 64), "html", null, true);
                yield "</strong>
                                        <br>
                                        <small class=\"text-muted\">";
                // line 66
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["file"], "storedFilename", [], "any", false, false, false, 66), "html", null, true);
                yield "</small>
                                    </td>
                                    <td>
                                        <span class=\"badge bg-secondary\">";
                // line 69
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["file"], "fileType", [], "any", false, false, false, 69)), "html", null, true);
                yield "</span>
                                    </td>
                                    <td>";
                // line 71
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["file"], "fileSizeFormatted", [], "any", false, false, false, 71), "html", null, true);
                yield "</td>
                                    <td>
                                        ";
                // line 73
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["file"], "status", [], "any", false, false, false, 73) == "completed")) {
                    // line 74
                    yield "                                            <span class=\"badge bg-success\">
                                                <i class=\"bi bi-check-circle\"></i> Completado
                                            </span>
                                        ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 77
$context["file"], "status", [], "any", false, false, false, 77) == "processing")) {
                    // line 78
                    yield "                                            <span class=\"badge bg-warning text-dark\">
                                                <i class=\"bi bi-arrow-repeat\"></i> Procesando
                                            </span>
                                        ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 81
$context["file"], "status", [], "any", false, false, false, 81) == "pending")) {
                    // line 82
                    yield "                                            <span class=\"badge bg-info text-dark\">
                                                <i class=\"bi bi-hourglass-split\"></i> Pendiente
                                            </span>
                                        ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 85
$context["file"], "status", [], "any", false, false, false, 85) == "error")) {
                    // line 86
                    yield "                                            <span class=\"badge bg-danger\">
                                                <i class=\"bi bi-exclamation-triangle\"></i> Error
                                            </span>
                                        ";
                }
                // line 90
                yield "                                    </td>
                                    <td>
                                        <small>";
                // line 92
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["file"], "uploadedAt", [], "any", false, false, false, 92), "d/m/Y H:i"), "html", null, true);
                yield "</small>
                                    </td>
                                    <td class=\"text-end\">
                                        <div class=\"btn-group btn-group-sm\" role=\"group\">
                                            <a href=\"";
                // line 96
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_revit_file_detail", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["file"], "id", [], "any", false, false, false, 96)]), "html", null, true);
                yield "\"
                                               class=\"btn btn-outline-primary\"
                                               title=\"Ver detalles\">
                                                <i class=\"bi bi-eye\"></i>
                                            </a>
                                            ";
                // line 101
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["file"], "status", [], "any", false, false, false, 101) == "error")) {
                    // line 102
                    yield "                                                <form method=\"POST\"
                                                      action=\"";
                    // line 103
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_revit_file_reprocess", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["file"], "id", [], "any", false, false, false, 103)]), "html", null, true);
                    yield "\"
                                                      style=\"display: inline;\">
                                                    <button type=\"submit\"
                                                            class=\"btn btn-outline-warning\"
                                                            title=\"Reprocesar\">
                                                        <i class=\"bi bi-arrow-clockwise\"></i>
                                                    </button>
                                                </form>
                                            ";
                }
                // line 112
                yield "                                            <form method=\"POST\"
                                                  action=\"";
                // line 113
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_revit_file_delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["file"], "id", [], "any", false, false, false, 113)]), "html", null, true);
                yield "\"
                                                  onsubmit=\"return confirm('¿Está seguro de eliminar este archivo?')\"
                                                  style=\"display: inline;\">
                                                <button type=\"submit\"
                                                        class=\"btn btn-outline-danger\"
                                                        title=\"Eliminar\">
                                                    <i class=\"bi bi-trash\"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['file'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 126
            yield "                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class=\"mt-3\">
            <div class=\"row\">
                <div class=\"col-md-3\">
                    <div class=\"card text-center\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">";
            // line 137
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["files"]) || array_key_exists("files", $context) ? $context["files"] : (function () { throw new RuntimeError('Variable "files" does not exist.', 137, $this->source); })())), "html", null, true);
            yield "</h5>
                            <p class=\"card-text text-muted\">Total Archivos</p>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"card text-center\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title text-success\">
                                ";
            // line 146
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), Twig\Extension\CoreExtension::filter($this->env, (isset($context["files"]) || array_key_exists("files", $context) ? $context["files"] : (function () { throw new RuntimeError('Variable "files" does not exist.', 146, $this->source); })()), function ($__f__) use ($context, $macros) { $context["f"] = $__f__; return (CoreExtension::getAttribute($this->env, $this->source, (isset($context["f"]) || array_key_exists("f", $context) ? $context["f"] : (function () { throw new RuntimeError('Variable "f" does not exist.', 146, $this->source); })()), "status", [], "any", false, false, false, 146) == "completed"); })), "html", null, true);
            yield "
                            </h5>
                            <p class=\"card-text text-muted\">Completados</p>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"card text-center\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title text-warning\">
                                ";
            // line 156
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), Twig\Extension\CoreExtension::filter($this->env, (isset($context["files"]) || array_key_exists("files", $context) ? $context["files"] : (function () { throw new RuntimeError('Variable "files" does not exist.', 156, $this->source); })()), function ($__f__) use ($context, $macros) { $context["f"] = $__f__; return ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["f"]) || array_key_exists("f", $context) ? $context["f"] : (function () { throw new RuntimeError('Variable "f" does not exist.', 156, $this->source); })()), "status", [], "any", false, false, false, 156) == "processing") || (CoreExtension::getAttribute($this->env, $this->source, (isset($context["f"]) || array_key_exists("f", $context) ? $context["f"] : (function () { throw new RuntimeError('Variable "f" does not exist.', 156, $this->source); })()), "status", [], "any", false, false, false, 156) == "pending")); })), "html", null, true);
            yield "
                            </h5>
                            <p class=\"card-text text-muted\">En Proceso</p>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"card text-center\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title text-danger\">
                                ";
            // line 166
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), Twig\Extension\CoreExtension::filter($this->env, (isset($context["files"]) || array_key_exists("files", $context) ? $context["files"] : (function () { throw new RuntimeError('Variable "files" does not exist.', 166, $this->source); })()), function ($__f__) use ($context, $macros) { $context["f"] = $__f__; return (CoreExtension::getAttribute($this->env, $this->source, (isset($context["f"]) || array_key_exists("f", $context) ? $context["f"] : (function () { throw new RuntimeError('Variable "f" does not exist.', 166, $this->source); })()), "status", [], "any", false, false, false, 166) == "error"); })), "html", null, true);
            yield "
                            </h5>
                            <p class=\"card-text text-muted\">Con Errores</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ";
        }
        // line 175
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
        return "revit/files.html.twig";
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
        return array (  386 => 175,  374 => 166,  361 => 156,  348 => 146,  336 => 137,  323 => 126,  304 => 113,  301 => 112,  289 => 103,  286 => 102,  284 => 101,  276 => 96,  269 => 92,  265 => 90,  259 => 86,  257 => 85,  252 => 82,  250 => 81,  245 => 78,  243 => 77,  238 => 74,  236 => 73,  231 => 71,  226 => 69,  220 => 66,  215 => 64,  211 => 62,  207 => 60,  203 => 58,  201 => 57,  198 => 56,  196 => 55,  193 => 54,  191 => 53,  187 => 51,  183 => 50,  165 => 34,  159 => 31,  155 => 29,  153 => 28,  150 => 27,  140 => 23,  137 => 22,  133 => 21,  130 => 20,  120 => 16,  117 => 15,  113 => 14,  105 => 9,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Archivos de Revit{% endblock %}

{% block body %}
<div class=\"container mt-4\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1><i class=\"bi bi-folder\"></i> Archivos de Revit</h1>
        <a href=\"{{ path('app_revit_upload') }}\" class=\"btn btn-primary\">
            <i class=\"bi bi-cloud-upload\"></i> Subir Nuevo Archivo
        </a>
    </div>

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

    {% if files is empty %}
        <div class=\"alert alert-info\">
            <i class=\"bi bi-info-circle\"></i> No hay archivos subidos aún.
            <a href=\"{{ path('app_revit_upload') }}\" class=\"alert-link\">Suba su primer archivo aquí</a>.
        </div>
    {% else %}
        <div class=\"card\">
            <div class=\"card-body\">
                <div class=\"table-responsive\">
                    <table class=\"table table-hover\">
                        <thead>
                            <tr>
                                <th width=\"5%\"><i class=\"bi bi-file-earmark\"></i></th>
                                <th width=\"30%\">Archivo</th>
                                <th width=\"10%\">Tipo</th>
                                <th width=\"10%\">Tamaño</th>
                                <th width=\"15%\">Estado</th>
                                <th width=\"15%\">Fecha</th>
                                <th width=\"15%\" class=\"text-end\">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for file in files %}
                                <tr>
                                    <td class=\"text-center\">
                                        {% if file.fileType == 'ifc' %}
                                            <i class=\"bi bi-file-code text-primary fs-4\"></i>
                                        {% elseif file.fileType == 'json' %}
                                            <i class=\"bi bi-file-code-fill text-success fs-4\"></i>
                                        {% elseif file.fileType == 'rvt' %}
                                            <i class=\"bi bi-file-earmark-binary text-info fs-4\"></i>
                                        {% else %}
                                            <i class=\"bi bi-file-earmark text-secondary fs-4\"></i>
                                        {% endif %}
                                    </td>
                                    <td>
                                        <strong>{{ file.originalFilename }}</strong>
                                        <br>
                                        <small class=\"text-muted\">{{ file.storedFilename }}</small>
                                    </td>
                                    <td>
                                        <span class=\"badge bg-secondary\">{{ file.fileType|upper }}</span>
                                    </td>
                                    <td>{{ file.fileSizeFormatted }}</td>
                                    <td>
                                        {% if file.status == 'completed' %}
                                            <span class=\"badge bg-success\">
                                                <i class=\"bi bi-check-circle\"></i> Completado
                                            </span>
                                        {% elseif file.status == 'processing' %}
                                            <span class=\"badge bg-warning text-dark\">
                                                <i class=\"bi bi-arrow-repeat\"></i> Procesando
                                            </span>
                                        {% elseif file.status == 'pending' %}
                                            <span class=\"badge bg-info text-dark\">
                                                <i class=\"bi bi-hourglass-split\"></i> Pendiente
                                            </span>
                                        {% elseif file.status == 'error' %}
                                            <span class=\"badge bg-danger\">
                                                <i class=\"bi bi-exclamation-triangle\"></i> Error
                                            </span>
                                        {% endif %}
                                    </td>
                                    <td>
                                        <small>{{ file.uploadedAt|date('d/m/Y H:i') }}</small>
                                    </td>
                                    <td class=\"text-end\">
                                        <div class=\"btn-group btn-group-sm\" role=\"group\">
                                            <a href=\"{{ path('app_revit_file_detail', {id: file.id}) }}\"
                                               class=\"btn btn-outline-primary\"
                                               title=\"Ver detalles\">
                                                <i class=\"bi bi-eye\"></i>
                                            </a>
                                            {% if file.status == 'error' %}
                                                <form method=\"POST\"
                                                      action=\"{{ path('app_revit_file_reprocess', {id: file.id}) }}\"
                                                      style=\"display: inline;\">
                                                    <button type=\"submit\"
                                                            class=\"btn btn-outline-warning\"
                                                            title=\"Reprocesar\">
                                                        <i class=\"bi bi-arrow-clockwise\"></i>
                                                    </button>
                                                </form>
                                            {% endif %}
                                            <form method=\"POST\"
                                                  action=\"{{ path('app_revit_file_delete', {id: file.id}) }}\"
                                                  onsubmit=\"return confirm('¿Está seguro de eliminar este archivo?')\"
                                                  style=\"display: inline;\">
                                                <button type=\"submit\"
                                                        class=\"btn btn-outline-danger\"
                                                        title=\"Eliminar\">
                                                    <i class=\"bi bi-trash\"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class=\"mt-3\">
            <div class=\"row\">
                <div class=\"col-md-3\">
                    <div class=\"card text-center\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title\">{{ files|length }}</h5>
                            <p class=\"card-text text-muted\">Total Archivos</p>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"card text-center\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title text-success\">
                                {{ files|filter(f => f.status == 'completed')|length }}
                            </h5>
                            <p class=\"card-text text-muted\">Completados</p>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"card text-center\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title text-warning\">
                                {{ files|filter(f => f.status == 'processing' or f.status == 'pending')|length }}
                            </h5>
                            <p class=\"card-text text-muted\">En Proceso</p>
                        </div>
                    </div>
                </div>
                <div class=\"col-md-3\">
                    <div class=\"card text-center\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title text-danger\">
                                {{ files|filter(f => f.status == 'error')|length }}
                            </h5>
                            <p class=\"card-text text-muted\">Con Errores</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {% endif %}
</div>
{% endblock %}
", "revit/files.html.twig", "/var/www/html/proyecto/templates/revit/files.html.twig");
    }
}
