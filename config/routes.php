<?php

use Xuborx\Framework\Router;

Router::addRoute('get', '', '', 'PageController', 'viewIndex'); // index route
Router::addRoute('get', '', 'page/view', 'PageController', 'viewPage'); // route example
