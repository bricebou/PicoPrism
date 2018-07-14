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
        $this->prism_path = $config['base_url'] .'plugins/PicoPrism/node_modules/prismjs/';

        $prism_themes = array("coy", "dark", "funky", "okaidia", "solarizedlight", "tomorrow", "twilight");

        $this->prism_css_path = $this->prism_path . 'themes/prism.css';

        if (isset($config['prism']['theme']) && $config['prism']['theme'] != "" && in_array(trim($config['prism']['theme']), $prism_themes))
        {
            $this->prism_css_path = $this->prism_path . 'themes/prism-'. trim($config['prism']['theme']) .'.css';
        }

        if (isset($config['prism']['autoloader']) && $config['prism']['autoloader'] == true) {
            $this->prism_autoloader = true;
        }
    }

    private function build_scripts()
    {   
        $script = '<script src="'. $this->prism_path .'prism.js"></script>';
        if ($this->prism_autoloader) {
            $script .= '<script src="'. $this->prism_path .'plugins/autoloader/prism-autoloader.min.js"></script>' . PHP_EOL . '<script>Prism.plugins.autoloader.languages_path = "'. $this->prism_path .'components/"</script>';
        }
        return $script;
    }

    public function onPageRendered(&$output)
    {
        $output = str_replace('</head>', PHP_EOL . '<link href="'. $this->prism_css_path .'" rel="stylesheet" />' . PHP_EOL .'</head>', $output);
        $output = str_replace('</body>', PHP_EOL . $this->build_scripts() . PHP_EOL .'</body>', $output);
    }
}