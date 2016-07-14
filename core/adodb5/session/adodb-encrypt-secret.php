<?php

/*
@version   v5.20.4  30-Mar-2016
@copyright (c) 2000-2013 John Lim (jlim#natsoft.com). All rights reserved.
@copyright (c) 2014      Damien Regad, Mark Newnham and the ADOdb community
         Contributed by Ross Smith (adodb@netebb.com).
  Released under both BSD license and Lesser GPL library license.
  Whenever there is any discrepancy between the two licenses,
  the BSD license will take precedence.
      Set tabs to 4 for best viewing.

*/

@define('HORDE_BASE', dirname(dirname(dirname(__FILE__))).'/horde');

if (!is_dir(HORDE_BASE)) {
    trigger_error(sprintf('Directory not found: \'%s\'', HORDE_BASE), E_USER_ERROR);

    return 0;
}

include_once HORDE_BASE.'/lib/Horde.php';
include_once HORDE_BASE.'/lib/Secret.php';

/**

 This may be resolved with 4.3.3.

 */
class ADODB_Encrypt_Secret
{
    public function write($data, $key)
    {
        return Secret::write($key, $data);
    }


    public function read($data, $key)
    {
        return Secret::read($key, $data);
    }
}

return 1;
