/**
 * Handler for onload ajax calls
 *
 * @author VaL
 * @copyright Copyright (C) 2011 NXC AS
 * @license GNU GPL v2
 * @package nxc-cache-block
 */

/**
 * Finds all elements and replaces it by data that is returned by ajax
 */
$( document ).ready(
    function( e )
    {
        processNXCCacheBlockList( $( 'a.nxc-cache-block-ajax-onload-link' ) );
    }
);

/**
 * Binds links that is related to cache blocks
 */
function processNXCCacheBlockList( blockList )
{
    if ( blockList.length == 0 )
    {
        return;
    }

    $.each( blockList,
        function( item, index )
        {
            var url = $( this ).attr( 'href' );
            var callback = $( this ).attr( 'callback' );

            if ( !url )
            {
                return;
            }

            var a = $( this ).parent();

            processNXCCacheBlockURL( url, a, true, callback );
        }
    );
}

/**
 * Binds links that is related to cache blocks
 */
function processNXCCacheBlockURL( url, container, replaceWith, callback )
{
    if ( !url )
    {
        return;
    }

    $.post( url,
           function( data )
           {
                if ( replaceWith )
                {
                    $( container ).replaceWith( data );
                }
                else
                {
                    $( container ).html( data );
                }

                if ( callback )
                {
                    eval( callback );
                }
           }
    ).error(
            function ()
            {
                var error = 'An error has occured';

                if ( replaceWith )
                {
                    $( container ).replaceWith( error );
                }
                else
                {
                    $( container ).html( error );
                }
            }
    );
}
