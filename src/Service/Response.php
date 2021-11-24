<?php

namespace Service;

use Twig\TemplateWrapper;

/**
 * @author Jayson Fong <contact@jaysonfong.org>
 */
class Response extends Component
{

    protected TemplateWrapper $templateWrapper;
    protected array $variables;

    public function __construct(App $app, string $templateName, array $variables = [])
    {
        parent::__construct($app);

        $this->variables = $variables;
        $this->templateWrapper = $this
            ->app->templateEnvironment()
            ->load($templateName . '.html.twig');
    }

    public function display(): void
    {
        $this->templateWrapper->display($this->variables);
    }

    public function render(): string
    {
        return $this->templateWrapper->render($this->variables);
    }

}