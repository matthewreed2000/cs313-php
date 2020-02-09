<?php
$monthStart = date('Y-m-01');
echo date('w', strtotime('-'. date('d', time()-24*60*60) .' days'));
?>