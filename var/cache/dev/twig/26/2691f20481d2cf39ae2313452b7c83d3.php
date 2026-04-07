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

/* @Maker/serializer/Normalizer.tpl.php */
class __TwigTemplate_0ab8c206758da61bc9e60f71f15cc515 extends Template
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

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/serializer/Normalizer.tpl.php"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/serializer/Normalizer.tpl.php"));

        // line 1
        yield "<?= \"<?php\\n\" ?>

namespace <?= \$namespace; ?>;

<?= \$use_statements; ?>

class <?= \$class_name ?> implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface \$normalizer,
    ) {
    }

    public function normalize(\$object, ?string \$format = null, array \$context = []): array
    {
        \$data = \$this->normalizer->normalize(\$object, \$format, \$context);

        // TODO: add, edit, or delete some data

        return \$data;
    }

    public function supportsNormalization(\$data, ?string \$format = null, array \$context = []): bool
    {
<?php if (\$entity_exists): ?>
        return \$data instanceof <?= \$entity_name ?>;
<?php else: ?>
        // TODO: return \$data instanceof Object
<?php endif ?>
    }

    public function getSupportedTypes(?string \$format): array
    {
<?php if (\$entity_exists): ?>
        return [<?= \$entity_name ?>::class => true];
<?php else: ?>
        // TODO: return [Object::class => true];
<?php endif ?>
    }
}
";
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "@Maker/serializer/Normalizer.tpl.php";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  48 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<?= \"<?php\\n\" ?>

namespace <?= \$namespace; ?>;

<?= \$use_statements; ?>

class <?= \$class_name ?> implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface \$normalizer,
    ) {
    }

    public function normalize(\$object, ?string \$format = null, array \$context = []): array
    {
        \$data = \$this->normalizer->normalize(\$object, \$format, \$context);

        // TODO: add, edit, or delete some data

        return \$data;
    }

    public function supportsNormalization(\$data, ?string \$format = null, array \$context = []): bool
    {
<?php if (\$entity_exists): ?>
        return \$data instanceof <?= \$entity_name ?>;
<?php else: ?>
        // TODO: return \$data instanceof Object
<?php endif ?>
    }

    public function getSupportedTypes(?string \$format): array
    {
<?php if (\$entity_exists): ?>
        return [<?= \$entity_name ?>::class => true];
<?php else: ?>
        // TODO: return [Object::class => true];
<?php endif ?>
    }
}
", "@Maker/serializer/Normalizer.tpl.php", "/var/www/html/proyecto/vendor/symfony/maker-bundle/templates/serializer/Normalizer.tpl.php");
    }
}
