<?php

namespace Itravel\View;

use Itravel\Helper\Params;

class View
{

    /**
     * renders simple php template
     *
     * @param string $view
     * @param array $args optional data to pass
     *
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $path = Params::getParam('APP_ROOT') . "/Views/$view";

        if (is_readable($path)) {
            require $path;
        } else {
            throw new \Exception("$path not found");
        }
    }

    /**
     * renders twig template
     *
     * @param string $template The template file
     * @param array $args optional data to pass to template
     *
     * @return void
     */
    public static function renderTwig($template, $args = [])
    {
        $twigLoader = new \Twig_Loader_Filesystem(Params::getParam('APP_ROOT') . '/Views');
        $twigEnv = new \Twig_Environment($twigLoader);

        echo $twigEnv->render($template, $args);
    }
}
