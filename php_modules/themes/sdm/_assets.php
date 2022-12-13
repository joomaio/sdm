<?php defined( 'APP_PATH' ) or die('');

// use SPT\Router ;

return [
    'bootstrap-css' => [
        ['__domain__/assets/css/bootstrap5.min.css', '' , 'bootstrap-css'],
    ],
    'fontawesome-css' => [
        ['__domain__/assets/font/fontawesome/css/fontawesome.min.css', '' , 'fontawesome-css'],
    ],
    'style-css' => [
        ['__domain__/assets/css/style.css', '' , 'style-css'],
    ],
    'select2-css' => [
        ['__domain__/assets/css/select2.min.css', '', 'select2-css'],
    ],
    'admin-css' => [
        ['__domain__/assets/css/app.css', '', 'admin-css'],
    ],
    'style-css' => [
        ['__domain__/assets/css/style.css', '', 'style-css'],
    ],
    'select2-js' => [
        ['__domain__/assets/js/select2.full.min.js', '', 'media-select2-js' , ''],
    ],
    'jquery' => [
        ['__domain__/assets/js/jquery-3.6.0.min.js', [], 'jquery-3.6.0.min', 'top']
    ],
    'js-bootstrap' => [
        ['__domain__/assets/js/bootstrap.bundle.min.js', [], 'bootstrap', '']
    ],

];