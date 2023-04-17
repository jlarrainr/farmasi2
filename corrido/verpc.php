<?php $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
echo $hostname;
echo gethostbyaddr($REMOTE_ADDR);
?>