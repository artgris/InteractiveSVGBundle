# InteractiveSVGBundle

Symfony Bundle to handle SVG graphics elements (titles, fills and strokes colors) and generate an interactive SVG

Installation
------------

### 1) Download 

`composer require artgris/interactive-svg-bundle`


### 2) Enable Bundle

    // app/AppKernel.php
    
    $bundles = array(
        // ...
          new Artgris\Bundle\InteractiveSVGBundle\ArtgrisInteractiveSVGBundle()
    );
    
### 3) Configure the Bundle 


Adds following configurations 

to `app/config/routing.yml`

    interactiveSVGBundle:
        resource: "@ArtgrisInteractiveSVGBundle/Controller/"
        type: annotation
        prefix: /_svg  #for example
        
        
to ` app/config/config.yml` (optional) :

```yml 
artgris_interactive_svg:
    svg_dir: "%kernel.root_dir%/../web/svg"
``` 

svg_dir : directory location of your SVG's (not necessarily a public folder)


Install the web assets

    php bin/console assets:install 


and include css and js (used to rendering the interactive svg)

    <link rel="stylesheet" href="{{ asset('bundles/artgrisinteractivesvg/css/front/front.css') }}"/>
    
    <script src="{{ asset('bundles/artgrisinteractivesvg/js/front/front.js') }}"></script>
    
    
### 4) Copy your SVGs in your svg_dir folder


Usage
=====


#### SVG List and Edition
 
 You can access SVG list from /_svg (depend on routing prefix you have chosen) and edit them
 
 
#### interactive SVG

AFTER EDITING YOUR SVG, add `{{ interactive('svg_file_name.svg') }}` where you want to insert the interactive svg 
 





