# templateparser
Simple template parser using PHP template files.

Using this template parser require no knowledge of a template parser syntax since the template file is "just" an ordinary PHP-file with
template variables available as normal PHP variables.

## Usage
Create a template filename.

SampleTemplate.php
```
<?php
/**
 * @var string $firstname   Firstname.
 */
/**
 * @var string $lastname   Lastname.
 */
?>Hello <?php echo $firstname; ?> <?php echo $lastname; ?>
```

And then use TemplateParser to parse the above template.

```
try {
    $templateParser = new TemplateParser('SampleTemplate.php');
    
    $templateParser->setVar(name: 'firstname', value: 'John');
    $templateParser->setVar(name: 'lastname', value: 'Doe');
    
    echo $templateParser->parse();
} catch (TemplateParserException $e) {
    // Error handling.
}
```
