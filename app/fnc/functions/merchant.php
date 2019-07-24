<?php

    header("Content-type: text/xml"); 

    $json = file_get_contents( uri . "/app/" );
    $json = json_decode( $json );



    $loop = "";
    foreach( $json->produto as $iten ) {
        @$html = $iten->html;
        @$html = strip_tags($html);
        @$html = trim($html);
        @$html = substr($html, 0, 75);
        @$loop .=  "
        <item> 
            <title>{$iten->nome}</title> 
            <link>".uri."/{$iten->slug}</link> 
            <description>{$html}</description>
            <g:image_link>".uri."/app/storage/{$iten->foto}</g:image_link> 
            <g:price>{$iten->preco}</g:price> 
            <g:condition>novo</g:condition> 
            <g:id>{$iten->id}</g:id>
        </item> 
        
        ";
    }

    $tpl = "
        <!-- <?xml version=\"1.0\"?> -->
        <rss version=\"2.0\" xmlns:g=\"http://base.google.com/ns/1.0\">
            <channel>
                <title>produtos</title> 
                <link>".uri."</link> 
                <description>Os melhores produtos</description> 
                {$loop}
            </channel> 
        </rss>
    ";

    echo $tpl;

