<?php

   header("Content-type: text/xml"); 

   $json = file_get_contents( uri . "/app/" );
   $json = json_decode( $json );



   $loop = "";
   foreach( $json->produto as $iten ) {
      @$loop .=  "
      <url>
         <loc>".uri."/{$iten->slug}</loc>
         <lastmod>{$iten->data}</lastmod>
         <changefreq>monthly</changefreq>
         <priority>0.8</priority>
      </url>        
      ";
   }

   $tpl = "
      <!-- <?xml version=\"1.0\" encoding=\"UTF-8\"?> -->
      <urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
         {$loop}
      </urlset>
   ";

   echo $tpl;

