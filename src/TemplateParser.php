<?php
namespace MawebDK\TemplateParser;

/**
 * Parser for PHP templates.
 */
class TemplateParser
{
    /**
     * @var string   Template filename.
     */
    private string $filename;

    /**
     * @var array   Template variables.
     */
    private array $vars = [];

    /**
     * Constructor.
     * @param string $filename           Template filename.
     * @throws TemplateParserException   Template file not found.
     */
    public function __construct(string $filename)
    {
        if (!file_exists(filename: $filename)):
            throw new TemplateParserException(message: sprintf('Template file "%s" not found.', $filename));
        endif;

        $this->filename = $filename;
    }

    /**
     * Sets a template variable to be used when parsing the template.
     * @param string $name   Name of template variable.
     * @param mixed $value   Value of template variable.
     */
    public function setVar(string $name, mixed $value): void
    {
        $this->vars[$name] = $value;
    }

    /**
     * Parse the template and return the parsed template.
     * @return string                    Parsed template.
     * @throws TemplateParserException   Template file not found or failed to parse template.
     */
    public function parse(): string
    {
        if (!file_exists(filename: $this->filename)):
            throw new TemplateParserException(message: sprintf('Template file "%s" not found.', $this->filename));
        endif;

        if (!ob_start()):              // Start output buffering.
            throw new TemplateParserException(message: 'Failed to start output buffering.');
        endif;

        extract($this->vars);   // Make template variables available for the template file.
        require $this->filename;       // Include/parse template file.
        return ob_get_clean();         // Return output and stop output buffering.
    }
}