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

/* @Maker/doctrine/Repository.tpl.php */
class __TwigTemplate_0ece035c5427c4dc12d79734f5a3fd92 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/doctrine/Repository.tpl.php"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/doctrine/Repository.tpl.php"));

        // line 1
        yield "<?= \"<?php\\n\"; ?>

namespace <?= \$namespace; ?>;

<?= \$use_statements; ?>

/**
 * @extends ServiceEntityRepository<<?= \$entity_class_name; ?>>
 */
class <?= \$class_name; ?> extends ServiceEntityRepository<?= \$with_password_upgrade ? \" implements PasswordUpgraderInterface\\n\" : \"\\n\" ?>
{
    public function __construct(ManagerRegistry \$registry)
    {
        parent::__construct(\$registry, <?= \$entity_class_name; ?>::class);
    }
<?php if (\$include_example_comments): // When adding a new method without existing default comments, the blank line is automatically added.?>

<?php endif; ?>
<?php if (\$with_password_upgrade): ?>
    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(<?= sprintf('%s ', \$password_upgrade_user_interface->getShortName()); ?>\$user, string \$newHashedPassword): void
    {
        if (!\$user instanceof <?= \$entity_class_name ?>) {
            throw new UnsupportedUserException(sprintf('Instances of \"%s\" are not supported.', \$user::class));
        }

        \$user->setPassword(\$newHashedPassword);
        \$this->getEntityManager()->persist(\$user);
        \$this->getEntityManager()->flush();
    }

<?php endif ?>
<?php if (\$include_example_comments): ?>
//    /**
//     * @return <?= \$entity_class_name ?>[] Returns an array of <?= \$entity_class_name ?> objects
//     */
//    public function findByExampleField(\$value): array
//    {
//        return \$this->createQueryBuilder('<?= \$entity_alias; ?>')
//            ->andWhere('<?= \$entity_alias; ?>.exampleField = :val')
//            ->setParameter('val', \$value)
//            ->orderBy('<?= \$entity_alias; ?>.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField(\$value): ?<?= \$entity_class_name.\"\\n\" ?>
//    {
//        return \$this->createQueryBuilder('<?= \$entity_alias ?>')
//            ->andWhere('<?= \$entity_alias ?>.exampleField = :val')
//            ->setParameter('val', \$value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
<?php endif; ?>
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
        return "@Maker/doctrine/Repository.tpl.php";
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
        return new Source("<?= \"<?php\\n\"; ?>

namespace <?= \$namespace; ?>;

<?= \$use_statements; ?>

/**
 * @extends ServiceEntityRepository<<?= \$entity_class_name; ?>>
 */
class <?= \$class_name; ?> extends ServiceEntityRepository<?= \$with_password_upgrade ? \" implements PasswordUpgraderInterface\\n\" : \"\\n\" ?>
{
    public function __construct(ManagerRegistry \$registry)
    {
        parent::__construct(\$registry, <?= \$entity_class_name; ?>::class);
    }
<?php if (\$include_example_comments): // When adding a new method without existing default comments, the blank line is automatically added.?>

<?php endif; ?>
<?php if (\$with_password_upgrade): ?>
    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(<?= sprintf('%s ', \$password_upgrade_user_interface->getShortName()); ?>\$user, string \$newHashedPassword): void
    {
        if (!\$user instanceof <?= \$entity_class_name ?>) {
            throw new UnsupportedUserException(sprintf('Instances of \"%s\" are not supported.', \$user::class));
        }

        \$user->setPassword(\$newHashedPassword);
        \$this->getEntityManager()->persist(\$user);
        \$this->getEntityManager()->flush();
    }

<?php endif ?>
<?php if (\$include_example_comments): ?>
//    /**
//     * @return <?= \$entity_class_name ?>[] Returns an array of <?= \$entity_class_name ?> objects
//     */
//    public function findByExampleField(\$value): array
//    {
//        return \$this->createQueryBuilder('<?= \$entity_alias; ?>')
//            ->andWhere('<?= \$entity_alias; ?>.exampleField = :val')
//            ->setParameter('val', \$value)
//            ->orderBy('<?= \$entity_alias; ?>.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField(\$value): ?<?= \$entity_class_name.\"\\n\" ?>
//    {
//        return \$this->createQueryBuilder('<?= \$entity_alias ?>')
//            ->andWhere('<?= \$entity_alias ?>.exampleField = :val')
//            ->setParameter('val', \$value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
<?php endif; ?>
}
", "@Maker/doctrine/Repository.tpl.php", "/var/www/html/proyecto/vendor/symfony/maker-bundle/templates/doctrine/Repository.tpl.php");
    }
}
