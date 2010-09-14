<?php
//GET SERVER LOADS
$loadresult = @exec('uptime');
preg_match("/averages?: ([0-9\.]+),[\s]+([0-9\.]+),[\s]+([0-9\.]+)/",$loadresult,$avgs);

//GET SERVER UPTIME
$uptime = explode(' up ', $loadresult);
$uptime = explode(',', $uptime[1]);
$uptime = $uptime[0].', '.$uptime[1];

#$data .= "Server Load Averages $avgs[1], $avgs[2], $avgs[3]\n";
#$data .= "Server Uptime $uptime";
#echo $avgs[1]."\n";

#$avgs[1] = 5.99;
if ( $avgs[1] > 5) {
    $ps_out2 = exec("ps aux", $ps_out);
    #print_r(implode($ps_out));
    $mysql_out2 = exec("mysqladmin processlist", $mysql_out);
    #print_r(implode($mysql_out));

    file_put_contents("/root/check_load/".time().".txt", $loadresult."\n====\n".implode("\n",$ps_out)."\n====\n".implode("\n",$mysql_out));
}

if ( $avgs[1] > 10) {
    @exec('/etc/init.d/httpd stop');
}

?>
