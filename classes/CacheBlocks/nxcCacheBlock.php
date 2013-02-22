<?php
/**
 * @author VaL <vd@nxc.no>
 * @copyright Copyright (C) 2011 NXC AS
 * @license GNU GPL v2
 * @package nxc-cache-block
 */

/**
 * Base cache block object
 */
abstract class nxcCacheBlock
{
    /**
     * A list with submitted parameters
     *
     * @var (array)
     */
    protected $ParamList = array();

    /**
     * @param (array)
     */
    public function __construct( $paramList = array() )
    {
        $this->ParamList = $paramList;
    }

    /**
     * @param (array)
     * @return (__CLASS__)
     */
    public static function get( $paramList = array() )
    {
        return new self( $paramList );
    }

    /**
     * Returns submitted variable
     *
     * @param (string) $name Variable name
     * @param (bool) $isRequired Checks if an exception should be thrown if variable does not exist
     * @param (mixed) $default Default value of variable
     * @return (mixed)
     */
    protected function variable( $name, $isRequired = true, $default = false )
    {
        if ( !isset( $this->ParamList[$name] ) )
        {
            if ( $isRequired )
            {
                throw new nxcInvalidArgumentException( 'Variable "' . $name . '" does not exist' );
            }

            return $default;
        }

        return $this->ParamList[$name];
    }

    /**
     * Processes a cache block
     *
     * @return (string)
     * @see self::handle()
     */
    protected function process()
    {
        return '';
    }

    /**
     * Processes a cache block
     *
     * @param (int) TTL
     *
     * @return (string)
     */
    public function handle( $ttl = 0 )
    {
        $groupKey = 'nxc-cache-block';
        $accumulatorKey = get_class( $this );
        eZDebug::createAccumulatorGroup( $groupKey, 'NXC Cache Block Total' );
        eZDebug::accumulatorStart( $groupKey );

        if ( $ttl )
        {
            $cache = new nxcCache( $this->getCacheKey() );
            if ( $cache->exists() and !$cache->isExpired( $ttl ) )
            {
                eZDebug::accumulatorStart( $accumulatorKey, $groupKey, '[CACHE] ' . $accumulatorKey );

                $result = $cache->getContent();

                eZDebug::accumulatorStop( $accumulatorKey );
                eZDebug::accumulatorStop( $groupKey );

                return $result;
            }
        }

        eZDebug::accumulatorStart( $accumulatorKey, $groupKey, $accumulatorKey );

        $result = $this->process();

        if ( $ttl )
        {
            $cache->store( $result );
        }

        eZDebug::accumulatorStop( $accumulatorKey );
        eZDebug::accumulatorStop( $groupKey );

        return $result;
    }

    /**
     * Returns submitted variable list
     *
     * @return (mixed)
     */
    public function getVariableList()
    {
        return $this->ParamList;
    }

    /**
     * Returns submitted variable list
     *
     * @return (mixed)
     */
    protected function getCacheKey()
    {
        return get_class( $this ) . ':' . serialize( $this->ParamList );
    }

}
?>