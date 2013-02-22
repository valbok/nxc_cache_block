<?php
/**
 * Handler for nxc-cache-block operator
 *
 * @author VaL <vd@nxc.no>
 * @copyright Copyright (C) 2011 NXC AS
 * @license GNU GPL v2
 * @package nxc-cache-block
 */

class nxcCacheBlockAutoload
{
    /**
     * @reimp
     */
    function __construct()
    {
    }

    /**
     * @reimp
     */
    public function operatorList()
    {
        return array( 'nxc-cache-block' );
    }

    /**
     * @reimp
     */
    function namedParameterPerOperator()
    {
        return true;
    }

    /**
     * @reimp
     */
    function namedParameterList()
    {
        return array( 'nxc-cache-block' => array(
                        'name' =>
                            array( 'type' => 'string',
                                   'required' => true,
                                   'default' => '' ),
                        'params' =>
                            array( 'type' => 'array',
                                   'required' => false,
                                   'default' => array() ),
                        )
                    );
    }

    /**
     * @reimp
     */
    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters )
    {
        switch ( $operatorName )
        {
            case 'nxc-cache-block':
            {
                $name = $namedParameters['name'];
                $params = $namedParameters['params'];
                $paramList = isset( $params['params'] ) ? $params['params'] : array();
                $id = isset( $params['id'] ) ? $params['id'] : false;
                $ttl = isset( $params['ttl'] ) ? $params['ttl'] : 0;
                $type = isset( $params['type'] ) ? $params['type'] : false;
                $callback = isset( $params['callback'] ) ? $params['callback'] : false;

                $operatorValue = ncbTemplateHandler::get( $name, $paramList, $type, $id )->handle( $ttl, $callback );
            } break;
        }
    }

}

?>
