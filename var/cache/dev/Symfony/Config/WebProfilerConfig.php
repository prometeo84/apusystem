<?php

namespace Symfony\Config;

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This class is automatically generated to help in creating a config.
 */
class WebProfilerConfig implements \Symfony\Component\Config\Builder\ConfigBuilderInterface
{
    private $toolbar;
    private $interceptRedirects;
    private $excludedAjaxPaths;
    private $_usedProperties = [];
    private $_hasDeprecatedCalls = false;

    /**
     * @default false
     * @param ParamConfigurator|bool $value
     * @return $this
     * @deprecated since Symfony 7.4
     */
    public function toolbar($value): static
    {
        $this->_hasDeprecatedCalls = true;
        $this->_usedProperties['toolbar'] = true;
        $this->toolbar = $value;

        return $this;
    }

    /**
     * @default false
     * @param ParamConfigurator|bool $value
     * @return $this
     * @deprecated since Symfony 7.4
     */
    public function interceptRedirects($value): static
    {
        $this->_hasDeprecatedCalls = true;
        $this->_usedProperties['interceptRedirects'] = true;
        $this->interceptRedirects = $value;

        return $this;
    }

    /**
     * @default '^/((index|app(_[\\w]+)?)\\.php/)?_wdt'
     * @param ParamConfigurator|mixed $value
     * @return $this
     * @deprecated since Symfony 7.4
     */
    public function excludedAjaxPaths($value): static
    {
        $this->_hasDeprecatedCalls = true;
        $this->_usedProperties['excludedAjaxPaths'] = true;
        $this->excludedAjaxPaths = $value;

        return $this;
    }

    public function getExtensionAlias(): string
    {
        return 'web_profiler';
    }

    public function __construct(array $config = [])
    {
        if (array_key_exists('toolbar', $config)) {
            $this->_usedProperties['toolbar'] = true;
            $this->toolbar = $config['toolbar'];
            unset($config['toolbar']);
        }

        if (array_key_exists('intercept_redirects', $config)) {
            $this->_usedProperties['interceptRedirects'] = true;
            $this->interceptRedirects = $config['intercept_redirects'];
            unset($config['intercept_redirects']);
        }

        if (array_key_exists('excluded_ajax_paths', $config)) {
            $this->_usedProperties['excludedAjaxPaths'] = true;
            $this->excludedAjaxPaths = $config['excluded_ajax_paths'];
            unset($config['excluded_ajax_paths']);
        }

        if ($config) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($config)));
        }
    }

    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['toolbar'])) {
            $output['toolbar'] = $this->toolbar;
        }
        if (isset($this->_usedProperties['interceptRedirects'])) {
            $output['intercept_redirects'] = $this->interceptRedirects;
        }
        if (isset($this->_usedProperties['excludedAjaxPaths'])) {
            $output['excluded_ajax_paths'] = $this->excludedAjaxPaths;
        }
        if ($this->_hasDeprecatedCalls) {
            trigger_deprecation('symfony/config', '7.4', 'Calling any fluent method on "%s" is deprecated; pass the configuration to the constructor instead.', $this::class);
        }

        return $output;
    }

}
