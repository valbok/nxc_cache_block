<?php
/**
 * @author VaL <vd@nxc.no>
 * @file ncbIncludeRandomTest.php
 * @copyright Copyright (C) 2011 NXC AS
 * @license GNU GPL v2
 * @package nxc-cache-block
 */

/**
 * Checks template handler of cache blocks
 */
class ncbTemplateHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Checks if exception is thrown if wrong cache block name is passed
     */
    public function testWrongCacheBlockNameException()
    {
        try
        {
            ncbTemplateHandler::get( md5( 'name______' ) )->handle();
            $this->fail( 'An exception has not been thrown' );
        }
        catch ( Exception $e )
        {
        }
    }

    /**
     * Checks exception if no params are passed to include
     */
    public function testIncludeCacheBlockWithNoParamsException()
    {
        try
        {
            ncbTemplateHandler::get( 'include' )->handle();
            $this->fail( 'An exception has not been thrown' );
        }
        catch ( Exception $e )
        {
        }
    }

    /**
     * Tests including a tpl and checks if result is not empty
     */
    public function testNotEmptyDefaultTypeIncludeCacheBlock()
    {
        $dir = $_SERVER['PWD'];
        $uri = $dir . '/extension/nxc_cache_block/tests/Kernel/templates/include.tpl';
        $result = ncbTemplateHandler::get( 'include', array( 'uri' => $uri ) )->handle();

        $this->assertNotEmpty( $result );
    }

    /**
     * Tests including a tpl with ajax-onload type and checks if result is not empty
     */
    public function testNotEmptyAjaxOnLoadTypeIncludeCacheBlock()
    {
        $dir = $_SERVER['PWD'];
        $uri = $dir . '/extension/nxc_cache_block/tests/Kernel/templates/include.tpl';
        $result = ncbTemplateHandler::get( 'include', array( 'uri' => $uri ), 'ajax' )->handle();

        $this->assertNotEmpty( $result );
    }

    /**
     * Tests including a tpl with ajax-uri type and checks if result is not empty
     */
    public function testNotEmptyAjaxURITypeIncludeCacheBlock()
    {
        $dir = $_SERVER['PWD'];
        $uri = $dir . '/extension/nxc_cache_block/tests/Kernel/templates/include.tpl';
        $result = ncbTemplateHandler::get( 'include', array( 'uri' => $uri ), 'ajax-uri' )->handle();

        $this->assertNotEmpty( $result );
    }

    /**
     * Tests including a tpl with ssi type and checks if result is not empty
     */
    public function testNotEmptySSITypeIncludeCacheBlock()
    {
        $dir = $_SERVER['PWD'];
        $uri = $dir . '/extension/nxc_cache_block/tests/Kernel/templates/include.tpl';
        $result = ncbTemplateHandler::get( 'include', array( 'uri' => $uri ), 'ssi' )->handle();

        $this->assertNotEmpty( $result );
    }

    /**
     * Tests including a tpl with esi type and checks if result is not empty
     */
    public function testNotEmptyESITypeIncludeCacheBlock()
    {
        $dir = $_SERVER['PWD'];
        $uri = $dir . '/extension/nxc_cache_block/tests/Kernel/templates/include.tpl';
        $result = ncbTemplateHandler::get( 'include', array( 'uri' => $uri ), 'esi' )->handle();

        $this->assertNotEmpty( $result );
    }

    /**
     * Tests including a tpl with empty type and checks if result is correct
     */
    public function testEmptyTypeIncludeCacheBlock()
    {
        $dir = $_SERVER['PWD'];
        $uri = $dir . '/extension/nxc_cache_block/tests/Kernel/templates/include.tpl';
        $result = ncbTemplateHandler::get( 'include', array( 'uri' => $uri ), '' )->handle();

        $this->assertEquals( 'test', $result );
    }
}
?>