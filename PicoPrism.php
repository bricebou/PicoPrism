<?php 
/**
 * PicoPrism
 *
 * Add Prism https://prismjs.com/ to Pico
 *
 * @author Brice Boucard
 * @link https://github.com/bricebou/PicoPrism
 * @license MIT License | http://bricebou.mit-license.org/
 */

class PicoPrism extends AbstractPicoPlugin {
    const API_VERSION = 2;

    protected $enabled = null;

    public function onConfigLoaded(array &$config)
    {
        // "Default" to avoid PHP warnings
        $this->prism_css_theme = "";
        $this->prism_line_numbering = false;
        $this->prism_line_numbering_auto = false;
        $this->prism_global_class_tag = "body";
        $this->prism_load = true;

        $this->prism_path = $config['base_url'] .'plugins/PicoPrism/prismjs/';

        $prism_themes = array("coy", "dark", "funky", "okaidia", "solarizedlight", "tomorrow", "twilight");

        if (isset($config['prism']['theme']) && in_array(trim($config['prism']['theme']), $prism_themes))
        {   
            $this->prism_css_theme = trim($config['prism']['theme']);
        }  

        if (isset($config['prism']['line-numbering']) && $config['prism']['line-numbering'] == true)
        {
            $this->prism_line_numbering = true;

            if ($config['prism']['line-numbering-auto'] && $config['prism']['line-numbering-auto'] == true) {
                $this->prism_line_numbering_auto = true;
            }
        }

        if (isset($config['prism']['global-class-tag']) && $config['prism']['global-class-tag'] != "") {
            $this->prism_global_class_tag = $config['prism']['global-class-tag'];
        }

        if (isset($config['prism']['excluded-templates']) && $config['prism']['excluded-templates'] != "")
        {
            $this->prism_excluded_templates = explode("|", $config['prism']['excluded-templates']);
        }
    }

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

    private function build_css ()
    {
        $css = '<link href="'. $this->prism_path . 'themes/prism.min.css" rel="stylesheet" />';
        if (!empty($this->prism_css_theme)) {
            $css = '<link href="'. $this->prism_path .'themes/prism-'. $this->prism_css_theme .'.min.css" rel="stylesheet" />';
        }

        if ($this->prism_line_numbering) {
            // Line-numbering plugin needs 'line-numbers' class to desired <pre> => taken care automatically inside the build_script() function
            $css .= PHP_EOL . '<link href="'. $this->prism_path . 'plugins/line-numbers/prism-line-numbers.css" rel="stylesheet" />';
        }

        return $css;
    }

    private function build_scripts()
    {   
        $script = '';

        if (isset($this->prism_global_class)) {
            $script .= PHP_EOL . '<script>var el = document.querySelector("' . $this->prism_global_class_tag . '"); el.classList.add("language-' . $this->prism_global_class . '");</script>';
        }

        $script .= '<script src="' . $this->prism_path . 'prism.js"></script>' . PHP_EOL . '<script src="' . $this->prism_path . 'plugins/autoloader/prism-autoloader.min.js"></script>' . PHP_EOL . '<script>Prism.plugins.autoloader.languages_path = "'. $this->prism_path . 'languages/"</script>';

        if ($this->prism_line_numbering)
        {
            // If line-numbering-auto is true, then we run a small javascript
            // to automatically add the "line-numbers" class to all <pre> tags
            if ($this->prism_line_numbering_auto) {
                $script .= PHP_EOL . '<script>var pres = document.querySelectorAll("pre"); pres.forEach(function(e) { e.classList.add("line-numbers");});</script>';
            }
            
            $script .= PHP_EOL . '<script src="'. $this->prism_path . 'plugins/line-numbers/prism-line-numbers.min.js"></script>' ;
        }

        return $script;
    }

    

    public function onPageRendered(&$output)
    {
        if ($this->prism_load)
        {
            $output = str_replace('</head>', PHP_EOL . $this->build_css() . PHP_EOL .'</head>', $output);
            $output = str_replace('</body>', PHP_EOL . $this->build_scripts() . PHP_EOL .'</body>', $output);
        }
    }
}