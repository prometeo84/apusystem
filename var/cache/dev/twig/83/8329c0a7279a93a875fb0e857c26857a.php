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

/* revit/file_detail.html.twig */
class __TwigTemplate_71102663b612c67e002b2dc03ee9bfb3 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "revit/file_detail.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "revit/file_detail.html.twig"));

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

        yield "Detalles - ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 3, $this->source); })()), "originalFilename", [], "any", false, false, false, 3), "html", null, true);
        
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
    <nav aria-label=\"breadcrumb\">
        <ol class=\"breadcrumb\">
            <li class=\"breadcrumb-item\"><a href=\"";
        // line 9
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_revit_files");
        yield "\">Archivos Revit</a></li>
            <li class=\"breadcrumb-item active\">";
        // line 10
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 10, $this->source); })()), "originalFilename", [], "any", false, false, false, 10), "html", null, true);
        yield "</li>
        </ol>
    </nav>

    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1><i class=\"bi bi-file-earmark-text\"></i> ";
        // line 15
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 15, $this->source); })()), "originalFilename", [], "any", false, false, false, 15), "html", null, true);
        yield "</h1>
        <div class=\"btn-group\" role=\"group\">
            ";
        // line 17
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 17, $this->source); })()), "status", [], "any", false, false, false, 17) == "error")) {
            // line 18
            yield "                <form method=\"POST\" action=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_revit_file_reprocess", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 18, $this->source); })()), "id", [], "any", false, false, false, 18)]), "html", null, true);
            yield "\" style=\"display: inline;\">
                    <button type=\"submit\" class=\"btn btn-warning\">
                        <i class=\"bi bi-arrow-clockwise\"></i> Reprocesar
                    </button>
                </form>
            ";
        }
        // line 24
        yield "            <form method=\"POST\"
                  action=\"";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_revit_file_delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 25, $this->source); })()), "id", [], "any", false, false, false, 25)]), "html", null, true);
        yield "\"
                  onsubmit=\"return confirm('¿Está seguro de eliminar este archivo?')\"
                  style=\"display: inline;\">
                <button type=\"submit\" class=\"btn btn-danger\">
                    <i class=\"bi bi-trash\"></i> Eliminar
                </button>
            </form>
        </div>
    </div>

    ";
        // line 35
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 35, $this->source); })()), "flashes", ["error"], "method", false, false, false, 35));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 36
            yield "        <div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
            <i class=\"bi bi-exclamation-triangle\"></i> ";
            // line 37
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "
            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
        </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 41
        yield "
    ";
        // line 42
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 42, $this->source); })()), "flashes", ["success"], "method", false, false, false, 42));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 43
            yield "        <div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
            <i class=\"bi bi-check-circle\"></i> ";
            // line 44
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "
            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
        </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 48
        yield "
    <div class=\"row\">
        <div class=\"col-md-4\">
            <div class=\"card mb-3\">
                <div class=\"card-header\">
                    <i class=\"bi bi-info-circle\"></i> Información General
                </div>
                <ul class=\"list-group list-group-flush\">
                    <li class=\"list-group-item\">
                        <strong>Tipo:</strong>
                        <span class=\"badge bg-secondary float-end\">";
        // line 58
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 58, $this->source); })()), "fileType", [], "any", false, false, false, 58)), "html", null, true);
        yield "</span>
                    </li>
                    <li class=\"list-group-item\">
                        <strong>Tamaño:</strong>
                        <span class=\"float-end\">";
        // line 62
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 62, $this->source); })()), "fileSizeFormatted", [], "any", false, false, false, 62), "html", null, true);
        yield "</span>
                    </li>
                    <li class=\"list-group-item\">
                        <strong>Estado:</strong>
                        <span class=\"float-end\">
                            ";
        // line 67
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 67, $this->source); })()), "status", [], "any", false, false, false, 67) == "completed")) {
            // line 68
            yield "                                <span class=\"badge bg-success\">Completado</span>
                            ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 69
(isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 69, $this->source); })()), "status", [], "any", false, false, false, 69) == "processing")) {
            // line 70
            yield "                                <span class=\"badge bg-warning text-dark\">Procesando</span>
                            ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 71
(isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 71, $this->source); })()), "status", [], "any", false, false, false, 71) == "pending")) {
            // line 72
            yield "                                <span class=\"badge bg-info text-dark\">Pendiente</span>
                            ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 73
(isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 73, $this->source); })()), "status", [], "any", false, false, false, 73) == "error")) {
            // line 74
            yield "                                <span class=\"badge bg-danger\">Error</span>
                            ";
        }
        // line 76
        yield "                        </span>
                    </li>
                    <li class=\"list-group-item\">
                        <strong>Hash (SHA-256):</strong>
                        <br>
                        <code class=\"small\">";
        // line 81
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 81, $this->source); })()), "fileHash", [], "any", false, false, false, 81), "html", null, true);
        yield "</code>
                    </li>
                    <li class=\"list-group-item\">
                        <strong>Subido por:</strong>
                        <span class=\"float-end\">";
        // line 85
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 85, $this->source); })()), "uploadedBy", [], "any", false, false, false, 85), "username", [], "any", false, false, false, 85), "html", null, true);
        yield "</span>
                    </li>
                    <li class=\"list-group-item\">
                        <strong>Fecha de subida:</strong>
                        <span class=\"float-end\">";
        // line 89
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 89, $this->source); })()), "uploadedAt", [], "any", false, false, false, 89), "d/m/Y H:i:s"), "html", null, true);
        yield "</span>
                    </li>
                    ";
        // line 91
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 91, $this->source); })()), "processedAt", [], "any", false, false, false, 91)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 92
            yield "                        <li class=\"list-group-item\">
                            <strong>Procesado:</strong>
                            <span class=\"float-end\">";
            // line 94
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 94, $this->source); })()), "processedAt", [], "any", false, false, false, 94), "d/m/Y H:i:s"), "html", null, true);
            yield "</span>
                        </li>
                    ";
        }
        // line 97
        yield "                </ul>
            </div>

            ";
        // line 100
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 100, $this->source); })()), "metadata", [], "any", false, false, false, 100)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 101
            yield "                <div class=\"card mb-3\">
                    <div class=\"card-header\">
                        <i class=\"bi bi-database\"></i> Metadatos
                    </div>
                    <div class=\"card-body\">
                        ";
            // line 106
            if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["file"] ?? null), "metadata", [], "any", false, true, false, 106), "project_name", [], "any", true, true, false, 106)) {
                // line 107
                yield "                            <p><strong>Proyecto:</strong> ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 107, $this->source); })()), "metadata", [], "any", false, false, false, 107), "project_name", [], "any", false, false, false, 107), "html", null, true);
                yield "</p>
                        ";
            }
            // line 109
            yield "                        ";
            if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["file"] ?? null), "metadata", [], "any", false, true, false, 109), "version", [], "any", true, true, false, 109)) {
                // line 110
                yield "                            <p><strong>Versión:</strong> ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 110, $this->source); })()), "metadata", [], "any", false, false, false, 110), "version", [], "any", false, false, false, 110), "html", null, true);
                yield "</p>
                        ";
            }
            // line 112
            yield "                        ";
            if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["file"] ?? null), "metadata", [], "any", false, true, false, 112), "elements_count", [], "any", true, true, false, 112)) {
                // line 113
                yield "                            <p><strong>Elementos:</strong> ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 113, $this->source); })()), "metadata", [], "any", false, false, false, 113), "elements_count", [], "any", false, false, false, 113), "html", null, true);
                yield "</p>
                        ";
            }
            // line 115
            yield "                        ";
            if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["file"] ?? null), "metadata", [], "any", false, true, false, 115), "categories", [], "any", true, true, false, 115)) {
                // line 116
                yield "                            <p><strong>Categorías:</strong></p>
                            <ul>
                                ";
                // line 118
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 118, $this->source); })()), "metadata", [], "any", false, false, false, 118), "categories", [], "any", false, false, false, 118));
                foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
                    // line 119
                    yield "                                    <li>";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["category"], "html", null, true);
                    yield "</li>
                                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['category'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 121
                yield "                            </ul>
                        ";
            }
            // line 123
            yield "                    </div>
                </div>
            ";
        }
        // line 126
        yield "        </div>

        <div class=\"col-md-8\">
            ";
        // line 129
        if (((CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 129, $this->source); })()), "status", [], "any", false, false, false, 129) == "error") && CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 129, $this->source); })()), "errorMessage", [], "any", false, false, false, 129))) {
            // line 130
            yield "                <div class=\"alert alert-danger\">
                    <h5><i class=\"bi bi-exclamation-triangle\"></i> Error de Procesamiento</h5>
                    <p class=\"mb-0\">";
            // line 132
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 132, $this->source); })()), "errorMessage", [], "any", false, false, false, 132), "html", null, true);
            yield "</p>
                </div>
            ";
        }
        // line 135
        yield "
            ";
        // line 136
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 136, $this->source); })()), "processingResult", [], "any", false, false, false, 136)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 137
            yield "                <div class=\"card mb-3\">
                    <div class=\"card-header\">
                        <i class=\"bi bi-clipboard-check\"></i> Resultado del Procesamiento
                    </div>
                    <div class=\"card-body\">
                        ";
            // line 142
            if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["file"] ?? null), "processingResult", [], "any", false, true, false, 142), "created", [], "any", true, true, false, 142)) {
                // line 143
                yield "                            <div class=\"row text-center mb-3\">
                                <div class=\"col-md-4\">
                                    <div class=\"card bg-success text-white\">
                                        <div class=\"card-body\">
                                            <h3>";
                // line 147
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 147, $this->source); })()), "processingResult", [], "any", false, false, false, 147), "created", [], "any", false, false, false, 147), "html", null, true);
                yield "</h3>
                                            <p class=\"mb-0\">APUs Creados</p>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"col-md-4\">
                                    <div class=\"card bg-warning text-dark\">
                                        <div class=\"card-body\">
                                            <h3>";
                // line 155
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["file"] ?? null), "processingResult", [], "any", false, true, false, 155), "skipped", [], "any", true, true, false, 155)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 155, $this->source); })()), "processingResult", [], "any", false, false, false, 155), "skipped", [], "any", false, false, false, 155), 0)) : (0)), "html", null, true);
                yield "</h3>
                                            <p class=\"mb-0\">Elementos Omitidos</p>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"col-md-4\">
                                    <div class=\"card bg-info text-white\">
                                        <div class=\"card-body\">
                                            <h3>";
                // line 163
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["file"] ?? null), "processingResult", [], "any", false, true, false, 163), "total", [], "any", true, true, false, 163)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 163, $this->source); })()), "processingResult", [], "any", false, false, false, 163), "total", [], "any", false, false, false, 163), 0)) : (0)), "html", null, true);
                yield "</h3>
                                            <p class=\"mb-0\">Total Procesados</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ";
            }
            // line 170
            yield "
                        ";
            // line 171
            if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["file"] ?? null), "processingResult", [], "any", false, true, false, 171), "elements", [], "any", true, true, false, 171)) {
                // line 172
                yield "                            <h5>Elementos Procesados</h5>
                            <div class=\"table-responsive\">
                                <table class=\"table table-sm\">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th>Cantidad</th>
                                            <th>Unidad</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ";
                // line 185
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 185, $this->source); })()), "processingResult", [], "any", false, false, false, 185), "elements", [], "any", false, false, false, 185), 0, 50));
                foreach ($context['_seq'] as $context["_key"] => $context["element"]) {
                    // line 186
                    yield "                                            <tr>
                                                <td>";
                    // line 187
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["element"], "name", [], "any", true, true, false, 187)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["element"], "name", [], "any", false, false, false, 187), "N/A")) : ("N/A")), "html", null, true);
                    yield "</td>
                                                <td>";
                    // line 188
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["element"], "category", [], "any", true, true, false, 188)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["element"], "category", [], "any", false, false, false, 188), "N/A")) : ("N/A")), "html", null, true);
                    yield "</td>
                                                <td>";
                    // line 189
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["element"], "quantity", [], "any", true, true, false, 189)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["element"], "quantity", [], "any", false, false, false, 189), "N/A")) : ("N/A")), "html", null, true);
                    yield "</td>
                                                <td>";
                    // line 190
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["element"], "unit", [], "any", true, true, false, 190)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["element"], "unit", [], "any", false, false, false, 190), "N/A")) : ("N/A")), "html", null, true);
                    yield "</td>
                                                <td>
                                                    ";
                    // line 192
                    if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["element"], "created", [], "any", false, false, false, 192)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        // line 193
                        yield "                                                        <span class=\"badge bg-success\">Creado</span>
                                                    ";
                    } else {
                        // line 195
                        yield "                                                        <span class=\"badge bg-warning text-dark\">Omitido</span>
                                                    ";
                    }
                    // line 197
                    yield "                                                </td>
                                            </tr>
                                        ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['element'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 200
                yield "                                    </tbody>
                                </table>
                            </div>
                            ";
                // line 203
                if ((Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 203, $this->source); })()), "processingResult", [], "any", false, false, false, 203), "elements", [], "any", false, false, false, 203)) > 50)) {
                    // line 204
                    yield "                                <p class=\"text-muted small\">
                                    Mostrando 50 de ";
                    // line 205
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 205, $this->source); })()), "processingResult", [], "any", false, false, false, 205), "elements", [], "any", false, false, false, 205)), "html", null, true);
                    yield " elementos
                                </p>
                            ";
                }
                // line 208
                yield "                        ";
            }
            // line 209
            yield "                    </div>
                </div>
            ";
        }
        // line 212
        yield "
            ";
        // line 213
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 213, $this->source); })()), "status", [], "any", false, false, false, 213) == "pending")) {
            // line 214
            yield "                <div class=\"alert alert-info\">
                    <i class=\"bi bi-hourglass-split\"></i> Este archivo está pendiente de procesamiento.
                    El procesamiento se iniciará automáticamente en breve.
                </div>
            ";
        }
        // line 219
        yield "
            ";
        // line 220
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 220, $this->source); })()), "status", [], "any", false, false, false, 220) == "processing")) {
            // line 221
            yield "                <div class=\"alert alert-warning\">
                    <i class=\"bi bi-arrow-repeat\"></i> Este archivo se está procesando actualmente.
                    Actualice la página para ver el progreso.
                </div>
            ";
        }
        // line 226
        yield "
            <div class=\"card\">
                <div class=\"card-header\">
                    <i class=\"bi bi-code-square\"></i> Información Técnica
                </div>
                <div class=\"card-body\">
                    <p><strong>Nombre almacenado:</strong> <code>";
        // line 232
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 232, $this->source); })()), "storedFilename", [], "any", false, false, false, 232), "html", null, true);
        yield "</code></p>
                    <p><strong>Ruta:</strong> <code>";
        // line 233
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 233, $this->source); })()), "filePath", [], "any", false, false, false, 233), "html", null, true);
        yield "</code></p>
                    <p class=\"mb-0\"><strong>ID del archivo:</strong> <code>";
        // line 234
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["file"]) || array_key_exists("file", $context) ? $context["file"] : (function () { throw new RuntimeError('Variable "file" does not exist.', 234, $this->source); })()), "id", [], "any", false, false, false, 234), "html", null, true);
        yield "</code></p>
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
        return "revit/file_detail.html.twig";
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
        return array (  538 => 234,  534 => 233,  530 => 232,  522 => 226,  515 => 221,  513 => 220,  510 => 219,  503 => 214,  501 => 213,  498 => 212,  493 => 209,  490 => 208,  484 => 205,  481 => 204,  479 => 203,  474 => 200,  466 => 197,  462 => 195,  458 => 193,  456 => 192,  451 => 190,  447 => 189,  443 => 188,  439 => 187,  436 => 186,  432 => 185,  417 => 172,  415 => 171,  412 => 170,  402 => 163,  391 => 155,  380 => 147,  374 => 143,  372 => 142,  365 => 137,  363 => 136,  360 => 135,  354 => 132,  350 => 130,  348 => 129,  343 => 126,  338 => 123,  334 => 121,  325 => 119,  321 => 118,  317 => 116,  314 => 115,  308 => 113,  305 => 112,  299 => 110,  296 => 109,  290 => 107,  288 => 106,  281 => 101,  279 => 100,  274 => 97,  268 => 94,  264 => 92,  262 => 91,  257 => 89,  250 => 85,  243 => 81,  236 => 76,  232 => 74,  230 => 73,  227 => 72,  225 => 71,  222 => 70,  220 => 69,  217 => 68,  215 => 67,  207 => 62,  200 => 58,  188 => 48,  178 => 44,  175 => 43,  171 => 42,  168 => 41,  158 => 37,  155 => 36,  151 => 35,  138 => 25,  135 => 24,  125 => 18,  123 => 17,  118 => 15,  110 => 10,  106 => 9,  101 => 6,  88 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Detalles - {{ file.originalFilename }}{% endblock %}

{% block body %}
<div class=\"container mt-4\">
    <nav aria-label=\"breadcrumb\">
        <ol class=\"breadcrumb\">
            <li class=\"breadcrumb-item\"><a href=\"{{ path('app_revit_files') }}\">Archivos Revit</a></li>
            <li class=\"breadcrumb-item active\">{{ file.originalFilename }}</li>
        </ol>
    </nav>

    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1><i class=\"bi bi-file-earmark-text\"></i> {{ file.originalFilename }}</h1>
        <div class=\"btn-group\" role=\"group\">
            {% if file.status == 'error' %}
                <form method=\"POST\" action=\"{{ path('app_revit_file_reprocess', {id: file.id}) }}\" style=\"display: inline;\">
                    <button type=\"submit\" class=\"btn btn-warning\">
                        <i class=\"bi bi-arrow-clockwise\"></i> Reprocesar
                    </button>
                </form>
            {% endif %}
            <form method=\"POST\"
                  action=\"{{ path('app_revit_file_delete', {id: file.id}) }}\"
                  onsubmit=\"return confirm('¿Está seguro de eliminar este archivo?')\"
                  style=\"display: inline;\">
                <button type=\"submit\" class=\"btn btn-danger\">
                    <i class=\"bi bi-trash\"></i> Eliminar
                </button>
            </form>
        </div>
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

    <div class=\"row\">
        <div class=\"col-md-4\">
            <div class=\"card mb-3\">
                <div class=\"card-header\">
                    <i class=\"bi bi-info-circle\"></i> Información General
                </div>
                <ul class=\"list-group list-group-flush\">
                    <li class=\"list-group-item\">
                        <strong>Tipo:</strong>
                        <span class=\"badge bg-secondary float-end\">{{ file.fileType|upper }}</span>
                    </li>
                    <li class=\"list-group-item\">
                        <strong>Tamaño:</strong>
                        <span class=\"float-end\">{{ file.fileSizeFormatted }}</span>
                    </li>
                    <li class=\"list-group-item\">
                        <strong>Estado:</strong>
                        <span class=\"float-end\">
                            {% if file.status == 'completed' %}
                                <span class=\"badge bg-success\">Completado</span>
                            {% elseif file.status == 'processing' %}
                                <span class=\"badge bg-warning text-dark\">Procesando</span>
                            {% elseif file.status == 'pending' %}
                                <span class=\"badge bg-info text-dark\">Pendiente</span>
                            {% elseif file.status == 'error' %}
                                <span class=\"badge bg-danger\">Error</span>
                            {% endif %}
                        </span>
                    </li>
                    <li class=\"list-group-item\">
                        <strong>Hash (SHA-256):</strong>
                        <br>
                        <code class=\"small\">{{ file.fileHash }}</code>
                    </li>
                    <li class=\"list-group-item\">
                        <strong>Subido por:</strong>
                        <span class=\"float-end\">{{ file.uploadedBy.username }}</span>
                    </li>
                    <li class=\"list-group-item\">
                        <strong>Fecha de subida:</strong>
                        <span class=\"float-end\">{{ file.uploadedAt|date('d/m/Y H:i:s') }}</span>
                    </li>
                    {% if file.processedAt %}
                        <li class=\"list-group-item\">
                            <strong>Procesado:</strong>
                            <span class=\"float-end\">{{ file.processedAt|date('d/m/Y H:i:s') }}</span>
                        </li>
                    {% endif %}
                </ul>
            </div>

            {% if file.metadata %}
                <div class=\"card mb-3\">
                    <div class=\"card-header\">
                        <i class=\"bi bi-database\"></i> Metadatos
                    </div>
                    <div class=\"card-body\">
                        {% if file.metadata.project_name is defined %}
                            <p><strong>Proyecto:</strong> {{ file.metadata.project_name }}</p>
                        {% endif %}
                        {% if file.metadata.version is defined %}
                            <p><strong>Versión:</strong> {{ file.metadata.version }}</p>
                        {% endif %}
                        {% if file.metadata.elements_count is defined %}
                            <p><strong>Elementos:</strong> {{ file.metadata.elements_count }}</p>
                        {% endif %}
                        {% if file.metadata.categories is defined %}
                            <p><strong>Categorías:</strong></p>
                            <ul>
                                {% for category in file.metadata.categories %}
                                    <li>{{ category }}</li>
                                {% endfor %}
                            </ul>
                        {% endif %}
                    </div>
                </div>
            {% endif %}
        </div>

        <div class=\"col-md-8\">
            {% if file.status == 'error' and file.errorMessage %}
                <div class=\"alert alert-danger\">
                    <h5><i class=\"bi bi-exclamation-triangle\"></i> Error de Procesamiento</h5>
                    <p class=\"mb-0\">{{ file.errorMessage }}</p>
                </div>
            {% endif %}

            {% if file.processingResult %}
                <div class=\"card mb-3\">
                    <div class=\"card-header\">
                        <i class=\"bi bi-clipboard-check\"></i> Resultado del Procesamiento
                    </div>
                    <div class=\"card-body\">
                        {% if file.processingResult.created is defined %}
                            <div class=\"row text-center mb-3\">
                                <div class=\"col-md-4\">
                                    <div class=\"card bg-success text-white\">
                                        <div class=\"card-body\">
                                            <h3>{{ file.processingResult.created }}</h3>
                                            <p class=\"mb-0\">APUs Creados</p>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"col-md-4\">
                                    <div class=\"card bg-warning text-dark\">
                                        <div class=\"card-body\">
                                            <h3>{{ file.processingResult.skipped|default(0) }}</h3>
                                            <p class=\"mb-0\">Elementos Omitidos</p>
                                        </div>
                                    </div>
                                </div>
                                <div class=\"col-md-4\">
                                    <div class=\"card bg-info text-white\">
                                        <div class=\"card-body\">
                                            <h3>{{ file.processingResult.total|default(0) }}</h3>
                                            <p class=\"mb-0\">Total Procesados</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {% endif %}

                        {% if file.processingResult.elements is defined %}
                            <h5>Elementos Procesados</h5>
                            <div class=\"table-responsive\">
                                <table class=\"table table-sm\">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th>Cantidad</th>
                                            <th>Unidad</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {% for element in file.processingResult.elements|slice(0, 50) %}
                                            <tr>
                                                <td>{{ element.name|default('N/A') }}</td>
                                                <td>{{ element.category|default('N/A') }}</td>
                                                <td>{{ element.quantity|default('N/A') }}</td>
                                                <td>{{ element.unit|default('N/A') }}</td>
                                                <td>
                                                    {% if element.created %}
                                                        <span class=\"badge bg-success\">Creado</span>
                                                    {% else %}
                                                        <span class=\"badge bg-warning text-dark\">Omitido</span>
                                                    {% endif %}
                                                </td>
                                            </tr>
                                        {% endfor %}
                                    </tbody>
                                </table>
                            </div>
                            {% if file.processingResult.elements|length > 50 %}
                                <p class=\"text-muted small\">
                                    Mostrando 50 de {{ file.processingResult.elements|length }} elementos
                                </p>
                            {% endif %}
                        {% endif %}
                    </div>
                </div>
            {% endif %}

            {% if file.status == 'pending' %}
                <div class=\"alert alert-info\">
                    <i class=\"bi bi-hourglass-split\"></i> Este archivo está pendiente de procesamiento.
                    El procesamiento se iniciará automáticamente en breve.
                </div>
            {% endif %}

            {% if file.status == 'processing' %}
                <div class=\"alert alert-warning\">
                    <i class=\"bi bi-arrow-repeat\"></i> Este archivo se está procesando actualmente.
                    Actualice la página para ver el progreso.
                </div>
            {% endif %}

            <div class=\"card\">
                <div class=\"card-header\">
                    <i class=\"bi bi-code-square\"></i> Información Técnica
                </div>
                <div class=\"card-body\">
                    <p><strong>Nombre almacenado:</strong> <code>{{ file.storedFilename }}</code></p>
                    <p><strong>Ruta:</strong> <code>{{ file.filePath }}</code></p>
                    <p class=\"mb-0\"><strong>ID del archivo:</strong> <code>{{ file.id }}</code></p>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
", "revit/file_detail.html.twig", "/var/www/html/proyecto/templates/revit/file_detail.html.twig");
    }
}
