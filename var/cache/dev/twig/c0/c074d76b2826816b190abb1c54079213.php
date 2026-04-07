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

/* @Maker/verifyEmail/EmailVerifier.tpl.php */
class __TwigTemplate_0120ebad87234abe3e1ccb8344ebc009 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/verifyEmail/EmailVerifier.tpl.php"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/verifyEmail/EmailVerifier.tpl.php"));

        // line 1
        yield "<?= \"<?php\\n\" ?>

namespace <?= \$namespace; ?>;

<?= \$use_statements; ?>

class <?= \$class_name; ?><?= \"\\n\" ?>
{
    public function __construct(
        private VerifyEmailHelperInterface \$verifyEmailHelper,
        private MailerInterface \$mailer,
        private EntityManagerInterface \$entityManager
    ) {
    }

    public function sendEmailConfirmation(string \$verifyEmailRouteName, <?= \$user_class_name ?> \$user, TemplatedEmail \$email): void
    {
        \$signatureComponents = \$this->verifyEmailHelper->generateSignature(
            \$verifyEmailRouteName,
            (string) \$user-><?= \$id_getter ?>(),
<?php if (\$verify_email_anonymously): ?>
            (string) \$user-><?= \$email_getter ?>(),
            ['id' => \$user-><?= \$id_getter ?>()]
<?php else: ?>
            (string) \$user-><?= \$email_getter ?>()
<?php endif; ?>
        );

        \$context = \$email->getContext();
        \$context['signedUrl'] = \$signatureComponents->getSignedUrl();
        \$context['expiresAtMessageKey'] = \$signatureComponents->getExpirationMessageKey();
        \$context['expiresAtMessageData'] = \$signatureComponents->getExpirationMessageData();

        \$email->context(\$context);

        \$this->mailer->send(\$email);
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(Request \$request, <?= \$user_class_name ?> \$user): void
    {
        \$this->verifyEmailHelper->validateEmailConfirmationFromRequest(\$request, (string) \$user-><?= \$id_getter ?>(), (string) \$user-><?= \$email_getter?>());

        \$user->setIsVerified(true);

        \$this->entityManager->persist(\$user);
        \$this->entityManager->flush();
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
        return "@Maker/verifyEmail/EmailVerifier.tpl.php";
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

class <?= \$class_name; ?><?= \"\\n\" ?>
{
    public function __construct(
        private VerifyEmailHelperInterface \$verifyEmailHelper,
        private MailerInterface \$mailer,
        private EntityManagerInterface \$entityManager
    ) {
    }

    public function sendEmailConfirmation(string \$verifyEmailRouteName, <?= \$user_class_name ?> \$user, TemplatedEmail \$email): void
    {
        \$signatureComponents = \$this->verifyEmailHelper->generateSignature(
            \$verifyEmailRouteName,
            (string) \$user-><?= \$id_getter ?>(),
<?php if (\$verify_email_anonymously): ?>
            (string) \$user-><?= \$email_getter ?>(),
            ['id' => \$user-><?= \$id_getter ?>()]
<?php else: ?>
            (string) \$user-><?= \$email_getter ?>()
<?php endif; ?>
        );

        \$context = \$email->getContext();
        \$context['signedUrl'] = \$signatureComponents->getSignedUrl();
        \$context['expiresAtMessageKey'] = \$signatureComponents->getExpirationMessageKey();
        \$context['expiresAtMessageData'] = \$signatureComponents->getExpirationMessageData();

        \$email->context(\$context);

        \$this->mailer->send(\$email);
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(Request \$request, <?= \$user_class_name ?> \$user): void
    {
        \$this->verifyEmailHelper->validateEmailConfirmationFromRequest(\$request, (string) \$user-><?= \$id_getter ?>(), (string) \$user-><?= \$email_getter?>());

        \$user->setIsVerified(true);

        \$this->entityManager->persist(\$user);
        \$this->entityManager->flush();
    }
}
", "@Maker/verifyEmail/EmailVerifier.tpl.php", "/var/www/html/proyecto/vendor/symfony/maker-bundle/templates/verifyEmail/EmailVerifier.tpl.php");
    }
}
