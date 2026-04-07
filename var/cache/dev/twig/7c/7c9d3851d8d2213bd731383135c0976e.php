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

/* @Maker/form/Type.tpl.php */
class __TwigTemplate_14625c8f86487abc0f671bca6db14ea4 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/form/Type.tpl.php"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/form/Type.tpl.php"));

        // line 1
        yield "<?= \"<?php\\n\" ?>

namespace <?= \$namespace ?>;

<?= \$use_statements; ?>

class <?= \$class_name ?> extends AbstractType
{
    public function buildForm(FormBuilderInterface \$builder, array \$options): void
    {
        \$builder
<?php foreach (\$form_fields as \$form_field => \$typeOptions): ?>
<?php if (null === \$typeOptions['type'] && !\$typeOptions['options_code']): ?>
            ->add('<?= \$form_field ?>')
<?php elseif (null !== \$typeOptions['type'] && !\$typeOptions['options_code']): ?>
            ->add('<?= \$form_field ?>', <?= \$typeOptions['type'] ?>::class)
<?php else: ?>
            ->add('<?= \$form_field ?>', <?= \$typeOptions['type'] ? (\$typeOptions['type'].'::class') : 'null' ?>, [
                <?= \$typeOptions['options_code'].\"\\n\" ?>
            ])
<?php endif; ?>
<?php endforeach; ?>
        ;
    }

    public function configureOptions(OptionsResolver \$resolver): void
    {
        \$resolver->setDefaults([
<?php if (\$bounded_class_name): ?>
            'data_class' => <?= \$bounded_class_name ?>::class,
<?php else: ?>
            // Configure your form options here
<?php endif ?>
        ]);
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
        return "@Maker/form/Type.tpl.php";
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

namespace <?= \$namespace ?>;

<?= \$use_statements; ?>

class <?= \$class_name ?> extends AbstractType
{
    public function buildForm(FormBuilderInterface \$builder, array \$options): void
    {
        \$builder
<?php foreach (\$form_fields as \$form_field => \$typeOptions): ?>
<?php if (null === \$typeOptions['type'] && !\$typeOptions['options_code']): ?>
            ->add('<?= \$form_field ?>')
<?php elseif (null !== \$typeOptions['type'] && !\$typeOptions['options_code']): ?>
            ->add('<?= \$form_field ?>', <?= \$typeOptions['type'] ?>::class)
<?php else: ?>
            ->add('<?= \$form_field ?>', <?= \$typeOptions['type'] ? (\$typeOptions['type'].'::class') : 'null' ?>, [
                <?= \$typeOptions['options_code'].\"\\n\" ?>
            ])
<?php endif; ?>
<?php endforeach; ?>
        ;
    }

    public function configureOptions(OptionsResolver \$resolver): void
    {
        \$resolver->setDefaults([
<?php if (\$bounded_class_name): ?>
            'data_class' => <?= \$bounded_class_name ?>::class,
<?php else: ?>
            // Configure your form options here
<?php endif ?>
        ]);
    }
}
", "@Maker/form/Type.tpl.php", "/var/www/html/proyecto/vendor/symfony/maker-bundle/templates/form/Type.tpl.php");
    }
}
