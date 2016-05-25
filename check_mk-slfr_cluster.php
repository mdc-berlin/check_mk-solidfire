<?php

# created by Raymond Burkholder
#   rburkholder@quovadis.bm
#   raymond@burkholder.net

# date: 2016/05/25

# ln -s /omd/sites/XXXX/custom/check_mk-slfr_cluster.php /omd/sites/XXXX/share/pnp4nagios/htdocs/templates/check_mk-slfr_cluster.php

# https://docs.pnp4nagios.org/pnp-0.6/tpl

#$opt[1] = "--vertical-label 'MEMORY(MB)' -X0 --upper-limit " . ($MAX[1] * 120 / 100) . " -l0  --title \"Memory usage $hostname\" ";
#$opt[1] = "--vertical-label 'Number' -u 10 -X0 --title \"TCP Connection stats on $hostname\" ";
$RRD = array();
foreach ($NAME as $i => $n) {
    $RRD[$n] = "$RRDFILE[$i]:$DS[$i]:AVERAGE";
    $WARN[$n] = $WARN[$i];
    $CRIT[$n] = $CRIT[$i];
    $MIN[$n]  = $MIN[$i];
    $MAX[$n]  = $MAX[$i];
}


#$stats = array(
#  array(2,  "SYN_SENT", "   ", "#a00000", ""),
#  array(3,  "SYN_RECV", "   ", "#ff4000", ""),
#  array(1,  "ESTABLISHED", "", "#00f040", ""),
#  array(6,  "TIME_WAIT", "  ", "#00b0b0", "\\n"),
#  array(4,  "LAST_ACK", "   ", "#c060ff", ""),
#  array(5,  "CLOSE_WAIT", " ", "#f000f0", ""),
#  array(7,  "CLOSED", "     ", "#ffc000", ""),
#  array(8,  "CLOSING", "    ", "#ffc080", "\\n"),
#  array(9,  "FIN_WAIT1", "  ", "#cccccc", ""),
#  array(10, "FIN_WAIT2", "  ", "#888888", "\\n")
#);

#foreach ($stats as $entry) {
#   list($i, $stat, $spaces, $color, $nl) = $entry;
#   $def[1] .= "DEF:$stat=$RRDFILE[$i]:$DS[$i]:MAX ";
#   $def[1] .= "AREA:$stat$color:\"$stat\":STACK ";
#   $def[1] .= "GPRINT:$stat:LAST:\"$spaces%3.0lf$nl\" ";
#}

$ix = 1;

$ds_name[$ix] = "IOPS";
$opt[$ix] = "--vertical-label 'operations' -u 10 -X0 --title \"totalOps on $hostname\" ";
$def[$ix] = "";

$name = "totalOps";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:totalOps=$RRD[$name] ";
  $def[$ix] .= "AREA:totalOps#ff8800:\"totalOps   \" ";
  $def[$ix] .= "GPRINT:totalOps:LAST:\"Last %6.0lf \" ";
  $def[$ix] .= "GPRINT:totalOps:AVERAGE:\"Average %6.0lf \" ";
  $def[$ix] .= "GPRINT:totalOps:MAX:\"Max %6.0lf \\n\" ";
  }

$name = "currentIOPS";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:currentIOPS=$RRD[$name] ";
  $def[$ix] .= "LINE:currentIOPS#1122cc:\"currentIOPS\" ";
  $def[$ix] .= "GPRINT:currentIOPS:LAST:\"Last %6.0lf \" ";
  $def[$ix] .= "GPRINT:currentIOPS:AVERAGE:\"Average %6.0lf \" ";
  $def[$ix] .= "GPRINT:currentIOPS:MAX:\"Max %6.0lf \\n\" ";
  }

$ix = 2;

$ds_name[$ix] = "IOSize";
$opt[$ix] = "--vertical-label 'IOSize' -u 10 -X0 --title \"clusterRecentIOSize on $hostname\" ";
$def[$ix] = "";

$name = "clusterRecentIOSize";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[$name] ";
  $def[$ix] .= "AREA:$name#ff8800:\"totalOps   \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Average %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.0lf \\n\" ";
  }


$ix = 3;

$ds_name[$ix] = "Efficiency Stats";
$opt[$ix] = "--vertical-label 'factors' -u 10 -X0 --title \"stats on $hostname\" ";
$def[$ix] = "";

$name = "thinProvisioningFactor";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[$name] ";
  $def[$ix] .= "LINE:$name#1122cc:\"$name\" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.3lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Average %6.3lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.3lf \\n\" ";
  }

$name = "deDuplicationFactor";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[$name] ";
  $def[$ix] .= "LINE:$name#885589:\"$name   \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.3lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Average %6.3lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.3lf \\n\" ";
  }

$name = "compressionFactor";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[$name] ";
  $def[$ix] .= "LINE:$name#aa3423:\"$name     \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.3lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Average %6.3lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.3lf \\n\" ";
  }

$name = "efficiencyFactor";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[$name] ";
  $def[$ix] .= "LINE:$name#ee4e52:\"$name      \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.3lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Average %6.3lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.3lf \\n\" ";
  }

?>

