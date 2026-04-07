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

/* @Maker/command/Command.tpl.php */
class __TwigTemplate_5c9e92967e85b065a2617ece4783e3c9 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/command/Command.tpl.php"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/command/Command.tpl.php"));

        // line 1
        yield "<?= \"<?php\\n\"; ?>

namespace <?= \$namespace; ?>;

<?= \$use_statements; ?>

#[AsCommand(
    name: '<?= \$command_name; ?>',
    description: 'Add a short description for your command',
)]
class <?= \$class_name; ?> extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        \$this
<?= \$set_description ? \"            ->setDescription(self::\\\$defaultDescription)\\n\" : '' ?>
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface \$input, OutputInterface \$output): int
    {
        \$io = new SymfonyStyle(\$input, \$output);
        \$arg1 = \$input->getArgument('arg1');

        if (\$arg1) {
            \$io->note(sprintf('You passed an argument: %s', \$arg1));
        }

        if (\$input->getOption('option1')) {
            // ...
        }

        \$io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
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
        return "@Maker/command/Command.tpl.php";
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

#[AsCommand(
    name: '<?= \$command_name; ?>',
    description: 'Add a short description for your command',
)]
class <?= \$class_name; ?> extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        \$this
<?= \$set_description ? \"            ->setDescription(self::\\\$defaultDescription)\\n\" : '' ?>
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface \$input, OutputInterface \$output): int
    {
        \$io = new SymfonyStyle(\$input, \$output);
        \$arg1 = \$input->getArgument('arg1');

        if (\$arg1) {
            \$io->note(sprintf('You passed an argument: %s', \$arg1));
        }

        if (\$input->getOption('option1')) {
            // ...
        }

        \$io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
", "@Maker/command/Command.tpl.php", "/var/www/html/proyecto/vendor/symfony/maker-bundle/templates/command/Command.tpl.php");
    }
}
