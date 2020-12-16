<?php

// Controller example

namespace App\Controllers;

use Xuborx\Framework\Base\Models\Model;

class PageController extends AppController
{

    public function viewPage() {
        $data = [
            'pageTitle' => 'Welcome to Xuborx Framework!'
        ];
        $this->renderTemplate('page', $data);
    }

    public function viewIndex() {
        $this->renderTemplate('index');
    }

}