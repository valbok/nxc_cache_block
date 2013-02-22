<?php
/**
 * @author VaL <vd@nxc.no>
 * @copyright Copyright (C) 2011 NXC AS
 * @license GNU GPL v2
 * @package nxc-cache-block
 */

/**
 * Handles including of a template
 * @param (string) uri
 * @param (string) resource
 *
 * @return (string)
 */
class nxcIncludeCacheBlock extends nxcCacheBlock
{
    /**
     * @reimp
     */
    protected function process()
    {
        $tpl = eZTemplate::factory();
        foreach ( $this->getVariableList() as $key => $value )
        {
            $tpl->setVariable( $key, $value );
        }

        $uri = $this->variable( 'uri' );
        if ( strpos( $uri, 'design:' ) === false )
        {
            $uri = 'design:' . $uri;
        }

        return $tpl->fetch( $uri );
    }
}
?>
