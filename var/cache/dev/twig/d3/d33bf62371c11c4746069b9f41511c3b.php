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

/* admin/users_edit.html.twig */
class __TwigTemplate_92b55f732a73beba2eea3ac111cfce47 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/users_edit.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/users_edit.html.twig"));

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

        yield "Editar Usuario - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin_users.edit_user_title")]));
        // line 11
        yield "
        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"row justify-content-center\">
                <div class=\"col-md-8\">
                    ";
        // line 15
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 15, $this->source); })()), "flashes", ["success"], "method", false, false, false, 15));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 16
            yield "                        <div class=\"alert alert-success alert-dismissible fade show\">
                            <i class=\"bi bi-check-circle-fill\"></i> ";
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
                            <h5 class=\"mb-0\">
                                <i class=\"bi bi-pencil\"></i> ";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin_users.edit_user_title"), "html", null, true);
        yield ": ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editUser"]) || array_key_exists("editUser", $context) ? $context["editUser"] : (function () { throw new RuntimeError('Variable "editUser" does not exist.', 25, $this->source); })()), "email", [], "any", false, false, false, 25), "html", null, true);
        yield "
                            </h5>
                        </div>
                        <div class=\"card-body\">
                            <form method=\"post\" action=\"";
        // line 29
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin_users_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, (isset($context["editUser"]) || array_key_exists("editUser", $context) ? $context["editUser"] : (function () { throw new RuntimeError('Variable "editUser" does not exist.', 29, $this->source); })()), "id", [], "any", false, false, false, 29)]), "html", null, true);
        yield "\">
                                <div class=\"row\">
                                    <div class=\"col-md-6 mb-3\">
                                        <label class=\"form-label\">Nombre</label>
                                        <input type=\"text\" name=\"first_name\" class=\"form-control\"
                                               value=\"";
        // line 34
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editUser"]) || array_key_exists("editUser", $context) ? $context["editUser"] : (function () { throw new RuntimeError('Variable "editUser" does not exist.', 34, $this->source); })()), "firstName", [], "any", false, false, false, 34), "html", null, true);
        yield "\" required>
                                    </div>
                                    <div class=\"col-md-6 mb-3\">
                                        <label class=\"form-label\">Apellido</label>
                                        <input type=\"text\" name=\"last_name\" class=\"form-control\"
                                               value=\"";
        // line 39
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editUser"]) || array_key_exists("editUser", $context) ? $context["editUser"] : (function () { throw new RuntimeError('Variable "editUser" does not exist.', 39, $this->source); })()), "lastName", [], "any", false, false, false, 39), "html", null, true);
        yield "\" required>
                                    </div>
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">Email</label>
                                    <input type=\"email\" class=\"form-control\" value=\"";
        // line 45
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editUser"]) || array_key_exists("editUser", $context) ? $context["editUser"] : (function () { throw new RuntimeError('Variable "editUser" does not exist.', 45, $this->source); })()), "email", [], "any", false, false, false, 45), "html", null, true);
        yield "\" disabled>
                                    <small class=\"text-muted\">";
        // line 46
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.email_not_modifiable"), "html", null, true);
        yield "</small>
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">Teléfono</label>
                                    <input type=\"tel\" name=\"phone\" class=\"form-control\"
                                           value=\"";
        // line 52
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editUser"]) || array_key_exists("editUser", $context) ? $context["editUser"] : (function () { throw new RuntimeError('Variable "editUser" does not exist.', 52, $this->source); })()), "phone", [], "any", false, false, false, 52), "html", null, true);
        yield "\">
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">Rol</label>
                                    <select name=\"role\" class=\"form-select\" required>
                                        <option value=\"ROLE_USER\" ";
        // line 58
        yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["editUser"]) || array_key_exists("editUser", $context) ? $context["editUser"] : (function () { throw new RuntimeError('Variable "editUser" does not exist.', 58, $this->source); })()), "roles", [], "any", false, false, false, 58), 0, [], "array", false, false, false, 58) == "ROLE_USER")) ? ("selected") : (""));
        yield ">
                                            Usuario
                                        </option>
                                        <option value=\"ROLE_MANAGER\" ";
        // line 61
        yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["editUser"]) || array_key_exists("editUser", $context) ? $context["editUser"] : (function () { throw new RuntimeError('Variable "editUser" does not exist.', 61, $this->source); })()), "roles", [], "any", false, false, false, 61), 0, [], "array", false, false, false, 61) == "ROLE_MANAGER")) ? ("selected") : (""));
        yield ">
                                            Manager
                                        </option>
                                        ";
        // line 64
        if ((($tmp = $this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_SUPER_ADMIN")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 65
            yield "                                            <option value=\"ROLE_ADMIN\" ";
            yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["editUser"]) || array_key_exists("editUser", $context) ? $context["editUser"] : (function () { throw new RuntimeError('Variable "editUser" does not exist.', 65, $this->source); })()), "roles", [], "any", false, false, false, 65), 0, [], "array", false, false, false, 65) == "ROLE_ADMIN")) ? ("selected") : (""));
            yield ">
                                                Administrador
                                            </option>
                                            <option value=\"ROLE_SUPER_ADMIN\" ";
            // line 68
            yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["editUser"]) || array_key_exists("editUser", $context) ? $context["editUser"] : (function () { throw new RuntimeError('Variable "editUser" does not exist.', 68, $this->source); })()), "roles", [], "any", false, false, false, 68), 0, [], "array", false, false, false, 68) == "ROLE_SUPER_ADMIN")) ? ("selected") : (""));
            yield ">
                                                Super Administrador
                                            </option>
                                        ";
        }
        // line 72
        yield "                                    </select>
                                </div>

                                <div class=\"form-check mb-3\">
                                    <input type=\"checkbox\" name=\"is_active\" class=\"form-check-input\" id=\"isActive\"
                                           ";
        // line 77
        yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["editUser"]) || array_key_exists("editUser", $context) ? $context["editUser"] : (function () { throw new RuntimeError('Variable "editUser" does not exist.', 77, $this->source); })()), "isActive", [], "any", false, false, false, 77)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("checked") : (""));
        yield ">
                                    <label class=\"form-check-label\" for=\"isActive\">
                                        Usuario activo
                                    </label>
                                </div>

                                <hr>

                                <h6>";
        // line 85
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.change"), "html", null, true);
        yield " (";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.optional"), "html", null, true);
        yield ")</h6>
                                <div class=\"mb-3\">
                                    <label class=\"form-label\">";
        // line 87
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.new_password"), "html", null, true);
        yield "</label>
                                    <input type=\"password\" name=\"password\" class=\"form-control\" minlength=\"8\">
                                    <small class=\"text-muted\">";
        // line 89
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("admin.leave_blank_no_change"), "html", null, true);
        yield "</small>
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">";
        // line 93
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.confirm_new_password"), "html", null, true);
        yield "</label>
                                    <input type=\"password\" name=\"password_confirm\" class=\"form-control\" minlength=\"8\">
                                </div>

                                <hr>

                                <div class=\"row mb-3\">
                                    <div class=\"col-md-6\">
                                        <small class=\"text-muted\">
                                            <strong>Creado:</strong> ";
        // line 102
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editUser"]) || array_key_exists("editUser", $context) ? $context["editUser"] : (function () { throw new RuntimeError('Variable "editUser" does not exist.', 102, $this->source); })()), "createdAt", [], "any", false, false, false, 102), "d/m/Y H:i"), "html", null, true);
        yield "
                                        </small>
                                    </div>
                                    <div class=\"col-md-6 text-end\">
                                        <small class=\"text-muted\">
                                            <strong>Último acceso:</strong>
                                            ";
        // line 108
        yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["editUser"]) || array_key_exists("editUser", $context) ? $context["editUser"] : (function () { throw new RuntimeError('Variable "editUser" does not exist.', 108, $this->source); })()), "lastLoginAt", [], "any", false, false, false, 108)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["editUser"]) || array_key_exists("editUser", $context) ? $context["editUser"] : (function () { throw new RuntimeError('Variable "editUser" does not exist.', 108, $this->source); })()), "lastLoginAt", [], "any", false, false, false, 108), "d/m/Y H:i"), "html", null, true)) : ("Nunca"));
        yield "
                                        </small>
                                    </div>
                                </div>

                                <div class=\"d-flex gap-2\">
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"bi bi-save\"></i> Guardar Cambios
                                    </button>
                                    <a href=\"";
        // line 117
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin_users");
        yield "\" class=\"btn btn-outline-secondary\">
                                        <i class=\"bi bi-arrow-left\"></i> Volver
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
        return "admin/users_edit.html.twig";
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
        return array (  294 => 117,  282 => 108,  273 => 102,  261 => 93,  254 => 89,  249 => 87,  242 => 85,  231 => 77,  224 => 72,  217 => 68,  210 => 65,  208 => 64,  202 => 61,  196 => 58,  187 => 52,  178 => 46,  174 => 45,  165 => 39,  157 => 34,  149 => 29,  140 => 25,  134 => 21,  124 => 17,  121 => 16,  117 => 15,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Editar Usuario - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'admin_users.edit_user_title'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            <div class=\"row justify-content-center\">
                <div class=\"col-md-8\">
                    {% for message in app.flashes('success') %}
                        <div class=\"alert alert-success alert-dismissible fade show\">
                            <i class=\"bi bi-check-circle-fill\"></i> {{ message }}
                            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                        </div>
                    {% endfor %}

                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\">
                                <i class=\"bi bi-pencil\"></i> {{ 'admin_users.edit_user_title'|trans }}: {{ editUser.email }}
                            </h5>
                        </div>
                        <div class=\"card-body\">
                            <form method=\"post\" action=\"{{ path('app_admin_users_edit', {id: editUser.id}) }}\">
                                <div class=\"row\">
                                    <div class=\"col-md-6 mb-3\">
                                        <label class=\"form-label\">Nombre</label>
                                        <input type=\"text\" name=\"first_name\" class=\"form-control\"
                                               value=\"{{ editUser.firstName }}\" required>
                                    </div>
                                    <div class=\"col-md-6 mb-3\">
                                        <label class=\"form-label\">Apellido</label>
                                        <input type=\"text\" name=\"last_name\" class=\"form-control\"
                                               value=\"{{ editUser.lastName }}\" required>
                                    </div>
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">Email</label>
                                    <input type=\"email\" class=\"form-control\" value=\"{{ editUser.email }}\" disabled>
                                    <small class=\"text-muted\">{{ 'common.email_not_modifiable'|trans }}</small>
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">Teléfono</label>
                                    <input type=\"tel\" name=\"phone\" class=\"form-control\"
                                           value=\"{{ editUser.phone }}\">
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">Rol</label>
                                    <select name=\"role\" class=\"form-select\" required>
                                        <option value=\"ROLE_USER\" {{ editUser.roles[0] == 'ROLE_USER' ? 'selected' : '' }}>
                                            Usuario
                                        </option>
                                        <option value=\"ROLE_MANAGER\" {{ editUser.roles[0] == 'ROLE_MANAGER' ? 'selected' : '' }}>
                                            Manager
                                        </option>
                                        {% if is_granted('ROLE_SUPER_ADMIN') %}
                                            <option value=\"ROLE_ADMIN\" {{ editUser.roles[0] == 'ROLE_ADMIN' ? 'selected' : '' }}>
                                                Administrador
                                            </option>
                                            <option value=\"ROLE_SUPER_ADMIN\" {{ editUser.roles[0] == 'ROLE_SUPER_ADMIN' ? 'selected' : '' }}>
                                                Super Administrador
                                            </option>
                                        {% endif %}
                                    </select>
                                </div>

                                <div class=\"form-check mb-3\">
                                    <input type=\"checkbox\" name=\"is_active\" class=\"form-check-input\" id=\"isActive\"
                                           {{ editUser.isActive ? 'checked' : '' }}>
                                    <label class=\"form-check-label\" for=\"isActive\">
                                        Usuario activo
                                    </label>
                                </div>

                                <hr>

                                <h6>{{ 'password.change'|trans }} ({{ 'common.optional'|trans }})</h6>
                                <div class=\"mb-3\">
                                    <label class=\"form-label\">{{ 'password.new_password'|trans }}</label>
                                    <input type=\"password\" name=\"password\" class=\"form-control\" minlength=\"8\">
                                    <small class=\"text-muted\">{{ 'admin.leave_blank_no_change'|trans }}</small>
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">{{ 'password.confirm_new_password'|trans }}</label>
                                    <input type=\"password\" name=\"password_confirm\" class=\"form-control\" minlength=\"8\">
                                </div>

                                <hr>

                                <div class=\"row mb-3\">
                                    <div class=\"col-md-6\">
                                        <small class=\"text-muted\">
                                            <strong>Creado:</strong> {{ editUser.createdAt|date('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                    <div class=\"col-md-6 text-end\">
                                        <small class=\"text-muted\">
                                            <strong>Último acceso:</strong>
                                            {{ editUser.lastLoginAt ? editUser.lastLoginAt|date('d/m/Y H:i') : 'Nunca' }}
                                        </small>
                                    </div>
                                </div>

                                <div class=\"d-flex gap-2\">
                                    <button type=\"submit\" class=\"btn btn-primary\">
                                        <i class=\"bi bi-save\"></i> Guardar Cambios
                                    </button>
                                    <a href=\"{{ path('app_admin_users') }}\" class=\"btn btn-outline-secondary\">
                                        <i class=\"bi bi-arrow-left\"></i> Volver
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
", "admin/users_edit.html.twig", "/var/www/html/proyecto/templates/admin/users_edit.html.twig");
    }
}
