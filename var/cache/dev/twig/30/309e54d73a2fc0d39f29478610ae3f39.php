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

/* admin/tenant.html.twig */
class __TwigTemplate_d4e4634c7c0f0adc91c66a20d4074eb9 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/tenant.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "admin/tenant.html.twig"));

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

        yield "Configuración de Empresa - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => "Configuración de Empresa"]));
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
            <div class=\"row\">
                <div class=\"col-md-8\">
                    <div class=\"card mb-4\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-building\"></i> Información de la Empresa</h5>
                        </div>
                        <div class=\"card-body\">
                            <form method=\"post\" action=\"";
        // line 27
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin_tenant");
        yield "\">
                                <div class=\"mb-3\">
                                    <label class=\"form-label\">Nombre Comercial</label>
                                    <input type=\"text\" name=\"name\" class=\"form-control\"
                                           value=\"";
        // line 31
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 31, $this->source); })()), "name", [], "any", false, false, false, 31), "html", null, true);
        yield "\" required>
                                </div>

                                ";
        // line 77
        yield "
                                <button type=\"submit\" class=\"btn btn-primary\">
                                    <i class=\"bi bi-save\"></i> Guardar Cambios
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-gear\"></i> Configuración del Sistema</h5>
                        </div>
                        <div class=\"card-body\">
                            <form method=\"post\" action=\"";
        // line 90
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_admin_tenant");
        yield "\">
                                <input type=\"hidden\" name=\"settings_form\" value=\"1\">

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">Zona Horaria</label>
                                    <select name=\"timezone\" class=\"form-select\">
                                        <option value=\"America/Bogota\" ";
        // line 96
        yield (((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["tenant"] ?? null), "settings", [], "any", false, true, false, 96), "timezone", [], "any", true, true, false, 96)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 96, $this->source); })()), "settings", [], "any", false, false, false, 96), "timezone", [], "any", false, false, false, 96), "America/Bogota")) : ("America/Bogota")) == "America/Bogota")) ? ("selected") : (""));
        yield ">
                                            América/Bogotá (GMT-5)
                                        </option>
                                        <option value=\"America/Mexico_City\" ";
        // line 99
        yield (((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["tenant"] ?? null), "settings", [], "any", false, true, false, 99), "timezone", [], "any", true, true, false, 99)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 99, $this->source); })()), "settings", [], "any", false, false, false, 99), "timezone", [], "any", false, false, false, 99), "")) : ("")) == "America/Mexico_City")) ? ("selected") : (""));
        yield ">
                                            América/Ciudad de México (GMT-6)
                                        </option>
                                        <option value=\"America/Lima\" ";
        // line 102
        yield (((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["tenant"] ?? null), "settings", [], "any", false, true, false, 102), "timezone", [], "any", true, true, false, 102)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 102, $this->source); })()), "settings", [], "any", false, false, false, 102), "timezone", [], "any", false, false, false, 102), "")) : ("")) == "America/Lima")) ? ("selected") : (""));
        yield ">
                                            América/Lima (GMT-5)
                                        </option>
                                        <option value=\"America/Santiago\" ";
        // line 105
        yield (((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["tenant"] ?? null), "settings", [], "any", false, true, false, 105), "timezone", [], "any", true, true, false, 105)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 105, $this->source); })()), "settings", [], "any", false, false, false, 105), "timezone", [], "any", false, false, false, 105), "")) : ("")) == "America/Santiago")) ? ("selected") : (""));
        yield ">
                                            América/Santiago (GMT-4/GMT-3)
                                        </option>
                                    </select>
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">Moneda</label>
                                    <select name=\"currency\" class=\"form-select\">
                                        <option value=\"COP\" ";
        // line 114
        yield (((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["tenant"] ?? null), "settings", [], "any", false, true, false, 114), "currency", [], "any", true, true, false, 114)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 114, $this->source); })()), "settings", [], "any", false, false, false, 114), "currency", [], "any", false, false, false, 114), "COP")) : ("COP")) == "COP")) ? ("selected") : (""));
        yield ">
                                            Peso Colombiano (COP)
                                        </option>
                                        <option value=\"USD\" ";
        // line 117
        yield (((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["tenant"] ?? null), "settings", [], "any", false, true, false, 117), "currency", [], "any", true, true, false, 117)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 117, $this->source); })()), "settings", [], "any", false, false, false, 117), "currency", [], "any", false, false, false, 117), "")) : ("")) == "USD")) ? ("selected") : (""));
        yield ">
                                            Dólar Americano (USD)
                                        </option>
                                        <option value=\"MXN\" ";
        // line 120
        yield (((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["tenant"] ?? null), "settings", [], "any", false, true, false, 120), "currency", [], "any", true, true, false, 120)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 120, $this->source); })()), "settings", [], "any", false, false, false, 120), "currency", [], "any", false, false, false, 120), "")) : ("")) == "MXN")) ? ("selected") : (""));
        yield ">
                                            Peso Mexicano (MXN)
                                        </option>
                                        <option value=\"PEN\" ";
        // line 123
        yield (((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["tenant"] ?? null), "settings", [], "any", false, true, false, 123), "currency", [], "any", true, true, false, 123)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 123, $this->source); })()), "settings", [], "any", false, false, false, 123), "currency", [], "any", false, false, false, 123), "")) : ("")) == "PEN")) ? ("selected") : (""));
        yield ">
                                            Nuevo Sol (PEN)
                                        </option>
                                        <option value=\"CLP\" ";
        // line 126
        yield (((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["tenant"] ?? null), "settings", [], "any", false, true, false, 126), "currency", [], "any", true, true, false, 126)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 126, $this->source); })()), "settings", [], "any", false, false, false, 126), "currency", [], "any", false, false, false, 126), "")) : ("")) == "CLP")) ? ("selected") : (""));
        yield ">
                                            Peso Chileno (CLP)
                                        </option>
                                    </select>
                                </div>

                                <div class=\"form-check mb-3\">
                                    <input type=\"checkbox\" name=\"require_2fa\" class=\"form-check-input\" id=\"require2FA\"
                                           ";
        // line 134
        yield (((($tmp = ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["tenant"] ?? null), "settings", [], "any", false, true, false, 134), "require2fa", [], "any", true, true, false, 134)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 134, $this->source); })()), "settings", [], "any", false, false, false, 134), "require2fa", [], "any", false, false, false, 134), false)) : (false))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("checked") : (""));
        yield ">
                                    <label class=\"form-check-label\" for=\"require2FA\">
                                        Requerir autenticación de dos factores para todos los usuarios
                                    </label>
                                </div>

                                <div class=\"form-check mb-3\">
                                    <input type=\"checkbox\" name=\"enable_email_notifications\" class=\"form-check-input\" id=\"emailNotifications\"
                                           ";
        // line 142
        yield (((($tmp = ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["tenant"] ?? null), "settings", [], "any", false, true, false, 142), "emailNotifications", [], "any", true, true, false, 142)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 142, $this->source); })()), "settings", [], "any", false, false, false, 142), "emailNotifications", [], "any", false, false, false, 142), true)) : (true))) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("checked") : (""));
        yield ">
                                    <label class=\"form-check-label\" for=\"emailNotifications\">
                                        Habilitar notificaciones por email
                                    </label>
                                </div>

                                <button type=\"submit\" class=\"btn btn-primary\">
                                    <i class=\"bi bi-save\"></i> Guardar Configuración
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-4\">
                    <div class=\"card mb-4\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-credit-card\"></i> Plan Actual</h5>
                        </div>
                        <div class=\"card-body text-center\">
                            <h2 class=\"text-primary\">";
        // line 162
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 162, $this->source); })()), "plan", [], "any", false, false, false, 162)), "html", null, true);
        yield "</h2>
                            <p class=\"text-muted\">
                                ";
        // line 164
        if ((CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 164, $this->source); })()), "plan", [], "any", false, false, false, 164) == "trial")) {
            // line 165
            yield "                                    Plan de prueba
                                ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 166
(isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 166, $this->source); })()), "plan", [], "any", false, false, false, 166) == "basic")) {
            // line 167
            yield "                                    Plan básico
                                ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 168
(isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 168, $this->source); })()), "plan", [], "any", false, false, false, 168) == "professional")) {
            // line 169
            yield "                                    Plan profesional
                                ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source,         // line 170
(isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 170, $this->source); })()), "plan", [], "any", false, false, false, 170) == "enterprise")) {
            // line 171
            yield "                                    Plan empresarial
                                ";
        }
        // line 173
        yield "                            </p>

                            <div class=\"alert alert-";
        // line 175
        yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 175, $this->source); })()), "isActive", [], "any", false, false, false, 175)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("success") : ("danger"));
        yield "\">
                                Estado: <strong>";
        // line 176
        yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 176, $this->source); })()), "isActive", [], "any", false, false, false, 176)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Activo") : ("Inactivo"));
        yield "</strong>
                            </div>

                            <hr>

                            <dl class=\"row text-start\">
                                <dt class=\"col-6\">Usuarios:</dt>
                                <dd class=\"col-6\">";
        // line 183
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 183, $this->source); })()), "maxUsers", [], "any", false, false, false, 183), "html", null, true);
        yield " máximo</dd>

                                <dt class=\"col-6\">Proyectos:</dt>
                                <dd class=\"col-6\">";
        // line 186
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 186, $this->source); })()), "maxProjects", [], "any", false, false, false, 186), "html", null, true);
        yield "</dd>
                            </dl>
                        </div>
                    </div>

                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-info-circle\"></i> Información del Sistema</h5>
                        </div>
                        <div class=\"card-body\">
                            <dl class=\"mb-0\">
                                <dt>Cuenta creada:</dt>
                                <dd>";
        // line 198
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 198, $this->source); })()), "createdAt", [], "any", false, false, false, 198), "d/m/Y"), "html", null, true);
        yield "</dd>

                                <dt>ID del Tenant:</dt>
                                <dd><code>";
        // line 201
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 201, $this->source); })()), "id", [], "any", false, false, false, 201), "html", null, true);
        yield "</code></dd>

                                <dt>Dominio:</dt>
                                <dd>";
        // line 204
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 204, $this->source); })()), "slug", [], "any", false, false, false, 204), "html", null, true);
        yield "</dd>
                            </dl>
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
        return "admin/tenant.html.twig";
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
        return array (  355 => 204,  349 => 201,  343 => 198,  328 => 186,  322 => 183,  312 => 176,  308 => 175,  304 => 173,  300 => 171,  298 => 170,  295 => 169,  293 => 168,  290 => 167,  288 => 166,  285 => 165,  283 => 164,  278 => 162,  255 => 142,  244 => 134,  233 => 126,  227 => 123,  221 => 120,  215 => 117,  209 => 114,  197 => 105,  191 => 102,  185 => 99,  179 => 96,  170 => 90,  155 => 77,  149 => 31,  142 => 27,  132 => 19,  122 => 15,  119 => 14,  115 => 13,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Configuración de Empresa - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'Configuración de Empresa'} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            {% for message in app.flashes('success') %}
                <div class=\"alert alert-success alert-dismissible fade show\">
                    <i class=\"bi bi-check-circle-fill\"></i> {{ message }}
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            {% endfor %}

            <div class=\"row\">
                <div class=\"col-md-8\">
                    <div class=\"card mb-4\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-building\"></i> Información de la Empresa</h5>
                        </div>
                        <div class=\"card-body\">
                            <form method=\"post\" action=\"{{ path('app_admin_tenant') }}\">
                                <div class=\"mb-3\">
                                    <label class=\"form-label\">Nombre Comercial</label>
                                    <input type=\"text\" name=\"name\" class=\"form-control\"
                                           value=\"{{ tenant.name }}\" required>
                                </div>

                                {# Campos adicionales (requieren migración de BD)
                                <div class=\"row\">
                                    <div class=\"col-md-6 mb-3\">
                                        <label class=\"form-label\">NIT / RUT</label>
                                        <input type=\"text\" name=\"tax_id\" class=\"form-control\" value=\"\">
                                    </div>
                                    <div class=\"col-md-6 mb-3\">
                                        <label class=\"form-label\">Email Corporativo</label>
                                        <input type=\"email\" name=\"email\" class=\"form-control\" value=\"\">
                                    </div>
                                </div>

                                <div class=\"row\">
                                    <div class=\"col-md-6 mb-3\">
                                        <label class=\"form-label\">Teléfono</label>
                                        <input type=\"tel\" name=\"phone\" class=\"form-control\" value=\"\">
                                    </div>
                                    <div class=\"col-md-6 mb-3\">
                                        <label class=\"form-label\">Sitio Web</label>
                                        <input type=\"url\" name=\"website\" class=\"form-control\" value=\"\" placeholder=\"https://\">
                                    </div>
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">Dirección</label>
                                    <textarea name=\"address\" class=\"form-control\" rows=\"2\"></textarea>
                                </div>

                                <div class=\"row\">
                                    <div class=\"col-md-4 mb-3\">
                                        <label class=\"form-label\">Ciudad</label>
                                        <input type=\"text\" name=\"city\" class=\"form-control\" value=\"\">
                                    </div>
                                    <div class=\"col-md-4 mb-3\">
                                        <label class=\"form-label\">Estado/Región</label>
                                        <input type=\"text\" name=\"state\" class=\"form-control\" value=\"\">
                                    </div>
                                    <div class=\"col-md-4 mb-3\">
                                        <label class=\"form-label\">País</label>
                                        <input type=\"text\" name=\"country\" class=\"form-control\" value=\"\">
                                    </div>
                                </div>
                                #}

                                <button type=\"submit\" class=\"btn btn-primary\">
                                    <i class=\"bi bi-save\"></i> Guardar Cambios
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-gear\"></i> Configuración del Sistema</h5>
                        </div>
                        <div class=\"card-body\">
                            <form method=\"post\" action=\"{{ path('app_admin_tenant') }}\">
                                <input type=\"hidden\" name=\"settings_form\" value=\"1\">

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">Zona Horaria</label>
                                    <select name=\"timezone\" class=\"form-select\">
                                        <option value=\"America/Bogota\" {{ tenant.settings.timezone|default('America/Bogota') == 'America/Bogota' ? 'selected' : '' }}>
                                            América/Bogotá (GMT-5)
                                        </option>
                                        <option value=\"America/Mexico_City\" {{ tenant.settings.timezone|default('') == 'America/Mexico_City' ? 'selected' : '' }}>
                                            América/Ciudad de México (GMT-6)
                                        </option>
                                        <option value=\"America/Lima\" {{ tenant.settings.timezone|default('') == 'America/Lima' ? 'selected' : '' }}>
                                            América/Lima (GMT-5)
                                        </option>
                                        <option value=\"America/Santiago\" {{ tenant.settings.timezone|default('') == 'America/Santiago' ? 'selected' : '' }}>
                                            América/Santiago (GMT-4/GMT-3)
                                        </option>
                                    </select>
                                </div>

                                <div class=\"mb-3\">
                                    <label class=\"form-label\">Moneda</label>
                                    <select name=\"currency\" class=\"form-select\">
                                        <option value=\"COP\" {{ tenant.settings.currency|default('COP') == 'COP' ? 'selected' : '' }}>
                                            Peso Colombiano (COP)
                                        </option>
                                        <option value=\"USD\" {{ tenant.settings.currency|default('') == 'USD' ? 'selected' : '' }}>
                                            Dólar Americano (USD)
                                        </option>
                                        <option value=\"MXN\" {{ tenant.settings.currency|default('') == 'MXN' ? 'selected' : '' }}>
                                            Peso Mexicano (MXN)
                                        </option>
                                        <option value=\"PEN\" {{ tenant.settings.currency|default('') == 'PEN' ? 'selected' : '' }}>
                                            Nuevo Sol (PEN)
                                        </option>
                                        <option value=\"CLP\" {{ tenant.settings.currency|default('') == 'CLP' ? 'selected' : '' }}>
                                            Peso Chileno (CLP)
                                        </option>
                                    </select>
                                </div>

                                <div class=\"form-check mb-3\">
                                    <input type=\"checkbox\" name=\"require_2fa\" class=\"form-check-input\" id=\"require2FA\"
                                           {{ tenant.settings.require2fa|default(false) ? 'checked' : '' }}>
                                    <label class=\"form-check-label\" for=\"require2FA\">
                                        Requerir autenticación de dos factores para todos los usuarios
                                    </label>
                                </div>

                                <div class=\"form-check mb-3\">
                                    <input type=\"checkbox\" name=\"enable_email_notifications\" class=\"form-check-input\" id=\"emailNotifications\"
                                           {{ tenant.settings.emailNotifications|default(true) ? 'checked' : '' }}>
                                    <label class=\"form-check-label\" for=\"emailNotifications\">
                                        Habilitar notificaciones por email
                                    </label>
                                </div>

                                <button type=\"submit\" class=\"btn btn-primary\">
                                    <i class=\"bi bi-save\"></i> Guardar Configuración
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-4\">
                    <div class=\"card mb-4\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-credit-card\"></i> Plan Actual</h5>
                        </div>
                        <div class=\"card-body text-center\">
                            <h2 class=\"text-primary\">{{ tenant.plan|upper }}</h2>
                            <p class=\"text-muted\">
                                {% if tenant.plan == 'trial' %}
                                    Plan de prueba
                                {% elseif tenant.plan == 'basic' %}
                                    Plan básico
                                {% elseif tenant.plan == 'professional' %}
                                    Plan profesional
                                {% elseif tenant.plan == 'enterprise' %}
                                    Plan empresarial
                                {% endif %}
                            </p>

                            <div class=\"alert alert-{{ tenant.isActive ? 'success' : 'danger' }}\">
                                Estado: <strong>{{ tenant.isActive ? 'Activo' : 'Inactivo' }}</strong>
                            </div>

                            <hr>

                            <dl class=\"row text-start\">
                                <dt class=\"col-6\">Usuarios:</dt>
                                <dd class=\"col-6\">{{ tenant.maxUsers }} máximo</dd>

                                <dt class=\"col-6\">Proyectos:</dt>
                                <dd class=\"col-6\">{{ tenant.maxProjects }}</dd>
                            </dl>
                        </div>
                    </div>

                    <div class=\"card\">
                        <div class=\"card-header\">
                            <h5 class=\"mb-0\"><i class=\"bi bi-info-circle\"></i> Información del Sistema</h5>
                        </div>
                        <div class=\"card-body\">
                            <dl class=\"mb-0\">
                                <dt>Cuenta creada:</dt>
                                <dd>{{ tenant.createdAt|date('d/m/Y') }}</dd>

                                <dt>ID del Tenant:</dt>
                                <dd><code>{{ tenant.id }}</code></dd>

                                <dt>Dominio:</dt>
                                <dd>{{ tenant.slug }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
", "admin/tenant.html.twig", "/var/www/html/proyecto/templates/admin/tenant.html.twig");
    }
}
