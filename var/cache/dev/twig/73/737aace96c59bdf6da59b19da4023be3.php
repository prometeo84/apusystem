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

/* profile/index.html.twig */
class __TwigTemplate_a71214dbfe2ee218dfc5e0d11357f876 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "profile/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "profile/index.html.twig"));

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

        yield "Mi Perfil - APU System";
        
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
        yield from $this->load("partials/_navbar.html.twig", 10)->unwrap()->yield(CoreExtension::merge($context, ["title" => $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("profile.title")]));
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
            ";
        // line 20
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new RuntimeError('Variable "app" does not exist.', 20, $this->source); })()), "flashes", ["error"], "method", false, false, false, 20));
        foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
            // line 21
            yield "                <div class=\"alert alert-danger alert-dismissible fade show\">
                    <i class=\"bi bi-exclamation-triangle-fill\"></i> ";
            // line 22
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($context["message"], "html", null, true);
            yield "
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['message'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 26
        yield "
            <div class=\"row\">
                <div class=\"col-md-4\">
                    <div class=\"card mb-4\">
                        <div class=\"card-body text-center\">
                            ";
        // line 31
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 31, $this->source); })()), "avatar", [], "any", false, false, false, 31)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 32
            yield "                                <img src=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 32, $this->source); })()), "avatar", [], "any", false, false, false, 32), "html", null, true);
            yield "\" alt=\"Avatar\" class=\"rounded-circle mx-auto mb-3\" style=\"width: 100px; height: 100px; object-fit: cover; border: 3px solid var(--primary-color);\">
                            ";
        } else {
            // line 34
            yield "                                <div class=\"bg-primary rounded-circle text-white mx-auto mb-3 d-flex align-items-center justify-content-center\"
                                     style=\"width: 100px; height: 100px; font-size: 2.5rem;\">
                                    ";
            // line 36
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::first($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 36, $this->source); })()), "firstName", [], "any", false, false, false, 36)), "html", null, true);
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::first($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 36, $this->source); })()), "lastName", [], "any", false, false, false, 36)), "html", null, true);
            yield "
                                </div>
                            ";
        }
        // line 39
        yield "                            <h4>";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 39, $this->source); })()), "fullName", [], "any", false, false, false, 39), "html", null, true);
        yield "</h4>
                            <p class=\"text-muted\">";
        // line 40
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 40, $this->source); })()), "email", [], "any", false, false, false, 40), "html", null, true);
        yield "</p>
                            <p class=\"mb-3\">
                                <span class=\"badge bg-secondary\">";
        // line 42
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 42, $this->source); })()), "role", [], "any", false, false, false, 42)), "html", null, true);
        yield "</span>
                            </p>
                            <a href=\"";
        // line 44
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_profile_edit");
        yield "\" class=\"btn btn-primary btn-sm\">
                                <i class=\"bi bi-pencil\"></i> ";
        // line 45
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("buttons.edit"), "html", null, true);
        yield " ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("profile.title"), "html", null, true);
        yield "
                            </a>
                        </div>
                    </div>

                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title mb-3\">";
        // line 52
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.account_information"), "html", null, true);
        yield "</h5>
                            <ul class=\"list-unstyled\">
                                <li class=\"mb-2\">
                                    <i class=\"bi bi-calendar-check text-primary\"></i>
                                    <strong>";
        // line 56
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.member_since"), "html", null, true);
        yield ":</strong><br>
                                    <span class=\"ms-4\">";
        // line 57
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 57, $this->source); })()), "createdAt", [], "any", false, false, false, 57), "d/m/Y"), "html", null, true);
        yield "</span>
                                </li>
                                ";
        // line 59
        if ((($tmp =  !$this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_SUPER_ADMIN")) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 60
            yield "                                <li class=\"mb-2\">
                                    <i class=\"bi bi-building text-primary\"></i>
                                    <strong>";
            // line 62
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.company"), "html", null, true);
            yield ":</strong><br>
                                    <span class=\"ms-4\">";
            // line 63
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["tenant"]) || array_key_exists("tenant", $context) ? $context["tenant"] : (function () { throw new RuntimeError('Variable "tenant" does not exist.', 63, $this->source); })()), "name", [], "any", false, false, false, 63), "html", null, true);
            yield "</span>
                                </li>
                                ";
        }
        // line 66
        yield "                                <li class=\"mb-2\">
                                    <i class=\"bi bi-clock-history text-primary\"></i>
                                    <strong>";
        // line 68
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.last_access"), "html", null, true);
        yield ":</strong><br>
                                    <span class=\"ms-4\">";
        // line 69
        yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 69, $this->source); })()), "lastLoginAt", [], "any", false, false, false, 69)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 69, $this->source); })()), "lastLoginAt", [], "any", false, false, false, 69), "d/m/Y H:i"), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.never"), "html", null, true)));
        yield "</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-8\">
                    <div class=\"card mb-4\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title mb-3\">
                                <i class=\"bi bi-person-circle\"></i> ";
        // line 80
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.personal_information"), "html", null, true);
        yield "
                            </h5>
                            <div class=\"row mb-3\">
                                <div class=\"col-md-6\">
                                    <label class=\"text-muted small\">";
        // line 84
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("profile.first_name"), "html", null, true);
        yield "</label>
                                    <p class=\"mb-0\">";
        // line 85
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 85, $this->source); })()), "firstName", [], "any", false, false, false, 85), "html", null, true);
        yield "</p>
                                </div>
                                <div class=\"col-md-6\">
                                    <label class=\"text-muted small\">";
        // line 88
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("profile.last_name"), "html", null, true);
        yield "</label>
                                    <p class=\"mb-0\">";
        // line 89
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 89, $this->source); })()), "lastName", [], "any", false, false, false, 89), "html", null, true);
        yield "</p>
                                </div>
                            </div>
                            <div class=\"row mb-3\">
                                <div class=\"col-md-6\">
                                    <label class=\"text-muted small\">";
        // line 94
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("profile.email"), "html", null, true);
        yield "</label>
                                    <p class=\"mb-0\">";
        // line 95
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 95, $this->source); })()), "email", [], "any", false, false, false, 95), "html", null, true);
        yield "</p>
                                </div>
                                <div class=\"col-md-6\">
                                    <label class=\"text-muted small\">";
        // line 98
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("profile.username"), "html", null, true);
        yield "</label>
                                    <p class=\"mb-0\">";
        // line 99
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 99, $this->source); })()), "username", [], "any", false, false, false, 99), "html", null, true);
        yield "</p>
                                </div>
                            </div>
                            <div class=\"row\">
                                <div class=\"col-md-6\">
                                    <label class=\"text-muted small\">";
        // line 104
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("profile.phone"), "html", null, true);
        yield "</label>
                                    <p class=\"mb-0\">";
        // line 105
        yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 105, $this->source); })()), "phone", [], "any", false, false, false, 105)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 105, $this->source); })()), "phone", [], "any", false, false, false, 105), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.not_specified"), "html", null, true)));
        yield "</p>
                                </div>
                                <div class=\"col-md-6\">
                                    <label class=\"text-muted small\">";
        // line 108
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.role"), "html", null, true);
        yield "</label>
                                    <p class=\"mb-0\">
                                        <span class=\"badge bg-secondary\">";
        // line 110
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(Twig\Extension\CoreExtension::upper($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 110, $this->source); })()), "role", [], "any", false, false, false, 110)), "html", null, true);
        yield "</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"row\">
                        <div class=\"col-md-6 mb-4\">
                            <div class=\"card h-100\">
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\">
                                        <i class=\"bi bi-key-fill\"></i> ";
        // line 122
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.title"), "html", null, true);
        yield "
                                    </h5>
                                    <p class=\"text-muted\">";
        // line 124
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.last_update"), "html", null, true);
        yield ":
                                        ";
        // line 125
        yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 125, $this->source); })()), "passwordChangedAt", [], "any", false, false, false, 125)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate(CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 125, $this->source); })()), "passwordChangedAt", [], "any", false, false, false, 125), "d/m/Y"), "html", null, true)) : ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("common.never"), "html", null, true)));
        yield "
                                    </p>
                                    <a href=\"";
        // line 127
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_profile_change_password");
        yield "\" class=\"btn btn-outline-primary\">
                                        <i class=\"bi bi-shield-lock\"></i> ";
        // line 128
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("password.change"), "html", null, true);
        yield "
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class=\"col-md-6 mb-4\">
                            <div class=\"card h-100\">
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\">
                                        <i class=\"bi bi-shield-check\"></i> ";
        // line 138
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.title"), "html", null, true);
        yield "
                                    </h5>
                                    <p class=\"text-muted\">
                                        2FA:
                                        ";
        // line 142
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, (isset($context["user"]) || array_key_exists("user", $context) ? $context["user"] : (function () { throw new RuntimeError('Variable "user" does not exist.', 142, $this->source); })()), "twoFactorEnabled", [], "any", false, false, false, 142)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 143
            yield "                                            <span class=\"badge bg-success\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.enabled"), "html", null, true);
            yield "</span>
                                        ";
        } else {
            // line 145
            yield "                                            <span class=\"badge bg-warning\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.disabled"), "html", null, true);
            yield "</span>
                                        ";
        }
        // line 147
        yield "                                    </p>
                                    <a href=\"";
        // line 148
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_security");
        yield "\" class=\"btn btn-outline-primary\">
                                        <i class=\"bi bi-gear\"></i> ";
        // line 149
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("security.configure"), "html", null, true);
        yield "
                                    </a>
                                </div>
                            </div>
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
        return "profile/index.html.twig";
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
        return array (  403 => 149,  399 => 148,  396 => 147,  390 => 145,  384 => 143,  382 => 142,  375 => 138,  362 => 128,  358 => 127,  353 => 125,  349 => 124,  344 => 122,  329 => 110,  324 => 108,  318 => 105,  314 => 104,  306 => 99,  302 => 98,  296 => 95,  292 => 94,  284 => 89,  280 => 88,  274 => 85,  270 => 84,  263 => 80,  249 => 69,  245 => 68,  241 => 66,  235 => 63,  231 => 62,  227 => 60,  225 => 59,  220 => 57,  216 => 56,  209 => 52,  197 => 45,  193 => 44,  188 => 42,  183 => 40,  178 => 39,  171 => 36,  167 => 34,  161 => 32,  159 => 31,  152 => 26,  142 => 22,  139 => 21,  135 => 20,  132 => 19,  122 => 15,  119 => 14,  115 => 13,  111 => 11,  109 => 10,  105 => 8,  103 => 7,  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Mi Perfil - APU System{% endblock %}

{% block body %}
<div class=\"d-flex\">
    {% include 'partials/_sidebar.html.twig' %}

    <div class=\"flex-grow-1\">
        {% include 'partials/_navbar.html.twig' with {'title': 'profile.title'|trans} %}

        <div class=\"container-fluid p-4 content-wrapper\">
            {% for message in app.flashes('success') %}
                <div class=\"alert alert-success alert-dismissible fade show\">
                    <i class=\"bi bi-check-circle-fill\"></i> {{ message }}
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            {% endfor %}

            {% for message in app.flashes('error') %}
                <div class=\"alert alert-danger alert-dismissible fade show\">
                    <i class=\"bi bi-exclamation-triangle-fill\"></i> {{ message }}
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
                </div>
            {% endfor %}

            <div class=\"row\">
                <div class=\"col-md-4\">
                    <div class=\"card mb-4\">
                        <div class=\"card-body text-center\">
                            {% if user.avatar %}
                                <img src=\"{{ user.avatar }}\" alt=\"Avatar\" class=\"rounded-circle mx-auto mb-3\" style=\"width: 100px; height: 100px; object-fit: cover; border: 3px solid var(--primary-color);\">
                            {% else %}
                                <div class=\"bg-primary rounded-circle text-white mx-auto mb-3 d-flex align-items-center justify-content-center\"
                                     style=\"width: 100px; height: 100px; font-size: 2.5rem;\">
                                    {{ user.firstName|first }}{{ user.lastName|first }}
                                </div>
                            {% endif %}
                            <h4>{{ user.fullName }}</h4>
                            <p class=\"text-muted\">{{ user.email }}</p>
                            <p class=\"mb-3\">
                                <span class=\"badge bg-secondary\">{{ user.role|upper }}</span>
                            </p>
                            <a href=\"{{ path('app_profile_edit') }}\" class=\"btn btn-primary btn-sm\">
                                <i class=\"bi bi-pencil\"></i> {{ 'buttons.edit'|trans }} {{ 'profile.title'|trans }}
                            </a>
                        </div>
                    </div>

                    <div class=\"card\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title mb-3\">{{ 'common.account_information'|trans }}</h5>
                            <ul class=\"list-unstyled\">
                                <li class=\"mb-2\">
                                    <i class=\"bi bi-calendar-check text-primary\"></i>
                                    <strong>{{ 'common.member_since'|trans }}:</strong><br>
                                    <span class=\"ms-4\">{{ user.createdAt|date('d/m/Y') }}</span>
                                </li>
                                {% if not is_granted('ROLE_SUPER_ADMIN') %}
                                <li class=\"mb-2\">
                                    <i class=\"bi bi-building text-primary\"></i>
                                    <strong>{{ 'common.company'|trans }}:</strong><br>
                                    <span class=\"ms-4\">{{ tenant.name }}</span>
                                </li>
                                {% endif %}
                                <li class=\"mb-2\">
                                    <i class=\"bi bi-clock-history text-primary\"></i>
                                    <strong>{{ 'common.last_access'|trans }}:</strong><br>
                                    <span class=\"ms-4\">{{ user.lastLoginAt ? user.lastLoginAt|date('d/m/Y H:i') : ('common.never'|trans) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class=\"col-md-8\">
                    <div class=\"card mb-4\">
                        <div class=\"card-body\">
                            <h5 class=\"card-title mb-3\">
                                <i class=\"bi bi-person-circle\"></i> {{ 'common.personal_information'|trans }}
                            </h5>
                            <div class=\"row mb-3\">
                                <div class=\"col-md-6\">
                                    <label class=\"text-muted small\">{{ 'profile.first_name'|trans }}</label>
                                    <p class=\"mb-0\">{{ user.firstName }}</p>
                                </div>
                                <div class=\"col-md-6\">
                                    <label class=\"text-muted small\">{{ 'profile.last_name'|trans }}</label>
                                    <p class=\"mb-0\">{{ user.lastName }}</p>
                                </div>
                            </div>
                            <div class=\"row mb-3\">
                                <div class=\"col-md-6\">
                                    <label class=\"text-muted small\">{{ 'profile.email'|trans }}</label>
                                    <p class=\"mb-0\">{{ user.email }}</p>
                                </div>
                                <div class=\"col-md-6\">
                                    <label class=\"text-muted small\">{{ 'profile.username'|trans }}</label>
                                    <p class=\"mb-0\">{{ user.username }}</p>
                                </div>
                            </div>
                            <div class=\"row\">
                                <div class=\"col-md-6\">
                                    <label class=\"text-muted small\">{{ 'profile.phone'|trans }}</label>
                                    <p class=\"mb-0\">{{ user.phone ? user.phone : ('common.not_specified'|trans) }}</p>
                                </div>
                                <div class=\"col-md-6\">
                                    <label class=\"text-muted small\">{{ 'common.role'|trans }}</label>
                                    <p class=\"mb-0\">
                                        <span class=\"badge bg-secondary\">{{ user.role|upper }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=\"row\">
                        <div class=\"col-md-6 mb-4\">
                            <div class=\"card h-100\">
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\">
                                        <i class=\"bi bi-key-fill\"></i> {{ 'password.title'|trans }}
                                    </h5>
                                    <p class=\"text-muted\">{{ 'password.last_update'|trans }}:
                                        {{ user.passwordChangedAt ? user.passwordChangedAt|date('d/m/Y') : ('common.never'|trans) }}
                                    </p>
                                    <a href=\"{{ path('app_profile_change_password') }}\" class=\"btn btn-outline-primary\">
                                        <i class=\"bi bi-shield-lock\"></i> {{ 'password.change'|trans }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class=\"col-md-6 mb-4\">
                            <div class=\"card h-100\">
                                <div class=\"card-body\">
                                    <h5 class=\"card-title\">
                                        <i class=\"bi bi-shield-check\"></i> {{ 'security.title'|trans }}
                                    </h5>
                                    <p class=\"text-muted\">
                                        2FA:
                                        {% if user.twoFactorEnabled %}
                                            <span class=\"badge bg-success\">{{ 'security.enabled'|trans }}</span>
                                        {% else %}
                                            <span class=\"badge bg-warning\">{{ 'security.disabled'|trans }}</span>
                                        {% endif %}
                                    </p>
                                    <a href=\"{{ path('app_security') }}\" class=\"btn btn-outline-primary\">
                                        <i class=\"bi bi-gear\"></i> {{ 'security.configure'|trans }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{% endblock %}
", "profile/index.html.twig", "/var/www/html/proyecto/templates/profile/index.html.twig");
    }
}
