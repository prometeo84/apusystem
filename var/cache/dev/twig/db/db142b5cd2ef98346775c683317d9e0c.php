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

/* @Maker/doctrine/Entity.tpl.php */
class __TwigTemplate_ade54527cd06193b116bc0c544ae3495 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/doctrine/Entity.tpl.php"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/doctrine/Entity.tpl.php"));

        // line 1
        yield "<?php

use Symfony\\Bundle\\MakerBundle\\Maker\\Common\\EntityIdTypeEnum;

?>
<?= \"<?php\\n\" ?>

namespace <?= \$namespace ?>;

<?= \$use_statements; ?>

#[ORM\\Entity(repositoryClass: <?= \$repository_class_name ?>::class)]
<?php if (\$should_escape_table_name): ?>#[ORM\\Table(name: '`<?= \$table_name ?>`')]
<?php endif ?>
<?php if (\$api_resource): ?>
#[ApiResource]
<?php endif ?>
<?php if (\$broadcast): ?>
#[Broadcast]
<?php endif ?>
class <?= \$class_name.\"\\n\" ?>
{
<?php if (EntityIdTypeEnum::UUID === \$id_type): ?>
    #[ORM\\Id]
    #[ORM\\Column(type: UuidType::NAME, unique: true)]
    #[ORM\\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid \$id = null;

    public function getId(): ?Uuid
    {
        return \$this->id;
    }
<?php elseif (EntityIdTypeEnum::ULID === \$id_type): ?>
    #[ORM\\Id]
    #[ORM\\Column(type: UlidType::NAME, unique: true)]
    #[ORM\\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\\CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private ?Ulid \$id = null;

    public function getId(): ?Ulid
    {
        return \$this->id;
    }
<?php else: ?>
    #[ORM\\Id]
    #[ORM\\GeneratedValue]
    #[ORM\\Column]
    private ?int \$id = null;

    public function getId(): ?int
    {
        return \$this->id;
    }
<?php endif ?>
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
        return "@Maker/doctrine/Entity.tpl.php";
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
        return new Source("<?php

use Symfony\\Bundle\\MakerBundle\\Maker\\Common\\EntityIdTypeEnum;

?>
<?= \"<?php\\n\" ?>

namespace <?= \$namespace ?>;

<?= \$use_statements; ?>

#[ORM\\Entity(repositoryClass: <?= \$repository_class_name ?>::class)]
<?php if (\$should_escape_table_name): ?>#[ORM\\Table(name: '`<?= \$table_name ?>`')]
<?php endif ?>
<?php if (\$api_resource): ?>
#[ApiResource]
<?php endif ?>
<?php if (\$broadcast): ?>
#[Broadcast]
<?php endif ?>
class <?= \$class_name.\"\\n\" ?>
{
<?php if (EntityIdTypeEnum::UUID === \$id_type): ?>
    #[ORM\\Id]
    #[ORM\\Column(type: UuidType::NAME, unique: true)]
    #[ORM\\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid \$id = null;

    public function getId(): ?Uuid
    {
        return \$this->id;
    }
<?php elseif (EntityIdTypeEnum::ULID === \$id_type): ?>
    #[ORM\\Id]
    #[ORM\\Column(type: UlidType::NAME, unique: true)]
    #[ORM\\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\\CustomIdGenerator(class: 'doctrine.ulid_generator')]
    private ?Ulid \$id = null;

    public function getId(): ?Ulid
    {
        return \$this->id;
    }
<?php else: ?>
    #[ORM\\Id]
    #[ORM\\GeneratedValue]
    #[ORM\\Column]
    private ?int \$id = null;

    public function getId(): ?int
    {
        return \$this->id;
    }
<?php endif ?>
}
", "@Maker/doctrine/Entity.tpl.php", "/var/www/html/proyecto/vendor/symfony/maker-bundle/templates/doctrine/Entity.tpl.php");
    }
}
