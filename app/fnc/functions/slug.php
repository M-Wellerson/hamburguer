<?php

    $dados = file_get_contents( uri . "/app" );
    $dados = json_decode( $dados );

    $categoria = $dados->categoria ?? [];
    $marca     = $dados->marca ?? [];
    $pagina    = $dados->pagina ?? [];
    $produto   = $dados->produto ?? [];

    $arr = array_merge( $categoria, $marca, $pagina,$produto );

    $slug = array_reduce( $arr, function( $acc, $x ) { 
        $slug =  $x->slug ?? false;
        if( $slug ) {
            $acc[] = $slug;
        }
        return $acc;
    }, []);
    
    $search = request['s'] ?? '';
    
    $existe =  in_array( $search, $slug );

    echo json_encode( [
        "slug" => $existe 
    ] );