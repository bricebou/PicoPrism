PicoPrism
=========

<!--
@author     Brice Boucard (http://momh.fr)
@link       https://github.com/bricebou/PicoPrism
@license    MIT License | http://bricebou.mit-license.org/
@version    1.0
-->

A simple plugin that adds the syntax highlighter [Prism](https://prismjs.com) to Pico.

But why another Pico plugin for syntax highlighting, while there is [PicoSyntaxHighlighter](https://github.com/bricebou/PicoSyntaxHighlighter)?     
Here are some reasons:

- with PicoPrism, you don't have anymore to use HTLM `<pre>` tags inside your Markdown files: you simply have to use the Markdown syntax `` ``` ``;
- this way, the HTML output is way more semantically correct;
- with Prism "_the language is defined through the way recommended in the HTML5 draft: through a `language-xxxx` class_";
- there are more, no doubt, but I let [Prism website](https://prismjs.com/) convince you.

__Note:__ This plugin should offer soon more options, based on Prism plugins. But, we need Parsedown 1.8 and ParsedownExtra 0.8 (both in beta as on today, July, 16 of 2018); if I've understood correctly, it will be possible to parse `data-...` attributes.


## Installation

__/!\ No matter the way you install the plugin, it's mandatory you name the plugin folder `PicoPrism`.__ 

### Using Git

Just move to your Pico CMS `plugins` directory and run:

```bash
$ git clone https://github.com/bricebou/PicoPrism.git
```

### Otherwise

Download the [latest zip archive from Github](https://github.com/bricebou/PicoPrism/archive/master.zip) and unzip it inside a `plugins/PicoPrism/` folder.

## Configuration

The configuration of the PicoPrism plugin can be put inside the `config/config.yml` file of your Pico installation or inside a file named as you want inside the `config/` folder (for instance `config_plugin_prism.yml`).

```yaml
PicoPrism.enabled: true
prism:
    # What theme do you want to use ?
    # Prism themes available :
    # default | coy | dark | funky | okaidia | 
    # solarizedlight | tomorrow | twilight
    # If you want to use another theme, 
    # you'll have to declare it in the next parameter
    # but you might want to check the README.md
    theme: base16-seti
    # Additional themes I've generated using base16 (see the README.md)
    # You can add your own theme in prismjs/themes and declare it this array
    # Be sure to use " | " (space-pipe-space) as separator
    # You have to follow that naming scheme for your themes: prism-xxx.min.css
    other-themes: base16-3024 | base16-atelier-cave | base16-atelier-dune | base16-atelier-forest-light | base16-atelier-forest | base16-atelier-seaside-light | base16-atelier-seaside | base16-bespin | base16-black-metal-bathory | base16-black-metal-immortal | base16-black-metal-nile | base16-bright | base16-chalk | base16-circus | base16-cupertino | base16-darktooth | base16-github | base16-google-dark | base16-google-light | base16-grayscale-dark | base16-grayscale-light | base16-gruvbox-dark-hard | base16-gruvbox-dark-medium | base16-gruvbox-dark-pale | base16-gruvbox-dark-soft | base16-irblack | base16-marrakesh | base16-material-darker | base16-material | base16-materia | base16-mocha | base16-monokai | base16-nord | base16-pico | base16-pop | base16-railscasts | base16-seti | base16-spacemacs | base16-tube | base16-woodland | base16-yesterday-light | base16-zenburn
    # Enable line-numbering ?
    # true | false
    line-numbering: true
    # Automatically add line-numbering to all <pre> tag ?
    # Else you have to add the class "line-numbers"
    # to the ones you want line-numbered
    # (see the Usage section of the README.md)
    # true | false
    line-numbering-auto: true
    # If you use one language in a page, add the meta PrismGlobalClass: XXX
    # Choose on which parent HTML tag the "language-XXX" class will be added
    # Default: "body" | you can use ID: "#id"
    global-class-tag: "#content"
    # Don"t load Prism on certain pages based on their template
    # Be sure to use " | " (space-pipe-space) as separator
    excluded-templates: index | category | supcategory
    # Add a button that helps users to select your code snippets
    select-button: true
    # What text the select-button should show ?
    # Default / If empty: Select Code
    select-button-text: "Select Code"
```

## Usage

### Basics

Just add the language to the codeblock Markdown syntax (`` ``` `` or `~~~~`):

~~~~markdown
```php
public function onMetaParsed(array &$meta)
{
    if (isset($meta["PrismGlobalClass"]) && $meta["PrismGlobalClass"] != "") {
        $this->prism_global_class = $meta["PrismGlobalClass"];
    }

    if (isset($this->prism_excluded_templates) && isset($meta["template"]) && $meta["template"] != "")
    {
        if(in_array($meta["template"], $this->prism_excluded_templates))
        {
            $this->prism_load = false;
        }
    }
}
```
~~~~

Please, note that HTML, XML, SVG, Mathml languages are covered through the `markup` alias.

~~~~markdown
```markup
<h2> What a nice subtitle!

<p class="testclass">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit optio pariatur temporibus. Quod nisi qui obcaecati soluta nobis quasi autem, vitae. Nisi laborum cum eaque optio. Tenetur, nulla fugit deleniti.</p>
```
~~~~

### Languages

In its first version, PicoPrism embeds the version 1.15.0 of PrismJS which comes with `152` languages:

```bash
$ ls prismjs/languages/ | wc -l
152
```

Languages aliases are quite obvious, but if you encounter any issue, you can check which aliases to use on [PrismJS](https://prismjs.com/index.html#languages-list).

### Line numbering

If you don't want to have line numbering on all your code snippets, you have to let the `line-numbering-auto` option to its default value (`true`) and then to add manually the `line-numbers`.     
But it can be achieved without any HTML in your Markdown files, just as for languages:

~~~~markdown
```yaml line-numbers
PicoPrism.enabled: true
prism:
    # What theme do you want to use ?
    # Prism themes available :
    # default | coy | dark | funky | okaidia | 
    # solarizedlight | tomorrow | twilight
    # If you want to use another theme, 
    # you'll have to declare it in the next parameter
    # but you might want to check the README.md
    theme: base16-seti
~~~~

### Global language for one page

If on a page you use only one language, you can add it's alias class to a parent element using the `PrismGlobalClass: XXX` meta in your Markdown file header.

Every codeblock of the page the will be interpreted as XXX language, except if you declare another language. 

## Theming

I've added some themes I've generated thanks to [Chris Kempson's _base16_](https://github.com/chriskempson/base16), an «&#8239;architecture for building themes based on carefully chosen syntax highlighting using a base of sixteen colours&#8239;».     
I've used InspectorMustache's [base16-builder-python](https://github.com/InspectorMustache/base16-builder-python) but also the [Base-16 Builder](https://github.com/base16-builder/base16-builder).     
Thanks to Bram de Haan who wrote the base16 Prism template and all the authors of the color schemes I've used:

- `3024` by Jan T. Sott;
- dark version of `Atelier Cave` by Bram de Haan;
- dark version of `Atelier Dune` by Bram de Haan;
- both dark and light versions of `Atelier Forest` by Bram de Haan;
- both dark and light versions of `Atelier Seaside` by Bram de Haan;
- `Bespin` by Jan T. Sott;
- "bathory", "immortal" and "nile" versions of  `Black Metal` by metalelf0;
- `Bright` by Chris Kempson;
- `Chalk` by Chris Kempson;
- `Circus` by Stephan Boyer and Esther Wang;
- `Cupertino` by Defman21;
- `Darktooth` by Jason Milkins;
- `Github` by Defman21;
- both dark and light versions of `Google` by Seth Wright;
- both dark and light versions of `Grayscale` by Alexandre Gavioli;
- dark-hard, dark-medium, dark-pale and dark-soft versions of `Gruvbox` by Dawid Kurek;
- `IR Black` by Timothée Poisot;
- dark version of `Marrakesh` by Alexandre Gavioli;
- `Materia` by Defman21;
- dark and normal versions of `Material` by Nate Peterson;
- dark version of `Mocha` by Chris Kempson;
- dark version of `Monokai` by Wimer Hazenberg;
- `Nord` by arcticicestudio;
- `Pico` by PICO-8;
- `Pop` by Chris Kempson;
- `Railscasts` by Ryan Bates;
- `Seti UI` (by unknown :-/); 
- `Spacemacs` by Nasser Alshammari;
- `Tube` by Jan T. Sott;
- light version of `Yesterday` by FroZnShiva;
- `Woodland` by Jay Cornwall;
- `Zenburn` by elnawe.