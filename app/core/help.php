<?php

    function t( $ITEN )
    {
        echo "<pre>";
        var_dump( $ITEN );
        echo "</pre>";
    }

    function maker_dir( $DIR )
    {
        if( ! file_exists( $DIR ) ):
            $oldmask = umask(0);
            mkdir( $DIR, 0777, true );
            umask($oldmask);
            file_put_contents( "{$DIR}index.php",'' );
        endif;
    }