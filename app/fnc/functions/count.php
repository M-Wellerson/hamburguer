<?php
    $pasta = __DIR__ . "/../../data/contador/";
    maker_dir( $pasta ); 

    function getJson( $file ) {
        if( ! file_exists( $file ) ) file_put_contents( $file, '{}' );
        return json_decode( file_get_contents( $file ) );
    }

    function setJson( $file, $json ) {
        if( ! file_exists( $file ) ) file_put_contents( $file, '{}' );
        $item = json_decode( file_get_contents( $file ) );
        foreach( $json as $indice => $valor ) {
            $item->{$indice} = $valor;
        }
        file_put_contents( $file, json_encode( $item ) );
        return $item;
    }

    if( !empty( $_REQUEST['item'] ) ) {
        $file = "{$pasta}{$_REQUEST['item']}.json";
        $item = getJson( $file );
        $item->count = $item->count ?? 1000;
        $item->count++;
        setJson( $file, $item );
        echo json_encode( $item );
        die;
    }

    $lista = glob( "{$pasta}*.json*" );
    $lista = array_map( function( $file ) {
        $json = getJson( $file ) ;
        unset( $json->pass );
        unset( $json->password );
        return $json;
    }, $lista );
    $lista = array_filter( $lista, function( $e ) { return (boolean)$e->status ?? false; } );
    $lista = array_values( $lista );   
    echo json_encode( $lista );
