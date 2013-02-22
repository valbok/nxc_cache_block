<?php
/**
 * @author VaL <vd@nxc.no>
 * @file nxcIncludeCacheBlockTest.php
 * @copyright Copyright (C) 2011 NXC AS
 * @license GNU GPL v2
 * @package nxc-cache-block
 */

/**
 * Checks include cache block
 */
class nxcIncludeCacheBlockTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests including static text
     */
    public function testStaticInclude()
    {
        $dir = $_SERVER['PWD'];
        $uri = $dir . '/extension/nxc_cache_block/tests/CacheBlocks/templates/static.tpl';
        $o = new nxcIncludeCacheBlock( array( 'uri' =>  $uri ) );
        $result = $o->handle();

        $this->assertEquals( 'static', $result );
    }

    /**
     * Tests including dynamic text
     */
    public function testDynamicInclude()
    {
        $dir = $_SERVER['PWD'];
        $uri = $dir . '/extension/nxc_cache_block/tests/CacheBlocks/templates/dynamic.tpl';
        $o = new nxcIncludeCacheBlock( array( 'uri' =>  $uri ) );
        $result = $o->handle();

        $this->assertRegExp( "/^This is current time: [0-9]+\nThis is a random integer: [0-9]+/", $result );
    }

    /**
     * Tests if an exception is thrown if no submitted data
     */
    public function testEmptyException()
    {
        $o = new nxcIncludeCacheBlock();
        try
        {
            $o->handle();
            $this->fail( 'An exception has not been thrown' );
        }
        catch ( Exception $e )
        {
        }
    }

}
?>