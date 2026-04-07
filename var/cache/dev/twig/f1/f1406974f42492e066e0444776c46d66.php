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

/* system/tenants.html.twig */
class __TwigTemplate_9e09c01be77695d32ca180c4257cfab2 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "system/tenants.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "system/tenants.html.twig"));

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

        yield "Gestión de Empresas - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system_tenants.title_page")]));
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
            <div class=\"card\">
                <div class=\"card-header d-flex justify-content-between align-items-center\">
                    <h5 class=\"mb-0\"><i class=\"bi bi-building\"></i> ";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system_tenants.registered_tenants_section"), "html", null, true);
        yield "</h5>
                    <a href=\"";
        // line 26
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_tenants_create");
        yield "\" class=\"btn btn-primary\">
                        <i class=\"bi bi-plus-lg\"></i> ";
        // line 27
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system_tenants.create_new_tenant"), "html", null, true);
        yield "
                    </a>
                </div>
                <div class=\"card-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-hover\" id=\"tenantsTable\">
                            <thead>
                                <tr>
                                    <th>";
        // line 35
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.company"), "html", null, true);
        yield "</th>
                                    <th>";
        // line 36
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.company_code"), "html", null, true);
        yield "</th>
                                    <th>";
        // line 37
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.plan"), "html", null, true);
        yield "</th>
                                    <th>";
        // line 38
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.validity"), "html", null, true);
        yield "</th>
                                    <th>";
        // line 39
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.status"), "html", null, true);
        yield "</th>
                                    <th>";
        // line 40
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.users"), "html", null, true);
        yield "</th>
                                    <th>";
        // line 41
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.registration"), "html", null, true);
        yield "</th>
                                    <th>";
        // line 42
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.actions"), "html", null, true);
        yield "</th>
                                </tr>
                            </thead>
                            <tbody>
                                ";
        // line 46
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["tenants"]) || array_key_exists("tenants", $context) ? $context["tenants"] : (function () { throw new RuntimeError('Variable "tenants" does not exist.', 46, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["tenant"]) {
            // line 47
            yield "                                    <tr>
                                        <td>
                                            <strong>";
            // line 49
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "name", [], "any", false, false, false, 49), "html", null, true);
            yield "</strong>
                                        </td>
                                        <td>
                                            <code>";
            // line 52
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "slug", [], "any", false, false, false, 52), "html", null, true);
            yield "</code>
                                        </td>
                                        <td>
                                            <span class=\"badge bg-";
            // line 55
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "plan", [], "any", false, false, false, 55) == "enterprise")) ? ("danger") : ((((CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "plan", [], "any", false, false, false, 55) == "professional")) ? ("warning") : ("info"))));
            yield "\">
                                                ";
            // line 56
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "plan", [], "any", false, false, false, 56)), "html", null, true);
            yield "
                                            </span>
                                        </td>
                                        <td>
                                            ";
            // line 60
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "planExpiresAt", [], "any", false, false, false, 60)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 61
                yield "                                                ";
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "isPlanExpired", [], "any", false, false, false, 61)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 62
                    yield "                                                    <span class=\"badge bg-danger\">EXPIRADO</span><br>
                                                    <small class=\"text-muted\">";
                    // line 63
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "planExpiresAt", [], "any", false, false, false, 63), "d/m/Y"), "html", null, true);
                    yield "</small>
                                                ";
                } else {
                    // line 65
                    yield "                                                    ";
                    $context["days"] = CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "daysUntilExpiration", [], "any", false, false, false, 65);
                    // line 66
                    yield "                                                    <span class=\"badge bg-";
                    yield ((((isset($context["days"]) || array_key_exists("days", $context) ? $context["days"] : (function () { throw new RuntimeError('Variable "days" does not exist.', 66, $this->source); })()) <= 7)) ? ("danger") : (((((isset($context["days"]) || array_key_exists("days", $context) ? $context["days"] : (function () { throw new RuntimeError('Variable "days" does not exist.', 66, $this->source); })()) <= 30)) ? ("warning") : ("success"))));
                    yield "\">
                                                        ";
                    // line 67
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape((isset($context["days"]) || array_key_exists("days", $context) ? $context["days"] : (function () { throw new RuntimeError('Variable "days" does not exist.', 67, $this->source); })()), "html", null, true);
                    yield " días
                                                    </span><br>
                                                    <small class=\"text-muted\">";
                    // line 69
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "planExpiresAt", [], "any", false, false, false, 69), "d/m/Y"), "html", null, true);
                    yield "</small>
                                                ";
                }
                // line 71
                yield "                                            ";
            } else {
                // line 72
                yield "                                                    <span class=\"badge bg-secondary\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.no_limit"), "html", null, true);
                yield "</span>
                                            ";
            }
            // line 74
            yield "                                        </td>
                                        <td>
                                            ";
            // line 76
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "isActive", [], "any", false, false, false, 76)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 77
                yield "                                                <span class=\"badge bg-success\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.status_active"), "html", null, true);
                yield "</span>
                                            ";
            } else {
                // line 79
                yield "                                                <span class=\"badge bg-danger\">";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("system.status_inactive"), "html", null, true);
                yield "</span>
                                            ";
            }
            // line 81
            yield "                                        </td>
                                        <td>
                                            <small>";
            // line 83
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "users", [], "any", false, false, false, 83)), "html", null, true);
            yield " / ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "maxUsers", [], "any", false, false, false, 83), "html", null, true);
            yield "</small>
                                        </td>
                                        <td>
                                            <small>";
            // line 86
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "createdAt", [], "any", false, false, false, 86), "d/m/Y"), "html", null, true);
            yield "</small>
                                        </td>
                                        <td>
                                            <div class=\"btn-group btn-group-sm\">
                                                <a href=\"";
            // line 90
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_system_tenants_edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "id", [], "any", false, false, false, 90)]), "html", null, true);
            yield "\" class=\"btn btn-outline-primary\" title=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.edit"), "html", null, true);
            yield "\">
                                                    <i class=\"bi bi-pencil\"></i>
                                                </a>
                                                <button type=\"button\" class=\"btn btn-outline-info\" title=\"";
            // line 93
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.view_details"), "html", null, true);
            yield "\"
                                                        data-bs-toggle=\"modal\" data-bs-target=\"#tenantModal";
            // line 94
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "id", [], "any", false, false, false, 94), "html", null, true);
            yield "\">
                                                    <i class=\"bi bi-eye\"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['tenant'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 101
        yield "                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales de detalles -->
";
        // line 111
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable((isset($context["tenants"]) || array_key_exists("tenants", $context) ? $context["tenants"] : (function () { throw new RuntimeError('Variable "tenants" does not exist.', 111, $this->source); })()));
        foreach ($context['_seq'] as $context["_key"] => $context["tenant"]) {
            // line 112
            yield "    <div class=\"modal fade\" id=\"tenantModal";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "id", [], "any", false, false, false, 112), "html", null, true);
            yield "\" tabindex=\"-1\">
        <div class=\"modal-dialog modal-lg\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h5 class=\"modal-title\">Detalles de ";
            // line 116
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "name", [], "any", false, false, false, 116), "html", null, true);
            yield "</h5>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>
                </div>
                <div class=\"modal-body\">
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <dl class=\"row\">
                                <dt class=\"col-sm-4\">Nombre:</dt>
                                <dd class=\"col-sm-8\">";
            // line 124
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "name", [], "any", false, false, false, 124), "html", null, true);
            yield "</dd>

                                <dt class=\"col-sm-4\">Subdominio:</dt>
                                <dd class=\"col-sm-8\"><code>";
            // line 127
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "slug", [], "any", false, false, false, 127), "html", null, true);
            yield "</code></dd>

                                <dt class=\"col-sm-4\">Plan:</dt>
                                <dd class=\"col-sm-8\">
                                    <span class=\"badge bg-";
            // line 131
            yield (((CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "plan", [], "any", false, false, false, 131) == "enterprise")) ? ("danger") : ((((CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "plan", [], "any", false, false, false, 131) == "professional")) ? ("warning") : ("info"))));
            yield "\">
                                        ";
            // line 132
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "plan", [], "any", false, false, false, 132)), "html", null, true);
            yield "
                                    </span>
                                </dd>

                                <dt class=\"col-sm-4\">Estado:</dt>
                                <dd class=\"col-sm-8\">
                                    <span class=\"badge bg-";
            // line 138
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "isActive", [], "any", false, false, false, 138)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("success") : ("danger"));
            yield "\">
                                        ";
            // line 139
            yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "isActive", [], "any", false, false, false, 139)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Activo") : ("Inactivo"));
            yield "
                                    </span>
                                </dd>
                            </dl>
                        </div>
                        <div class=\"col-md-6\">
                            <dl class=\"row\">
                                <dt class=\"col-sm-5\">Usuarios:</dt>
                                <dd class=\"col-sm-7\">";
            // line 147
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::length($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "users", [], "any", false, false, false, 147)), "html", null, true);
            yield " / ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "maxUsers", [], "any", false, false, false, 147), "html", null, true);
            yield "</dd>

                                <dt class=\"col-sm-5\">Proyectos:</dt>
                                <dd class=\"col-sm-7\">0 / ";
            // line 150
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "maxProjects", [], "any", false, false, false, 150), "html", null, true);
            yield "</dd>

                                <dt class=\"col-sm-5\">Registro:</dt>
                                <dd class=\"col-sm-7\">";
            // line 153
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "createdAt", [], "any", false, false, false, 153), "d/m/Y H:i"), "html", null, true);
            yield "</dd>
                            </dl>
                        </div>
                    </div>

                    <hr>

                    <h6>Usuarios Registrados</h6>
                    <ul class=\"list-group\">
                        ";
            // line 162
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["tenant"], "users", [], "any", false, false, false, 162));
            foreach ($context['_seq'] as $context["_key"] => $context["user"]) {
                // line 163
                yield "                            <li class=\"list-group-item d-flex justify-content-between align-items-center\">
                                <div>
                                    <strong>";
                // line 165
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "firstName", [], "any", false, false, false, 165), "html", null, true);
                yield " ";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "lastName", [], "any", false, false, false, 165), "html", null, true);
                yield "</strong><br>
                                    <small class=\"text-muted\">";
                // line 166
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["user"], "email", [], "any", false, false, false, 166), "html", null, true);
                yield "</small>
                                </div>
                                <div>
                                    <span class=\"badge bg-";
                // line 169
                yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["user"], "roles", [], "any", false, false, false, 169), 0, [], "array", false, false, false, 169) == "ROLE_SUPER_ADMIN")) ? ("danger") : ((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["user"], "roles", [], "any", false, false, false, 169), 0, [], "array", false, false, false, 169) == "ROLE_ADMIN")) ? ("warning") : ("secondary"))));
                yield "\">
                                        ";
                // line 170
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["user"], "roles", [], "any", false, false, false, 170), 0, [], "array", false, false, false, 170), ["ROLE_" => ""]), "html", null, true);
                yield "
                                    </span>
                                    ";
                // line 172
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["user"], "totpEnabled", [], "any", false, false, false, 172)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 173
                    yield "                                        <i class=\"bi bi-shield-check text-success\" title=\"2FA Habilitado\"></i>
                                    ";
                }
                // line 175
                yield "                                </div>
                            </li>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['user'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 178
            yield "                    </ul>
                </div>
                <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['tenant'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 187
        yield "
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof \$ !== 'undefined' && \$.fn.DataTable) {
        \$('#tenantsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            order: [[6, 'desc']]
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
        return "system/tenants.html.twig";
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
        return array (  497 => 187,  483 => 178,  475 => 175,  471 => 173,  469 => 172,  464 => 170,  460 => 169,  454 => 166,  448 => 165,  444 => 163,  440 => 162,  428 => 153,  422 => 150,  414 => 147,  403 => 139,  399 => 138,  390 => 132,  386 => 131,  379 => 127,  373 => 124,  362 => 116,  354 => 112,  350 => 111,  338 => 101,  325 => 94,  321 => 93,  313 => 90,  306 => 86,  298 => 83,  294 => 81,  288 => 79,  282 => 77,  280 => 76,  276 => 74,  270 => 72,  267 => 71,  262 => 69,  257 => 67,  252 => 66,  249 => 65,  244 => 63,  241 => 62,  238 => 61,  236 => 60,  229 => 56,  225 => 55,  219 => 52,  213 => 49,  209 => 47,  205 => 46,  198 => 42,  194 => 41,  190 => 40,  186 => 39,  182 => 38,  178 => 37,  174 => 36,  170 => 35,  159 => 27,  155 => 26,  151 => 25,  146 => 22,  140 => 21,  130 => 17,  125 => 16,  120 => 15,  116 => 14,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Gestión de Empresas - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'system_tenants.title_page'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">

            {% for label, messages in app.flashes %}
                {% for message in messages %}
                    <div class=\"alert alert-{{ label }} alert-dismissible fade show\" role=\"alert\">
                        {{ message }}
                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                    </div>
                {% endfor %}
            {% endfor %}

            <div class=\"card\">
                <div class=\"card-header d-flex justify-content-between align-items-center\">
                    <h5 class=\"mb-0\"><i class=\"bi bi-building\"></i> {{ 'system_tenants.registered_tenants_section'|trans }}</h5>
                    <a href=\"{{ path('app_system_tenants_create') }}\" class=\"btn btn-primary\">
                        <i class=\"bi bi-plus-lg\"></i> {{ 'system_tenants.create_new_tenant'|trans }}
                    </a>
                </div>
                <div class=\"card-body\">
                    <div class=\"table-responsive\">
                        <table class=\"table table-hover\" id=\"tenantsTable\">
                            <thead>
                                <tr>
                                    <th>{{ 'common.company'|trans }}</th>
                                    <th>{{ 'system.company_code'|trans }}</th>
                                    <th>{{ 'system.plan'|trans }}</th>
                                    <th>{{ 'system.validity'|trans }}</th>
                                    <th>{{ 'system.status'|trans }}</th>
                                    <th>{{ 'system.users'|trans }}</th>
                                    <th>{{ 'system.registration'|trans }}</th>
                                    <th>{{ 'system.actions'|trans }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {% for tenant in tenants %}
                                    <tr>
                                        <td>
                                            <strong>{{ tenant.name }}</strong>
                                        </td>
                                        <td>
                                            <code>{{ tenant.slug }}</code>
                                        </td>
                                        <td>
                                            <span class=\"badge bg-{{ tenant.plan == 'enterprise' ? 'danger' : (tenant.plan == 'professional' ? 'warning' : 'info') }}\">
                                                {{ tenant.plan|upper }}
                                            </span>
                                        </td>
                                        <td>
                                            {% if tenant.planExpiresAt %}
                                                {% if tenant.isPlanExpired %}
                                                    <span class=\"badge bg-danger\">EXPIRADO</span><br>
                                                    <small class=\"text-muted\">{{ tenant.planExpiresAt|date('d/m/Y') }}</small>
                                                {% else %}
                                                    {% set days = tenant.daysUntilExpiration %}
                                                    <span class=\"badge bg-{{ days <= 7 ? 'danger' : (days <= 30 ? 'warning' : 'success') }}\">
                                                        {{ days }} días
                                                    </span><br>
                                                    <small class=\"text-muted\">{{ tenant.planExpiresAt|date('d/m/Y') }}</small>
                                                {% endif %}
                                            {% else %}
                                                    <span class=\"badge bg-secondary\">{{ 'system.no_limit'|trans }}</span>
                                            {% endif %}
                                        </td>
                                        <td>
                                            {% if tenant.isActive %}
                                                <span class=\"badge bg-success\">{{ 'system.status_active'|trans }}</span>
                                            {% else %}
                                                <span class=\"badge bg-danger\">{{ 'system.status_inactive'|trans }}</span>
                                            {% endif %}
                                        </td>
                                        <td>
                                            <small>{{ tenant.users|length }} / {{ tenant.maxUsers }}</small>
                                        </td>
                                        <td>
                                            <small>{{ tenant.createdAt|date('d/m/Y') }}</small>
                                        </td>
                                        <td>
                                            <div class=\"btn-group btn-group-sm\">
                                                <a href=\"{{ path('app_system_tenants_edit', {id: tenant.id}) }}\" class=\"btn btn-outline-primary\" title=\"{{ 'common.edit'|trans }}\">
                                                    <i class=\"bi bi-pencil\"></i>
                                                </a>
                                                <button type=\"button\" class=\"btn btn-outline-info\" title=\"{{ 'common.view_details'|trans }}\"
                                                        data-bs-toggle=\"modal\" data-bs-target=\"#tenantModal{{ tenant.id }}\">
                                                    <i class=\"bi bi-eye\"></i>
                                                </button>
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

<!-- Modales de detalles -->
{% for tenant in tenants %}
    <div class=\"modal fade\" id=\"tenantModal{{ tenant.id }}\" tabindex=\"-1\">
        <div class=\"modal-dialog modal-lg\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h5 class=\"modal-title\">Detalles de {{ tenant.name }}</h5>
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>
                </div>
                <div class=\"modal-body\">
                    <div class=\"row\">
                        <div class=\"col-md-6\">
                            <dl class=\"row\">
                                <dt class=\"col-sm-4\">Nombre:</dt>
                                <dd class=\"col-sm-8\">{{ tenant.name }}</dd>

                                <dt class=\"col-sm-4\">Subdominio:</dt>
                                <dd class=\"col-sm-8\"><code>{{ tenant.slug }}</code></dd>

                                <dt class=\"col-sm-4\">Plan:</dt>
                                <dd class=\"col-sm-8\">
                                    <span class=\"badge bg-{{ tenant.plan == 'enterprise' ? 'danger' : (tenant.plan == 'professional' ? 'warning' : 'info') }}\">
                                        {{ tenant.plan|upper }}
                                    </span>
                                </dd>

                                <dt class=\"col-sm-4\">Estado:</dt>
                                <dd class=\"col-sm-8\">
                                    <span class=\"badge bg-{{ tenant.isActive ? 'success' : 'danger' }}\">
                                        {{ tenant.isActive ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                        <div class=\"col-md-6\">
                            <dl class=\"row\">
                                <dt class=\"col-sm-5\">Usuarios:</dt>
                                <dd class=\"col-sm-7\">{{ tenant.users|length }} / {{ tenant.maxUsers }}</dd>

                                <dt class=\"col-sm-5\">Proyectos:</dt>
                                <dd class=\"col-sm-7\">0 / {{ tenant.maxProjects }}</dd>

                                <dt class=\"col-sm-5\">Registro:</dt>
                                <dd class=\"col-sm-7\">{{ tenant.createdAt|date('d/m/Y H:i') }}</dd>
                            </dl>
                        </div>
                    </div>

                    <hr>

                    <h6>Usuarios Registrados</h6>
                    <ul class=\"list-group\">
                        {% for user in tenant.users %}
                            <li class=\"list-group-item d-flex justify-content-between align-items-center\">
                                <div>
                                    <strong>{{ user.firstName }} {{ user.lastName }}</strong><br>
                                    <small class=\"text-muted\">{{ user.email }}</small>
                                </div>
                                <div>
                                    <span class=\"badge bg-{{ user.roles[0] == 'ROLE_SUPER_ADMIN' ? 'danger' : (user.roles[0] == 'ROLE_ADMIN' ? 'warning' : 'secondary') }}\">
                                        {{ user.roles[0]|replace({'ROLE_': ''}) }}
                                    </span>
                                    {% if user.totpEnabled %}
                                        <i class=\"bi bi-shield-check text-success\" title=\"2FA Habilitado\"></i>
                                    {% endif %}
                                </div>
                            </li>
                        {% endfor %}
                    </ul>
                </div>
                <div class=\"modal-footer\">
                    <button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
{% endfor %}

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof \$ !== 'undefined' && \$.fn.DataTable) {
        \$('#tenantsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            order: [[6, 'desc']]
        });
    }
});
</script>
{% endblock %}
", "system/tenants.html.twig", "/var/www/html/proyecto/templates/system/tenants.html.twig");
    }
}
