<?php
 /**
  * Cabeclaho
  * @author Rene Faustino Gabriel Junior <renefgj@gmail.com:
  * @copyright Copyright (c) 2014
  * @access public
  * @version v.0.14.18
  * @package Layout
  * @subpackage header
 */
require("db.php");
require("_class/_class_header_fz.php");
$hd = new header;
echo $hd->cab();
echo $hd->cab_banner();
global $cr;
$cr = chr(13).chr(10);

?>
