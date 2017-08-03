<?php
include("../sl-inc/includes/sl-env.php");
ob_start("js_out");
header("Content-type: text/javascript");
print "/*sl-dyn-js-start*/<?php";
print sl_dyn_js();
print "?>/*sl-dyn-js-end*/";
ob_end_flush();
//var_dump($_GET);
?>