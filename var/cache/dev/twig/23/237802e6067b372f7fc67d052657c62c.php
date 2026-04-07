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

/* @Maker/webhook/RequestParser.tpl.php */
class __TwigTemplate_593ad324f2e97f2130d1f68200050139 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/webhook/RequestParser.tpl.php"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@Maker/webhook/RequestParser.tpl.php"));

        // line 1
        yield "<?= \"<?php\\n\" ?>

namespace <?= \$namespace; ?>;

<?= \$use_statements; ?>

final class <?= \$class_name ?> extends AbstractRequestParser
{
    protected function getRequestMatcher(): RequestMatcherInterface
    {
        <?php if (\$use_chained_requests_matcher) : ?>
        return new ChainRequestMatcher([
            <?= empty(\$request_matchers) ? '// Add RequestMatchers to fit your needs' : '' ?>

            <?php foreach (\$request_matchers as \$request_matcher) : ?>
            new <?= Symfony\\Bundle\\MakerBundle\\Str::getShortClassName(\$request_matcher) ?>(<?= \$request_matcher_arguments[\$request_matcher] ?>),
            <?php endforeach; ?>
        ]);
        <?php else : ?>
        return new <?= Symfony\\Bundle\\MakerBundle\\Str::getShortClassName(\$request_matchers[0]) ?>(<?= \$request_matcher_arguments[\$request_matchers[0]] ?>);
        <?php endif; ?>
    }

    /**
     * @throws JsonException
     */
    protected function doParse(Request \$request, #[\\SensitiveParameter] string \$secret): ?RemoteEvent
    {
        // TODO: Adapt or replace the content of this method to fit your need.

        // Validate the request against \$secret.
        \$authToken = \$request->headers->get('X-Authentication-Token');
        if (\$authToken !== \$secret) {
            throw new RejectWebhookException(Response::HTTP_UNAUTHORIZED, 'Invalid authentication token.');
        }

        // Validate the request payload.
        if (!\$request->getPayload()->has('name')
            || !\$request->getPayload()->has('id')) {
            throw new RejectWebhookException(Response::HTTP_BAD_REQUEST, 'Request payload does not contain required fields.');
        }

        // Parse the request payload and return a RemoteEvent object.
        \$payload = \$request->getPayload();

        return new RemoteEvent(
            \$payload->getString('name'),
            \$payload->getString('id'),
            \$payload->all(),
        );
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
        return "@Maker/webhook/RequestParser.tpl.php";
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

final class <?= \$class_name ?> extends AbstractRequestParser
{
    protected function getRequestMatcher(): RequestMatcherInterface
    {
        <?php if (\$use_chained_requests_matcher) : ?>
        return new ChainRequestMatcher([
            <?= empty(\$request_matchers) ? '// Add RequestMatchers to fit your needs' : '' ?>

            <?php foreach (\$request_matchers as \$request_matcher) : ?>
            new <?= Symfony\\Bundle\\MakerBundle\\Str::getShortClassName(\$request_matcher) ?>(<?= \$request_matcher_arguments[\$request_matcher] ?>),
            <?php endforeach; ?>
        ]);
        <?php else : ?>
        return new <?= Symfony\\Bundle\\MakerBundle\\Str::getShortClassName(\$request_matchers[0]) ?>(<?= \$request_matcher_arguments[\$request_matchers[0]] ?>);
        <?php endif; ?>
    }

    /**
     * @throws JsonException
     */
    protected function doParse(Request \$request, #[\\SensitiveParameter] string \$secret): ?RemoteEvent
    {
        // TODO: Adapt or replace the content of this method to fit your need.

        // Validate the request against \$secret.
        \$authToken = \$request->headers->get('X-Authentication-Token');
        if (\$authToken !== \$secret) {
            throw new RejectWebhookException(Response::HTTP_UNAUTHORIZED, 'Invalid authentication token.');
        }

        // Validate the request payload.
        if (!\$request->getPayload()->has('name')
            || !\$request->getPayload()->has('id')) {
            throw new RejectWebhookException(Response::HTTP_BAD_REQUEST, 'Request payload does not contain required fields.');
        }

        // Parse the request payload and return a RemoteEvent object.
        \$payload = \$request->getPayload();

        return new RemoteEvent(
            \$payload->getString('name'),
            \$payload->getString('id'),
            \$payload->all(),
        );
    }
}
", "@Maker/webhook/RequestParser.tpl.php", "/var/www/html/proyecto/vendor/symfony/maker-bundle/templates/webhook/RequestParser.tpl.php");
    }
}
