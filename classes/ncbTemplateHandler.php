<?php
/**
 * @author VaL <vd@nxc.no>
 * @copyright Copyright (C) 2011 NXC AS
 * @license GNU GPL v2
 * @package nxc-cache-block
 */

/**
 * Handler to process templace cache block calls
 */
class ncbTemplateHandler extends ncbHandler
{
    /**
     * Handler type
     *
     * @var (string)
     */
    protected $Type = false;

    /**
     * Cache block ID
     *
     * @var (string)
     */
    protected $ID = false;

    /**
     * Returns handler instance
     *
     * @param (string) $name Cache block name
     * @param (array) $paramList Param list
     * @param (string) $type Handler type
     * @return (__CLASS__)
     */
    public static function get( $name, $paramList = array(), $type = false, $id = false )
    {
        $o = new self( $name, $paramList );
        $o->Type = $type !== false ? $type : self::getDefaultType();
        $o->ID = $id ? $id : md5( time() . ':' . mt_rand() );

        return $o;
    }

    /**
     * Returns a cache block handler type
     *
     * @return (string)
     */
    protected static function getDefaultType()
    {
        $ini = eZINI::instance( 'nxc-cache-block.ini' );
        $type = $ini->hasVariable( 'CacheBlockSettings', 'DefaultType' ) ? $ini->variable( 'CacheBlockSettings', 'DefaultType' ) : '';

        return $type;
    }

    /**
     * Returns supported handler type list
     *
     * @return (array)
     */
    protected static function getTemplateList()
    {
        $ini = eZINI::instance( 'nxc-cache-block.ini' );
        return $ini->hasVariable( 'CacheBlockSettings', 'TypeTemplateList' ) ? $ini->variable( 'CacheBlockSettings', 'TypeTemplateList' ) : array();
    }

    /**
     * Returns path to template by handler type
     *
     * @param (string)
     * @return (string)
     */
    protected static function getTemplate( $type )
    {
        $list = self::getTemplateList();
        $default = self::getDefaultType();

        return isset( $list[$type] ) ? $list[$type] : false;
    }

    /*
     * Handles a call from template
     *
     * @param (integer) TTL of a cache
     * @return (string) HTML
     */
    public function handle( $ttl = 0, $callback = false )
    {
        if ( $this->Type === '' )
        {
            return $this->CacheBlock->handle( $ttl );
        }

        $params = self::encodeParamList( $this->ParamList );

        $template = self::getTemplate( $this->Type );
        if ( !$template )
        {
            throw new nxcRunTimeException( 'Could not find a template by the type: ' . $this->Type );
        }

        $tpl = eZTemplate::factory();
        $tpl->setVariable( 'id', $this->ID );
        $tpl->setVariable( 'nxc_cache_block_uri', $this->getURI( $ttl ) );
        $tpl->setVariable( 'callback', $callback );

        return $tpl->fetch( $template );
    }

    /**
     * Returns URI to process the cache block
     *
     * @param (int)
     * @return (string)
     */
    protected function getURI( $ttl )
    {
        $params = self::encodeParamList( $this->ParamList );
        $uri = '/nxc-cache-block/process/' . $this->Name . '/' . self::createHash( $this->Name, $params ) . '/' . $ttl . '?d=' . $params;
        eZURI::transformURI( $uri );

        return $uri;
    }
}
?>
