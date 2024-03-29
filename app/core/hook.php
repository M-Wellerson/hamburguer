<?php

    $_REQUEST = array_map( function( $iten ) {
        $iten = trim( $iten );
        $iten = addslashes( $iten );
        return $iten;
    }, $_REQUEST ?? [] );

    if(  empty( $_REQUEST['id'] ) ) unset( $_REQUEST['id'] );
    $_REQUEST['id']           = $_REQUEST['id']  ?? date( 'YmdNHisu' ) . uniqid();
    $_REQUEST['status']       =  $_REQUEST['status']  ?? true;

    if( ! empty( $_REQUEST['pass'] ) ):
        $_REQUEST['pass'] = sha1( $_REQUEST['pass'] );
    endif;
    if( ! empty( $_REQUEST['password'] ) ):
        $_REQUEST['password'] = sha1( $_REQUEST['password'] );
    endif;

    if( ! empty( $_REQUEST['status'] ) ):
        $_REQUEST['status'] = ( boolean )  $_REQUEST['status'] ?? true;
    endif;

    $_REQUEST['data'] = Date('d/m/Y');

    define( 'dominio', str_replace( 'www.','', $_SERVER['SERVER_NAME'] ) ) ;
    define( 'http'   , $_SERVER['REQUEST_SCHEME'] );
    define( 'method' , $_SERVER['REQUEST_METHOD'] );
    define( 'port'   , $_SERVER['SERVER_PORT'] );
    define( 'uri'    , http . "://" . dominio );
    $url = $_SERVER['REQUEST_URI'];
    $url = explode('?', $url );
    define( 'url'    , $url[0] );
    // define( 'url'    , $_SERVER['REDIRECT_URL'] ?? '' );
    define( 'urls'   , array_values( array_filter( explode( '/', url ) , function( $iten ) { return ! empty( $iten ) && $iten != 'app';  } ) ) );
    define( 'origin' , $_SERVER['HTTP_REFERER'] ?? false ) ;
    define( 'request', $_REQUEST ?? [] );

   