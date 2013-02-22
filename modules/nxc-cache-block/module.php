<?php
/**
 * Module to handle cache blocks files
 *
 * @author VaL Doroshchuk <vd@nxc.no>
 * @copyright Copyright (C) 2011 NXC AS
 * @license GNU GPL v2
 * @package nxc-cache-block
 */

$Module = array( 'name' => 'nxc Cache Block module',
                 'variable_params' => true );

$ViewList = array();
$ViewList['process'] = array(
    'script' => 'process.php',
    'params' => array( 'Name', 'Hash', 'TTL' ),
    );

?>
