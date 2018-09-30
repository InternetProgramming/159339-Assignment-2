<?php
/*
*
* Junghoe(Peter) Hwang - 16242934
* Erdem Alpkaya        - 16226114
* Robert Harper        - 96066919
*
*/
/**
 * Created by PhpStorm.
 * User: andrew
 */

namespace team\a2\view;

use const team\a2\APP_ROOT;
use team\a2\exception\customTemplateException;

/**
 * Class View
 *
 * A wrapper for the view templates.
 * Limits the accessible scope available to phtml templates.
 *
 * @package team/a2
 *
 * Code foundation by:
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 *
 *
 * @author  Junghoe Hwang <after10y@gmail.com>
 * @author Erdem Alpkaya <erdemalpkaya@gmail.com>
 * @author  Robert Harper   <l.attitude37@gmail.com>
 */
class View
{

    /**
     * @var string path to template being rendered
     */
    protected $template = null;

    /**
     * @var array data to be made available to the template
     */
    protected $data = array();

    /**
     * View constructor.
     * @param $template
     */
    public function __construct($template)
    {
        try {
            $file =  APP_ROOT . DIRECTORY_SEPARATOR .
                'src' . DIRECTORY_SEPARATOR .
                'templates' . DIRECTORY_SEPARATOR .
                $template . '.phtml';

            if (file_exists($file)) {
                $this->template = $file;
            } else {
                throw new customTemplateException('Template ' . $template . ' not found!');
//                throw new customException('Template ' . $template . ' not found!');
            }
        } catch (customTemplateException $e) {
            echo $e->errorMessage();
        }
    }

    /**
     * Adds a key/value pair to be available to phtml template
     *
     * @param string $key name of the data to be available
     * @param object $val value of the data to be available
     *
     * @return $this View
     */
    public function addData($key, $val)
    {
        $this->data[$key] = $val;
        return $this;
    }

    /**
     * Render the template, returning it's content.
     *
     * @return string The rendered template.
     */
    public function render()
    {
        // create a closure to be used in the templates
        $linkTo = function ($route, $params = []) {
            // Generate a link URL for a named route
            return $GLOBALS['router']->generate($route, $params);
        };
        extract($this->data);
        ob_start();
        include($this->template);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
