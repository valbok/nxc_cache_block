NXC Cache Block
===============

1. It is a template operator:

    {nxc-cache-block( NAME, PARAM_LIST )}

    Where:
    * NAME - a cache block name
    * PARAM_LIST - an associated array with params
    * PARAM_LIST['ttl'] - time to live. 0 by default. Otherwise result of requested cache block will be cached
    * PARAM_LIST['type'] - a method how result data will be handled. It can be by ajax or ssi. See also settings/nxc-cache-block.ini
    * PARAM_LIST['id'] - id of dom element. i.e. id of <a>
    * PARAM_LIST['callback'] - javascript callback


2. List of supported cache blocks:

    * Include - includes specified tpl:

    {nxc-cache-block( 'include',
                        hash( 'params', hash( 'uri', 'design:nxc-cache-block/tests/include.tpl',
                                              'var1', 'value1' ),
                              'id', 'cache-id',
                              'type', 'ajax-onload',
                              'callback', 'js.callback'
                    ) )}

3. How to create custom cache block:

    3.1. Create a class nxcYOUNAMECacheBlock like

    class nxcCustomCacheBlock extends nxcCacheBlock
    {
        public function process()
        {
            return 'custom data';
        }
    }

    3.2. $ php ./bin/php/ezpgenerateautoloads.php -e
