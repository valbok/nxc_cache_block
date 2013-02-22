<?php
/**
 * @author VaL Doroshchuk <vd@nxc.no>
 * @copyright Copyright (C) 2011 NXC AS
 * @license GNU GPL v2
 * @package nxc-cache-block
 */

/**
 * Handler to process cache blocks
 */
class ncbProcessHandler extends ncbHandler
{
    /**
     * Security hash
     *
     * @var (string)
     */
    protected $Hash = false;

    /**
     * Returns handler instance
     *
     * @param (string) $name Cache block name
     * @param (string) $encodedParamList Ecnoded param list
     * @param (string) $hash Security hash
     * @return (__CLASS__)
     */
    public static function get( $name, $encodedParamList, $hash )
    {
        if ( self::createHash( $name, $encodedParamList ) != $hash )
        {
            throw new nxcAccessDeniedException( 'Wrong hash: ' . $hash );
        }

        $o = new self( $name, self::decodeParamList( $encodedParamList ) );
        $o->Hash = $hash;

        return $o;
    }

    /**
     * Processes a cache block call
     *
     * @param (integer) TTL of a cache
     * @return (string) HTML
     */
    public function handle( $ttl = 0 )
    {
        $result = $this->CacheBlock->handle( $ttl );

        return $result;
    }
}
?>