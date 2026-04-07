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

/* admin/users.html.twig */
class __TwigTemplate_aa4585b8c31960ea4be129419a3160f6 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/users.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/users.html.twig"));

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

        yield "Gestión de Usuarios - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin_users.title_page")]));
        // line 11
        yield "
        <div class=\"container-fluid p-4 content-wrapper\">
            ";
        // line 13
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 13, $this->source); })()), "flashes", ["success"], "method", false, false, false, 13));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 14
            yield "                <div class=\"alert alert-success alert-dismissible fade show\">
                    <i class=\"bi bi-check-circle-fill\"></i> ";
            // line 15
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 19
        yield "
            <div class=\"card\">
                <div class=\"card-header d-flex justify-content-between align-items-center\">
                    <h5 class=\"mb-0\"><i class=\"bi bi-people-fill\"></i> ";
        // line 22
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin_users.all_users"), "html", null, true);
        yield "</h5>
                    <a href=\"";
        // line 23
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin_users_create");
        yield "\" class=\"btn btn-primary\">
                        <i class=\"bi bi-person-plus\"></i> ";
        // line 24
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.create_user"), "html", null, true);
        yield "
                    </a>
                </div>
                <div class=\"card-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-hover\" id=\"usersTable\">
                            <thead>
                                <tr>
                                    <th>";
        // line 32
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.user"), "html", null, true);
        yield "</th>
                                    <th>Email</th>
                                    <th>";
        // line 34
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.role"), "html", null, true);
        yield "</th>
                                    <th>";
        // line 35
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.status"), "html", null, true);
        yield "</th>
                                    <th>2FA</th>
                                    <th>";
        // line 37
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.last_access"), "html", null, true);
        yield "</th>
                                    <th>";
        // line 38
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.actions"), "html", null, true);
        yield "</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 42
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["users"]) || array_key_exists("users", $context) ? $context["users"] : (function () { throw new RuntimeError('Variable "users" does not exist.', 42, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["user"]) {
            // line 43
            yield "                                    <tr>
                                        <td>
                                            <div class=\"d-flex align-items-center\">
                                                <div class=\"avatar bg-primary text-white rounded-circle me-2\"
                                                     style=\"width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;\">
                                                    ";
            // line 48
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::first($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["user"], "firstName", [], "any", false, false, false, 48)), "html", null, true);
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::first($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["user"], "lastName", [], "any", false, false, false, 48)), "html", null, true);
            yield "
                                                </div>
                                                <div>
                                                    <strong>";
            // line 51
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "firstName", [], "any", false, false, false, 51), "html", null, true);
            yield " ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "lastName", [], "any", false, false, false, 51), "html", null, true);
            yield "</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>";
            // line 55
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "email", [], "any", false, false, false, 55), "html", null, true);
            yield "</td>
                                        <td>
                                            <span class=\"badge bg-";
            // line 57
            yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["user"], "roles", [], "any", false, false, false, 57), 0, [], "array", false, false, false, 57) == "ROLE_SUPER_ADMIN")) ? ("danger") : ((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["user"], "roles", [], "any", false, false, false, 57), 0, [], "array", false, false, false, 57) == "ROLE_ADMIN")) ? ("warning") : ((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["user"], "roles", [], "any", false, false, false, 57), 0, [], "array", false, false, false, 57) == "ROLE_MANAGER")) ? ("info") : ("secondary"))))));
            yield "\">
                                                ";
            // line 58
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::capitalize($this->env->getCharset(), Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["user"], "roles", [], "any", false, false, false, 58), 0, [], "array", false, false, false, 58), ["ROLE_" => ""])), "html", null, true);
            yield "
                                            </span>
                                        </td>
                                        <td>
                                            ";
            // line 62
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["user"], "isActive", [], "any", false, false, false, 62)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 63
                yield "                                                <span class=\"badge bg-success\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.status_active"), "html", null, true);
                yield "</span>
                                            ";
            } else {
                // line 65
                yield "                                                <span class=\"badge bg-danger\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.status_inactive"), "html", null, true);
                yield "</span>
                                            ";
            }
            // line 67
            yield "                                        </td>
                                        <td>
                                            ";
            // line 69
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["user"], "totpEnabled", [], "any", false, false, false, 69)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 70
                yield "                                                <i class=\"bi bi-shield-check text-success\" title=\"2FA Habilitado\"></i>
                                            ";
            } else {
                // line 72
                yield "                                                <i class=\"bi bi-shield-x text-muted\" title=\"2FA Deshabilitado\"></i>
                                            ";
            }
            // line 74
            yield "                                        </td>
                                        <td>
                                            ";
            // line 76
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["user"], "lastLoginAt", [], "any", false, false, false, 76)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 77
                yield "                                                <small>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "lastLoginAt", [], "any", false, false, false, 77), "d/m/Y H:i"), "html", null, true);
                yield "</small>
                                            ";
            } else {
                // line 79
                yield "                                                <small class=\"text-muted\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.never"), "html", null, true);
                yield "</small>
                                            ";
            }
            // line 81
            yield "                                        </td>
                                        <td>
                                            <div class=\"btn-group btn-group-sm\">
                                                <a href=\"";
            // line 84
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin_users_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 84)]), "html", null, true);
            yield "\"
                                                   class=\"btn btn-outline-primary\" title=\"Editar\">
                                                    <i class=\"bi bi-pencil\"></i>
                                                </a>
                                                <form method=\"post\" action=\"";
            // line 88
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin_users_toggle", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["user"], "id", [], "any", false, false, false, 88)]), "html", null, true);
            yield "\"
                                                      style=\"display: inline;\">
                                                    <button type=\"submit\"
                                                            class=\"btn btn-outline-";
            // line 91
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["user"], "isActive", [], "any", false, false, false, 91)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("warning") : ("success"));
            yield "\"
                                                            title=\"";
            // line 92
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["user"], "isActive", [], "any", false, false, false, 92)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Desactivar") : ("Activar"));
            yield "\">
                                                        <i class=\"bi bi-";
            // line 93
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["user"], "isActive", [], "any", false, false, false, 93)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("pause") : ("play"));
            yield "-fill\"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['user'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 100
        yield "                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Inicializar DataTables si está disponible
document.addEventListener('DOMContentLoaded', function() {
    if (typeof \$ !== 'undefined' && \$.fn.DataTable) {
        \$('#usersTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            order: [[0, 'asc']]
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
        return "admin/users.html.twig";
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
        return array (  309 => 100,  296 => 93,  292 => 92,  288 => 91,  282 => 88,  275 => 84,  270 => 81,  264 => 79,  258 => 77,  256 => 76,  252 => 74,  248 => 72,  244 => 70,  242 => 69,  238 => 67,  232 => 65,  226 => 63,  224 => 62,  217 => 58,  213 => 57,  208 => 55,  199 => 51,  192 => 48,  185 => 43,  181 => 42,  174 => 38,  170 => 37,  165 => 35,  161 => 34,  156 => 32,  145 => 24,  141 => 23,  137 => 22,  132 => 19,  122 => 15,  119 => 14,  115 => 13,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Gestión de Usuarios - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'admin_users.title_page'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            {% for message in app.flashes('success') %}
                <div class=\"alert alert-success alert-dismissible fade show\">
                    <i class=\"bi bi-check-circle-fill\"></i> {{ message }}
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            {% endfor %}

            <div class=\"card\">
                <div class=\"card-header d-flex justify-content-between align-items-center\">
                    <h5 class=\"mb-0\"><i class=\"bi bi-people-fill\"></i> {{ 'admin_users.all_users'|trans }}</h5>
                    <a href=\"{{ path('app_admin_users_create') }}\" class=\"btn btn-primary\">
                        <i class=\"bi bi-person-plus\"></i> {{ 'admin.create_user'|trans }}
                    </a>
                </div>
                <div class=\"card-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-hover\" id=\"usersTable\">
                            <thead>
                                <tr>
                                    <th>{{ 'common.user'|trans }}</th>
                                    <th>Email</th>
                                    <th>{{ 'admin.role'|trans }}</th>
                                    <th>{{ 'system.status'|trans }}</th>
                                    <th>2FA</th>
                                    <th>{{ 'common.last_access'|trans }}</th>
                                    <th>{{ 'system.actions'|trans }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for user in users %}
                                    <tr>
                                        <td>
                                            <div class=\"d-flex align-items-center\">
                                                <div class=\"avatar bg-primary text-white rounded-circle me-2\"
                                                     style=\"width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;\">
                                                    {{ user.firstName|first }}{{ user.lastName|first }}
                                                </div>
                                                <div>
                                                    <strong>{{ user.firstName }} {{ user.lastName }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ user.email }}</td>
                                        <td>
                                            <span class=\"badge bg-{{ user.roles[0] == 'ROLE_SUPER_ADMIN' ? 'danger' : (user.roles[0] == 'ROLE_ADMIN' ? 'warning' : (user.roles[0] == 'ROLE_MANAGER' ? 'info' : 'secondary')) }}\">
                                                {{ user.roles[0]|replace({'ROLE_': ''})|capitalize }}
                                            </span>
                                        </td>
                                        <td>
                                            {% if user.isActive %}
                                                <span class=\"badge bg-success\">{{ 'system.status_active'|trans }}</span>
                                            {% else %}
                                                <span class=\"badge bg-danger\">{{ 'system.status_inactive'|trans }}</span>
                                            {% endif %}
                                        </td>
                                        <td>
                                            {% if user.totpEnabled %}
                                                <i class=\"bi bi-shield-check text-success\" title=\"2FA Habilitado\"></i>
                                            {% else %}
                                                <i class=\"bi bi-shield-x text-muted\" title=\"2FA Deshabilitado\"></i>
                                            {% endif %}
                                        </td>
                                        <td>
                                            {% if user.lastLoginAt %}
                                                <small>{{ user.lastLoginAt|date('d/m/Y H:i') }}</small>
                                            {% else %}
                                                <small class=\"text-muted\">{{ 'common.never'|trans }}</small>
                                            {% endif %}
                                        </td>
                                        <td>
                                            <div class=\"btn-group btn-group-sm\">
                                                <a href=\"{{ path('app_admin_users_edit', {id: user.id}) }}\"
                                                   class=\"btn btn-outline-primary\" title=\"Editar\">
                                                    <i class=\"bi bi-pencil\"></i>
                                                </a>
                                                <form method=\"post\" action=\"{{ path('app_admin_users_toggle', {id: user.id}) }}\"
                                                      style=\"display: inline;\">
                                                    <button type=\"submit\"
                                                            class=\"btn btn-outline-{{ user.isActive ? 'warning' : 'success' }}\"
                                                            title=\"{{ user.isActive ? 'Desactivar' : 'Activar' }}\">
                                                        <i class=\"bi bi-{{ user.isActive ? 'pause' : 'play' }}-fill\"></i>
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
        </div>
    </div>
</div>

<script>
// Inicializar DataTables si está disponible
document.addEventListener('DOMContentLoaded', function() {
    if (typeof \$ !== 'undefined' && \$.fn.DataTable) {
        \$('#usersTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            order: [[0, 'asc']]
        });
    }
});
</script>
{% endblock %}
", "admin/users.html.twig", "/var/www/html/proyecto/templates/admin/users.html.twig");
    }
}
