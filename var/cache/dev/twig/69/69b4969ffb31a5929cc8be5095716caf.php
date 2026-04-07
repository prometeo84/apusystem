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

/* admin/logs.html.twig */
class __TwigTemplate_e3e66c9787df7fa236cfce2590a85787 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/logs.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/logs.html.twig"));

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

        yield "Logs de Seguridad - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => "Logs de Seguridad"]));
        // line 11
        yield "
        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <div class=\"row align-items-center\">
                        <div class=\"col\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-file-text\"></i> Eventos de Seguridad</h5>
                        </div>
                        <div class=\"col-auto\">
                            <div class=\"btn-group\">
                                <button type=\"button\" class=\"btn btn-sm btn-outline-secondary active\" data-filter=\"all\">
                                    Todos
                                </button>
                                <button type=\"button\" class=\"btn btn-sm btn-outline-success\" data-filter=\"INFO\">
                                    Info
                                </button>
                                <button type=\"button\" class=\"btn btn-sm btn-outline-warning\" data-filter=\"WARNING\">
                                    Advertencias
                                </button>
                                <button type=\"button\" class=\"btn btn-sm btn-outline-danger\" data-filter=\"CRITICAL\">
                                    Críticos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=\"card-body p-0\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-hover mb-0\" id=\"logsTable\">
                            <thead class=\"table-light\">
                                <tr>
                                    <th style=\"width: 150px;\">Fecha/Hora</th>
                                    <th>Usuario</th>
                                    <th>Evento</th>
                                    <th>IP</th>
                                    <th>Navegador</th>
                                    <th style=\"width: 100px;\">Severidad</th>
                                    <th style=\"width: 60px;\">Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 52
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["securityEvents"]) || array_key_exists("securityEvents", $context) ? $context["securityEvents"] : (function () { throw new RuntimeError('Variable "securityEvents" does not exist.', 52, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
            // line 53
            yield "                                    <tr data-severity=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "severity", [], "any", false, false, false, 53), "html", null, true);
            yield "\">
                                        <td>
                                            <small>";
            // line 55
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "createdAt", [], "any", false, false, false, 55), "d/m/Y"), "html", null, true);
            yield "</small><br>
                                            <small class=\"text-muted\">";
            // line 56
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "createdAt", [], "any", false, false, false, 56), "H:i:s"), "html", null, true);
            yield "</small>
                                        </td>
                                        <td>
                                            ";
            // line 59
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["event"], "user", [], "any", false, false, false, 59)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 60
                yield "                                                <strong>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "user", [], "any", false, false, false, 60), "firstName", [], "any", false, false, false, 60), "html", null, true);
                yield " ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "user", [], "any", false, false, false, 60), "lastName", [], "any", false, false, false, 60), "html", null, true);
                yield "</strong><br>
                                                <small class=\"text-muted\">";
                // line 61
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "user", [], "any", false, false, false, 61), "email", [], "any", false, false, false, 61), "html", null, true);
                yield "</small>
                                            ";
            } else {
                // line 63
                yield "                                                <span class=\"text-muted\">-</span>
                                            ";
            }
            // line 65
            yield "                                        </td>
                                        <td>
                                            <span class=\"badge bg-secondary\">
                                                ";
            // line 68
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "eventType", [], "any", false, false, false, 68), ["_" => " "])), "html", null, true);
            yield "
                                            </span>
                                        </td>
                                        <td>
                                            <code>";
            // line 72
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "ipAddress", [], "any", false, false, false, 72), "html", null, true);
            yield "</code>
                                        </td>
                                        <td>
                                            <small class=\"text-muted\">
                                                ";
            // line 76
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::slice($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["event"], "userAgent", [], "any", false, false, false, 76), 0, 40), "html", null, true);
            yield "...
                                            </small>
                                        </td>
                                        <td>
                                            <span class=\"badge bg-";
            // line 80
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["event"], "severity", [], "any", false, false, false, 80) == "CRITICAL")) ? ("danger") : ((((CoreExtension::getAttribute($this->env, $this->source, $context["event"], "severity", [], "any", false, false, false, 80) == "WARNING")) ? ("warning") : ("info"))));
            yield "\">
                                                ";
            // line 81
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "severity", [], "any", false, false, false, 81), "html", null, true);
            yield "
                                            </span>
                                        </td>
                                        <td>
                                            ";
            // line 85
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["event"], "eventData", [], "any", false, false, false, 85)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 86
                yield "                                                <button type=\"button\" class=\"btn btn-sm btn-outline-secondary\"
                                                        data-bs-toggle=\"modal\"
                                                        data-bs-target=\"#detailsModal";
                // line 88
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "id", [], "any", false, false, false, 88), "html", null, true);
                yield "\">
                                                    <i class=\"bi bi-eye\"></i>
                                                </button>
                                            ";
            }
            // line 92
            yield "                                        </td>
                                    </tr>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['event'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 95
        yield "                            </tbody>
                        </table>
                    </div>
                </div>
                <div class=\"card-footer bg-white\">
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <small class=\"text-muted\">
                            Mostrando ";
        // line 102
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), (isset($context["securityEvents"]) || array_key_exists("securityEvents", $context) ? $context["securityEvents"] : (function () { throw new RuntimeError('Variable "securityEvents" does not exist.', 102, $this->source); })())), "html", null, true);
        yield " eventos
                        </small>
                        <nav>
                            <ul class=\"pagination pagination-sm mb-0\">
                                <li class=\"page-item disabled\">
                                    <span class=\"page-link\">Anterior</span>
                                </li>
                                <li class=\"page-item active\"><a class=\"page-link\" href=\"#\">1</a></li>
                                <li class=\"page-item\"><a class=\"page-link\" href=\"#\">2</a></li>
                                <li class=\"page-item\"><a class=\"page-link\" href=\"#\">3</a></li>
                                <li class=\"page-item\">
                                    <a class=\"page-link\" href=\"#\">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales de detalles -->
";
        // line 125
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["securityEvents"]) || array_key_exists("securityEvents", $context) ? $context["securityEvents"] : (function () { throw new RuntimeError('Variable "securityEvents" does not exist.', 125, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
            // line 126
            yield "    ";
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["event"], "eventData", [], "any", false, false, false, 126)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 127
                yield "        <div class=\"modal fade\" id=\"detailsModal";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "id", [], "any", false, false, false, 127), "html", null, true);
                yield "\" tabindex=\"-1\">
            <div class=\"modal-dialog modal-lg\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\">Detalles del Evento</h5>
                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>
                    </div>
                    <div class=\"modal-body\">
                        <dl class=\"row\">
                            <dt class=\"col-sm-3\">Fecha/Hora:</dt>
                            <dd class=\"col-sm-9\">";
                // line 137
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "createdAt", [], "any", false, false, false, 137), "d/m/Y H:i:s"), "html", null, true);
                yield "</dd>

                            <dt class=\"col-sm-3\">Usuario:</dt>
                            <dd class=\"col-sm-9\">
                                ";
                // line 141
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["event"], "user", [], "any", false, false, false, 141)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 142
                    yield "                                    ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["event"], "user", [], "any", false, false, false, 142), "email", [], "any", false, false, false, 142), "html", null, true);
                    yield "
                                ";
                } else {
                    // line 144
                    yield "                                    No disponible
                                ";
                }
                // line 146
                yield "                            </dd>

                            <dt class=\"col-sm-3\">Evento:</dt>
                            <dd class=\"col-sm-9\">";
                // line 149
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::titleCase($this->env->getCharset(), Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "eventType", [], "any", false, false, false, 149), ["_" => " "])), "html", null, true);
                yield "</dd>

                            <dt class=\"col-sm-3\">IP:</dt>
                            <dd class=\"col-sm-9\"><code>";
                // line 152
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "ipAddress", [], "any", false, false, false, 152), "html", null, true);
                yield "</code></dd>

                            <dt class=\"col-sm-3\">Navegador:</dt>
                            <dd class=\"col-sm-9\"><small>";
                // line 155
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "userAgent", [], "any", false, false, false, 155), "html", null, true);
                yield "</small></dd>

                            <dt class=\"col-sm-3\">Severidad:</dt>
                            <dd class=\"col-sm-9\">
                                <span class=\"badge bg-";
                // line 159
                yield (((CoreExtension::getAttribute($this->env, $this->source, $context["event"], "severity", [], "any", false, false, false, 159) == "CRITICAL")) ? ("danger") : ((((CoreExtension::getAttribute($this->env, $this->source, $context["event"], "severity", [], "any", false, false, false, 159) == "WARNING")) ? ("warning") : ("info"))));
                yield "\">
                                    ";
                // line 160
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "severity", [], "any", false, false, false, 160), "html", null, true);
                yield "
                                </span>
                            </dd>

                            <dt class=\"col-sm-3\">Detalles:</dt>
                            <dd class=\"col-sm-9\">
                                <pre class=\"bg-light p-2 rounded\"><code>";
                // line 166
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(json_encode(CoreExtension::getAttribute($this->env, $this->source, $context["event"], "eventData", [], "any", false, false, false, 166), Twig\Extension\CoreExtension::constant("JSON_PRETTY_PRINT")), "html", null, true);
                yield "</code></pre>
                            </dd>
                        </dl>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    ";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['event'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 178
        yield "
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtros de severidad
    const filterButtons = document.querySelectorAll('[data-filter]');
    const rows = document.querySelectorAll('#logsTable tbody tr');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.dataset.filter;

            // Actualizar botones activos
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Filtrar filas
            rows.forEach(row => {
                if (filter === 'all' || row.dataset.severity === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // DataTables si está disponible
    if (typeof \$ !== 'undefined' && \$.fn.DataTable) {
        \$('#logsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            order: [[0, 'desc']],
            pageLength: 50
        });
    }
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
        return "admin/logs.html.twig";
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
        return array (  380 => 178,  362 => 166,  353 => 160,  349 => 159,  342 => 155,  336 => 152,  330 => 149,  325 => 146,  321 => 144,  315 => 142,  313 => 141,  306 => 137,  292 => 127,  289 => 126,  285 => 125,  259 => 102,  250 => 95,  242 => 92,  235 => 88,  231 => 86,  229 => 85,  222 => 81,  218 => 80,  211 => 76,  204 => 72,  197 => 68,  192 => 65,  188 => 63,  183 => 61,  176 => 60,  174 => 59,  168 => 56,  164 => 55,  158 => 53,  154 => 52,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Logs de Seguridad - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'Logs de Seguridad'} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"card\">
                <div class=\"card-header\">
                    <div class=\"row align-items-center\">
                        <div class=\"col\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-file-text\"></i> Eventos de Seguridad</h5>
                        </div>
                        <div class=\"col-auto\">
                            <div class=\"btn-group\">
                                <button type=\"button\" class=\"btn btn-sm btn-outline-secondary active\" data-filter=\"all\">
                                    Todos
                                </button>
                                <button type=\"button\" class=\"btn btn-sm btn-outline-success\" data-filter=\"INFO\">
                                    Info
                                </button>
                                <button type=\"button\" class=\"btn btn-sm btn-outline-warning\" data-filter=\"WARNING\">
                                    Advertencias
                                </button>
                                <button type=\"button\" class=\"btn btn-sm btn-outline-danger\" data-filter=\"CRITICAL\">
                                    Críticos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=\"card-body p-0\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-hover mb-0\" id=\"logsTable\">
                            <thead class=\"table-light\">
                                <tr>
                                    <th style=\"width: 150px;\">Fecha/Hora</th>
                                    <th>Usuario</th>
                                    <th>Evento</th>
                                    <th>IP</th>
                                    <th>Navegador</th>
                                    <th style=\"width: 100px;\">Severidad</th>
                                    <th style=\"width: 60px;\">Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for event in securityEvents %}
                                    <tr data-severity=\"{{ event.severity }}\">
                                        <td>
                                            <small>{{ event.createdAt|date('d/m/Y') }}</small><br>
                                            <small class=\"text-muted\">{{ event.createdAt|date('H:i:s') }}</small>
                                        </td>
                                        <td>
                                            {% if event.user %}
                                                <strong>{{ event.user.firstName }} {{ event.user.lastName }}</strong><br>
                                                <small class=\"text-muted\">{{ event.user.email }}</small>
                                            {% else %}
                                                <span class=\"text-muted\">-</span>
                                            {% endif %}
                                        </td>
                                        <td>
                                            <span class=\"badge bg-secondary\">
                                                {{ event.eventType|replace({'_': ' '})|title }}
                                            </span>
                                        </td>
                                        <td>
                                            <code>{{ event.ipAddress }}</code>
                                        </td>
                                        <td>
                                            <small class=\"text-muted\">
                                                {{ event.userAgent|slice(0, 40) }}...
                                            </small>
                                        </td>
                                        <td>
                                            <span class=\"badge bg-{{ event.severity == 'CRITICAL' ? 'danger' : (event.severity == 'WARNING' ? 'warning' : 'info') }}\">
                                                {{ event.severity }}
                                            </span>
                                        </td>
                                        <td>
                                            {% if event.eventData %}
                                                <button type=\"button\" class=\"btn btn-sm btn-outline-secondary\"
                                                        data-bs-toggle=\"modal\"
                                                        data-bs-target=\"#detailsModal{{ event.id }}\">
                                                    <i class=\"bi bi-eye\"></i>
                                                </button>
                                            {% endif %}
                                        </td>
                                    </tr>
                                {% endfor %}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class=\"card-footer bg-white\">
                    <div class=\"d-flex justify-content-between align-items-center\">
                        <small class=\"text-muted\">
                            Mostrando {{ securityEvents|length }} eventos
                        </small>
                        <nav>
                            <ul class=\"pagination pagination-sm mb-0\">
                                <li class=\"page-item disabled\">
                                    <span class=\"page-link\">Anterior</span>
                                </li>
                                <li class=\"page-item active\"><a class=\"page-link\" href=\"#\">1</a></li>
                                <li class=\"page-item\"><a class=\"page-link\" href=\"#\">2</a></li>
                                <li class=\"page-item\"><a class=\"page-link\" href=\"#\">3</a></li>
                                <li class=\"page-item\">
                                    <a class=\"page-link\" href=\"#\">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales de detalles -->
{% for event in securityEvents %}
    {% if event.eventData %}
        <div class=\"modal fade\" id=\"detailsModal{{ event.id }}\" tabindex=\"-1\">
            <div class=\"modal-dialog modal-lg\">
                <div class=\"modal-content\">
                    <div class=\"modal-header\">
                        <h5 class=\"modal-title\">Detalles del Evento</h5>
                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>
                    </div>
                    <div class=\"modal-body\">
                        <dl class=\"row\">
                            <dt class=\"col-sm-3\">Fecha/Hora:</dt>
                            <dd class=\"col-sm-9\">{{ event.createdAt|date('d/m/Y H:i:s') }}</dd>

                            <dt class=\"col-sm-3\">Usuario:</dt>
                            <dd class=\"col-sm-9\">
                                {% if event.user %}
                                    {{ event.user.email }}
                                {% else %}
                                    No disponible
                                {% endif %}
                            </dd>

                            <dt class=\"col-sm-3\">Evento:</dt>
                            <dd class=\"col-sm-9\">{{ event.eventType|replace({'_': ' '})|title }}</dd>

                            <dt class=\"col-sm-3\">IP:</dt>
                            <dd class=\"col-sm-9\"><code>{{ event.ipAddress }}</code></dd>

                            <dt class=\"col-sm-3\">Navegador:</dt>
                            <dd class=\"col-sm-9\"><small>{{ event.userAgent }}</small></dd>

                            <dt class=\"col-sm-3\">Severidad:</dt>
                            <dd class=\"col-sm-9\">
                                <span class=\"badge bg-{{ event.severity == 'CRITICAL' ? 'danger' : (event.severity == 'WARNING' ? 'warning' : 'info') }}\">
                                    {{ event.severity }}
                                </span>
                            </dd>

                            <dt class=\"col-sm-3\">Detalles:</dt>
                            <dd class=\"col-sm-9\">
                                <pre class=\"bg-light p-2 rounded\"><code>{{ event.eventData|json_encode(constant('JSON_PRETTY_PRINT')) }}</code></pre>
                            </dd>
                        </dl>
                    </div>
                    <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    {% endif %}
{% endfor %}

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtros de severidad
    const filterButtons = document.querySelectorAll('[data-filter]');
    const rows = document.querySelectorAll('#logsTable tbody tr');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.dataset.filter;

            // Actualizar botones activos
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Filtrar filas
            rows.forEach(row => {
                if (filter === 'all' || row.dataset.severity === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // DataTables si está disponible
    if (typeof \$ !== 'undefined' && \$.fn.DataTable) {
        \$('#logsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            order: [[0, 'desc']],
            pageLength: 50
        });
    }
});
</script>
{% endblock %}
", "admin/logs.html.twig", "/var/www/html/proyecto/templates/admin/logs.html.twig");
    }
}
