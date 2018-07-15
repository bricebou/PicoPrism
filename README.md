PicoPrism
=========

A simple plugin that adds [Prism](https://prismjs.com) to Pico.

__Documentation yet to come --'__

Looking forward for Parsedown 1.8 and ParsedownExtra 0.8 (both in beta) in order to use more Prism plugins, relying on `data-...` attributes.

I've added some themes I've generated thanks to the [Base-16 Builder](https://github.com/base16-builder/base16-builder) using the following color schemes:

- dark version of `Atelier Dune` by Bram de Haan;
- both dark and light versions of `Atelier Forest` by Bram de Haan;
- dark version of `Marrakesh` by Alexandre Gavioli;
- dark version of `Mocha` by Chris Kempson;
- dark version of `Monokai` by Wimer Hazenberg;
- both dark and light versions of `Seti UI` (by unknown :-/); 
- light version of `Yesterday` by FroZnShiva.

## Configuration

```yaml
PicoPrism.enabled: true
prism:
    # default | coy | dark | funky | okaidia | 
    # solarizedlight | tomorrow | twilight
    # If you want to use another theme, 
    # you'll have to declare it in the next parameter
    # but you might want tp check the README.md
    theme: setiui
    # More themes ?
    other-themes: atelier-dune | atelier-forest | atelier-forest-light | marrakesh | mocha | monokai | setiui | setiui-light | yesterday-light
    # Enable line-numbering ?
    # true | false
    line-numbering: true
    # Automatically add line-numbering to all <pre> tag ?
    # Else you have to add the class "line-numbers"
    # to the ones you want line-numbered
    # true | false
    line-numbering-auto: true
    # If you use only one language in a page, 
    # add in your header the meta PrismGlobalClass: XXX
    # Choose on wich parent HTML tag
    # the "language-XXX" class will be added
    # Default: "body" | you can use ID: "#id"
    global-class-tag: "#content"
    # Don"t load Prism on certain pages based on their template
    # Use the pipe | as separator, without space ; case-sensitive.
    excluded-templates: "index|category|supcategory"
    # copy-button
    copy-button: true
    # Default / If empty: Select Code
    copy-button-text: "Select Code"
```