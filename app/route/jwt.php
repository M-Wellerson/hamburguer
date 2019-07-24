<?php

    $token = $_REQUEST['token'] ?? false;
    $email = $_REQUEST['email'] ?? false;
    $pass  = $_REQUEST['pass'] ?? false;
    $chave = 'MeuGatoTO@toComeuOratoTOeNaoMorrrrreuEm2019';

    if( $token ) :
        $token           = explode( '.', $token );
        $user_info       = $token[0] ?? '';
        $chave_seguracao = $token[1] ?? '';
        $key             = $token[2] ?? '';
        $chave_seguracao = json_decode( base64_decode($chave_seguracao) );
        $chave_seguracao->palavraSecreta = $chave;
        $chave_seguracao = base64_encode( json_encode( $chave_seguracao ) );
        $key_atual       = sha1("{$user_info}.{$chave_seguracao}");
        $key             = $token[2] ?? '';
        if( $key_atual == $key ) {
            echo json_encode( [
                "erro" => false,
                "mensagem" => "Token valido"
            ] );
        } else {
            echo json_encode( [
                "erro" => true,
                "mensagem" => "Token invalido"
            ] );
        }        
        die;
    endif;

    if( $email AND $pass ) :
        $email_valid = sha1($email) == sha1('user@gmail.com');
        $pass_valid  = sha1($pass)  == sha1('123');
        if( $email_valid AND $pass_valid ) {
            $ID              = uniqid();
            $chave_seguracao = [
                "validade"       => "",
                "key"            => $ID,
                "palavraSecreta" => $chave
            ];
            $chave_seguracao = base64_encode( json_encode( $chave_seguracao ) );
            $chave_seguracao_user = [
                "validade"       => "",
                "key"            => $ID,
                "palavraSecreta" => ""
            ];
            $chave_seguracao_user = base64_encode( json_encode( $chave_seguracao_user ) );
            $user_info = [
                "nome"  => "Usuário Padrão",
                "email" => "user@gmail.com",
                "id"    => sha1("user@gmail.com")
            ];
            $user_info = base64_encode( json_encode( $user_info ) );
            $key = sha1("{$user_info}.{$chave_seguracao}");
            echo json_encode( [
                "erro" => false,
                "token" => "{$user_info}.{$chave_seguracao_user}.{$key}"
            ] );
        }else {
            echo json_encode( [
                "erro" => true,
                "mensagem" => "Usuário ou senha estão errados"
            ] );
        }
        die;
    endif;
