<?php
/**
 * Module to proccess nxc-cache-blocks
 *
 * @author VaL Doroshchuk <vd@nxc.no>
 * @copyright Copyright (C) 2011 NXC AS
 * @license GNU GPL v2
 * @package nxc-cache-block
 */

$Module = $Params['Module'];
$http = eZHTTPTool::instance();

$name = $Params['Name'];
$paramList = $http->hasGetVariable( 'd' ) ? $http->getVariable( 'd' ) : '';
$hash = $Params['Hash'];
$ttl = $Params['TTL'];

$result = '';

try
{
    $header = isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ? $_SERVER['HTTP_X_REQUESTED_WITH'] : false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ( $header != 'XMLHttpRequest' or $method != 'POST' )
    {
        throw new nxcAccessDeniedException( 'Access denied' );
    }

    $result = ncbProcessHandler::get( $name, $paramList, $hash )->handle( $ttl );
}
catch ( nxcAccessDeniedException $e )
{
    header('HTTP/1.1 404 Page not found');
    nxcExceptionHandler::add( $e, "Could not handle the cache-block '$name'" );
}
catch ( Exception $e )
{
    header( 'HTTP/1.1 500 Internal Server Error' );
    nxcExceptionHandler::add( new nxcException( $e->getMessage() ), "Could not handle the cache-block '$name'" );
}

$errorList = nxcExceptionHandler::getErrorMessageList();

echo $errorList ? implode( "\n<br/>", $errorList ) : $result;

eZExecution::cleanExit();

?>
