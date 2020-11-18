<?php

namespace Xuborx\Framework;

use Xuborx\Framework\Traits\TwigLoaderTrait;

class ErrorHandler
{

    use TwigLoaderTrait;

    public function __construct() {
        if (DEBUG) {
            error_reporting(-1);
        } else {
            error_reporting(0);
        }
        set_exception_handler([$this, 'exceptionHandler']);
    }

    public function exceptionHandler($e) {
        $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError($e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
    }

    private function logErrors($message = '', $file = '', $line = '') {
        error_log(date('Y-m-d H:i:s') . " - Error text: " . $message . " | File: " . $file . " | Line: " . $line . "\n" , 3, ROOT_DIR . '/log/exceptions.log');
    }

    private function displayError($message, $file, $line, $code = 404) {
        http_response_code($code);
        if ($code == 404 && !DEBUG) {
            $this->renderTemplate('404', null, 'errors');
            die;
        }
        if (DEBUG) {
            $data = array(
                'message' => $message,
                'file' => $file,
                'line' => $line,
                'code' => $code
            );
            $this->renderTemplate('dev', $data, 'errors');
            die;
        } else {
            $this->renderTemplate('prod', null,'errors');
            die;
        }
    }

}