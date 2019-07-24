<?php 

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: text/html; charset=utf-8');
    date_default_timezone_set('America/Sao_Paulo');

    if( ! isset( $_REQUEST['bug'] ) ):
        header('Content-type:application/json');
    endif;

    require __DIR__ . "/../core/help.php";
    require __DIR__ . "/../core/hook.php";
    require __DIR__ . "/../core/auto.php";

    $fnc_name = urls[1] ?? 'default';
    $fnc_file = __DIR__ . "/functions/{$fnc_name}.php";
    
    if( file_exists( $fnc_file ) ):
        require $fnc_file;
        die;
    endif;

    echo json_decode( [
        "error" => true
    ] );
