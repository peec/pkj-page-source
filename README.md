# PKJ Page Source

Wordpress plugin that lets you add a source to page, to list custom post-types (forexample a list of  the "service"
content type below the main content on your  /services "page").


## Installation

Install with composer. Add this to your composer file:

```json
"require": {
    "pkj/pkj-page-source": "dev-master"
}
```


## Hooks


#### Changing the generated grid class definitions.

By default this plugin uses boostrap 3 column classes, (col-sm-X, col-md-X, col-lg-X), you can change this by adding
this code in your functions.php file:

```php

    add_filter('pkj-page-source_blocksizemap', 'my_theme_blocksizemap_hook');
    // Customize this function for your needs:
    public function my_theme_blocksizemap_hook ($blocksizemap) {
        $class = '';
        foreach($blocksizemap as $context => $perRow) {
            $bit = '';
            switch($context) {
                case 'l': $bit = 'lg'; break;
                case 'm': $bit = 'md'; break;
                case 's': $bit = 'sm'; break;
            }
            $gridSize = 12 / $perRow;
            $class .= "col-$bit-$gridSize ";
        }
        return $class;
    }
```

#### Changing the "row" class to theme specific.

```php

    add_filter('pkj-page-source_rowclass', function () {
        return 'row'; // Change to your class.
    });

```




