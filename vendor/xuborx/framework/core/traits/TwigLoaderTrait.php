<?php

namespace Xuborx\Framework\Traits;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Xuborx\Framework\Registry;

trait TwigLoaderTrait
{

    public function renderTemplate($name, $data = [], $path ='') {
        $path = trim($path, '/');
        $name = trim($name, '/') . '.twig';
        $staticData = Registry::instance()->getProperties();
        $data = array_merge($data, $staticData);
        $loader = new FilesystemLoader(VIEW_DIR);
        $twig = new Environment($loader, ['cache' => false]);
        if (file_exists(VIEW_DIR . "/{$path}/{$name}")) {
            $template = $twig->load("/{$path}/{$name}");
            echo $template->render($data);
        } else {
            throw new \Exception("Template " . VIEW_DIR . "/{$path}/{$name} not found.", 404);
        }
    }
}