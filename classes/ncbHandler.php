<?php
/**
 * @author VaL <vd@nxc.no>
 * @copyright Copyright (C) 2011 NXC AS
 * @license GNU GPL v2
 * @package nxc-cache-block
 */

/**
 * Base handler to process cache blocks
 */
abstract class ncbHandler
{
    /**
     * Cache block name
     *
     * @var (string)
     */
    protected $Name = false;

    /**
     * Cache block param list
     *
     * @var (array)
     */
    protected $ParamList = false;

    /**
     * Cache block instance
     *
     * @var (nxcCacheBlock)
     */
    protected $CacheBlock = false;

    /**
     * @reimp
     */
    protected function __construct( $name, $paramList = array() )
    {
        $this->Name = $name;
        $this->ParamList = $paramList;
        $this->CacheBlock = self::createObject( $name, $paramList );
    }

    /**
     * Creates cache block instance
     *
     * @param (string) $name Name of a cache block
     * @param (array) $paramList A list with parameters
     * @return (nxcCacheBlock)
     */
    protected static function createObject( $name, $paramList = array() )
    {
        $class = 'nxc' . ucfirst( $name ) . 'CacheBlock';
        if ( !class_exists( $class ) )
        {
            throw new nxcInvalidArgumentException( 'Cache Block ' . $class . ' does not exist' );
        }

        return new $class( $paramList );
    }

    /**
     * Creates security hash per a call
     * To prevent calling with not authorized parameters
     *
     * @param (string) $name Cache block name
     * @param (string) $params Encoded param list
     * @return (string)
     */
    protected static function createHash( $name, $params )
    {
        $ini = eZINI::instance( 'nxc-cache-block.ini' );
        $salt = $ini->hasVariable( 'CacheBlockSettings', 'HashSalt' ) ? $ini->variable( 'CacheBlockSettings', 'HashSalt' ) : 'nXcbSaLt' . __METHOD__;

        return md5( $name . ':' . $params . ':' . $salt );
    }

    /**
     * Encodes param list to use in uri
     *
     * @param (array) $list Param list
     * @return (string)
     */
    protected static function encodeParamList( $list )
    {
        return base64_encode( serialize( $list ) );
    }

    /**
     * Decodes param list
     *
     * @param (string) $encoded Encoded string
     * @return (array)
     */
    protected static function decodeParamList( $encoded )
    {
        return unserialize( base64_decode( $encoded ) );
    }

    /*
     * Handles a call
     *
     * @param (integer) TTL of a cache
     * @return (string) HTML
     */
    public function handle( $ttl = 0 )
    {
        return '';
    }
}
?>