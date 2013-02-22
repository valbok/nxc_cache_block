<?php
/**
 * @author VaL <vd@nxc.no>
 * @file ncbProcessHandlerTest.php
 * @copyright Copyright (C) 2011 NXC AS
 * @license GNU GPL v2
 * @package nxc-cache-block
 */

/**
 * Checks process handler of cache blocks
 */
class ncbProcessHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests not empty ajax link in ajax type include cache block
     */
    public function testNotEmptyAjaxOnLoadLinkIncludeCacheBlock()
    {
        $result = ncbTemplateHandler::get( 'include', array( 'uri' => $_SERVER['PWD'] . '/extension/nxc_cache_block/tests/Kernel/templates/include.tpl' ), 'ajax', 'id' )->handle();
        if ( preg_match( '/<a id="id" class="nxc-cache-block-ajax-onload-link" href="(.*)">/', $result, $matches ) )
        {
            $uri = isset( $matches[1] ) ? $matches[1] : false;
        }

        $this->assertNotEquals( false, $uri );
        $this->assertNotEmpty( $uri );
    }

    /**
     * Tests exploded ajax type cache block
     */
    public function testExplodedAjaxOnLoadLinkIncludeCacheBlock()
    {
        $result = ncbTemplateHandler::get( 'include', array( 'uri' => $_SERVER['PWD'] . '/extension/nxc_cache_block/tests/Kernel/templates/include.tpl' ), 'ajax', 'id' )->handle();
        if ( preg_match( '/<a id="id" class="nxc-cache-block-ajax-onload-link" href="(.*)">/', $result, $matches ) )
        {
            $uri = $matches[1];
        }

        if ( $uri[0] == '/' )
        {
            $uri = substr( $uri, 1, strlen( $uri ) );
        }

        $exploded = explode( '/', $uri );
        $module = $exploded[0];
        $view = $exploded[1];
        $name = $exploded[2];
        $paramList = '';
        if ( preg_match( '/\?d=(.*)/', $uri, $matches ) )
        {
            $paramList = $matches[1];
        }
        
        $hash = $exploded[3];
        $ttl = $exploded[4];

        $this->assertNotEmpty( $name );
        $this->assertNotEmpty( $paramList );
        $this->assertNotEmpty( $hash );
        $this->assertRegExp( '/[0-9]*/', $ttl );
    }

    /**
     * Tests including ajax type cache block and checks result
     */
    public function testAjaxOnLoadLinkIncludeCacheBlock()
    {
        $result = ncbTemplateHandler::get( 'include', array( 'uri' => $_SERVER['PWD'] . '/extension/nxc_cache_block/tests/Kernel/templates/include.tpl' ), 'ajax', 'id' )->handle();
        if ( preg_match( '/<a id="id" class="nxc-cache-block-ajax-onload-link" href="(.*)">/', $result, $matches ) )
        {
            $uri = $matches[1];
        }

        if ( $uri[0] == '/' )
        {
            $uri = substr( $uri, 1, strlen( $uri ) );
        }

        $exploded = explode( '/', $uri );
        $module = $exploded[0];
        $view = $exploded[1];
        $name = $exploded[2];
        $paramList = '';
        if ( preg_match( '/\?d=(.*)/', $uri, $matches ) )
        {
            $paramList = $matches[1];
        }

        $hash = $exploded[3];
        $ttl = $exploded[4];

        $result = ncbProcessHandler::get( $name, $paramList, $hash )->handle( $ttl );

        $this->assertEquals( 'test', $result );
    }

}
?>