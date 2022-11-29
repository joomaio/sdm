<?php defined( 'APP_PATH' ) or die('');

// use SPT\Router ;

return [
    'bootstrap-css' => [
        ['__domain__/assets/css/bootstrap5.min.css', '' , 'bootstrap-css'],
    ],
    'select2-css' => [
        ['__domain__/assets/css/select2.min.css', '', 'select2-css'],
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
    'common_factsstyles' => [
        ['__domain__/assets/css/factsstyles', [], 'factsstyles', ''],
    ]
];