<?php

# created by Raymond Burkholder
#   rburkholder@quovadis.bm
#   raymond@burkholder.net

# date: 2016/06/07

# ln -s /omd/sites/XXXX/custom/check_mk-slfr_nodes.php /omd/sites/XXXX/share/pnp4nagios/htdocs/templates/check_mk-slfr_nodes.php

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

$ix = 0;

# ====
$ix = $ix + 1;
$name = "cpu";
$ds_name[$ix] = $name;
$opt[$ix] = "--vertical-label 'percent' -u 10 -X0 --title \"$hostname/$servicedesc: $name\" ";
$def[$ix] = "";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[cpu] ";
  $def[$ix] .= "AREA:$name#1122cc:\"$name\" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Average %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.0lf \\n\" ";
  }

# ====
$ix = $ix + 1;
$ds_name[$ix] = "cBytes";
$opt[$ix] = "--vertical-label 'bytes' -u 10 -X0 --title \"$hostname/$servicedesc: cluster interface\" ";
$name = "cBytesInDelta";
$def[$ix] = "";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[cBytesInDelta] ";
  $def[$ix] .= "AREA:$name#00dd0099:\"$name  \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %9.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Avg %9.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %9.0lf \\n\" ";
  }
$name = "cBytesOutDelta";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:${name}_raw=$RRD[cBytesOutDelta] ";
  $def[$ix] .= "CDEF:$name=${name}_raw,-1,* ";
  $def[$ix] .= "AREA:$name#0000dd99:\"$name \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %9.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Avg %9.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %9.0lf \\n\" ";
  }

# ====
$ix = $ix + 1;
$ds_name[$ix] = "sBytes";
$opt[$ix] = "--vertical-label 'bytes' -u 10 -X0 --title \"$hostname/$servicedesc: storage interface\" ";
$name = "sBytesInDelta";
$def[$ix] = "";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[sBytesInDelta] ";
  $def[$ix] .= "AREA:$name#00ee00:\"$name  \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Avg %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.0lf \\n\" ";
  }
$name = "sBytesOutDelta";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:${name}_raw=$RRD[sBytesOutDelta] ";
  $def[$ix] .= "CDEF:$name=${name}_raw,-1,* ";
  $def[$ix] .= "AREA:$name#0000ee:\"$name \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Avg %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.0lf \\n\" ";
  }

 # ====
$ix = $ix + 1;
$ds_name[$ix] = "mBytes";
$opt[$ix] = "--vertical-label 'bytes' -u 10 -X0 --title \"$hostname/$servicedesc: management interface\" ";
$name = "mBytesInDelta";
$def[$ix] = "";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[mBytesInDelta] ";
  $def[$ix] .= "AREA:$name#00cc00:\"$name  \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %7.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Avg %7.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %7.0lf \\n\" ";
  }
$name = "mBytesOutDelta";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:${name}_raw=$RRD[mBytesOutDelta] ";
  $def[$ix] .= "CDEF:$name=${name}_raw,-1,* ";
  $def[$ix] .= "AREA:$name#0000cc:\"$name \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %7.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Avg %7.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %7.0lf \\n\" ";
  }


?>
