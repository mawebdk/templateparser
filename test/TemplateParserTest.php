<?php
namespace MawebDK\TemplateParser\Test;

use MawebDK\TemplateParser\TemplateParser;
use MawebDK\TemplateParser\TemplateParserException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TemplateParserTest extends TestCase
{
    public function test__construct_TemplateParserException()
    {
        $filename = __DIR__ . '/testFiles/UnknownTemplate.php';

        $this->expectException(exception: TemplateParserException::class);
        $this->expectExceptionMessage(message: sprintf('Template file "%s" not found.', $filename));

        new TemplateParser(filename: $filename);
    }

    /**
     * @throws TemplateParserException
     */
    #[DataProvider('dataProviderParse')]
    public function testParse(string $filename, array $vars, string $expectedResult)
    {
        $templateParser = new TemplateParser(filename: $filename);

        foreach ($vars as $name => $value):
            $templateParser->setVar(name: $name, value: $value);
        endforeach;

        $this->assertSame(expected: $expectedResult, actual: $templateParser->parse());
    }

    public static function dataProviderParse(): array
    {
        return [
            'No PHP' => [
                'filename'       => __DIR__ . '/testFiles/NoPhpTemplate.php',
                'vars'           => [],
                'expectedResult' => 'Hello World'
            ],
            'Simple' => [
                'filename'       => __DIR__ . '/testFiles/SimpleTemplate.php',
                'vars'           => ['firstname' => 'John', 'lastname' => 'Doe'],
                'expectedResult' => 'Hello John Doe'
            ],
        ];
    }

    /**
     * @throws TemplateParserException
     */
    public function testParse_TemplateParserException()
    {
        $filename = __DIR__ . '/testFiles/TemporaryTemplate.php';

        // Ensure template file exists while creating the TemplateParser.
        file_put_contents(filename: $filename, data: '');

        $templateParser = new TemplateParser(filename: $filename);

        // And delete the template file again before parsing the template.
        unlink(filename: $filename);

        $this->expectException(exception: TemplateParserException::class);
        $this->expectExceptionMessage(message: sprintf('Template file "%s" not found.', $filename));

        $templateParser->parse();
    }
}
