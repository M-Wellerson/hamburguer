<?php

    $uri       = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?';
    $dados     = [];
    $parametro = [
        "nCdEmpresa"          => "",
        "sDsSenha"            => "",
        "nCdServico"          => "40010,40045,40215,40290,41106",
        "sCepOrigem"          => request['cepOrigem'] ?? "06786270",
        "nCdFormato"          => "1",
        "nVlDiametro"         => "0",
        "sCdMaoPropria"       => "n",
        "nVlValorDeclarado"   => "0",
        "sCdAvisoRecebimento" => "n",
        "sCepDestino"         => request['cep'] ?? '07240140',
        "nVlPeso"             => request['peso'] ?? '1',
        "nVlComprimento"      => request['profundidade'] ?? '30',
        "nVlAltura"           => request['altura'] ?? '30',
        "nVlLargura"          => request['largura'] ?? '30',
        "StrRetorno"          => "xml",
        "nIndicaCalculo"      => "3",
    ];    
    foreach( $parametro as $k => $v ) {
        $dados[] = "{$k}={$v}";
    }
    $dados   = implode( '&', $dados );
    $api_url = urlencode( $uri . $dados );
    $xml     = simplexml_load_file( $api_url );
    
    echo json_encode( $xml );