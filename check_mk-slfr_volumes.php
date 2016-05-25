<?php

# created by Raymond Burkholder
#   rburkholder@quovadis.bm
#   raymond@burkholder.net

# date: 2016/05/25

# ln -s /omd/sites/XXXX/custom/check_mk-slfr_volumes.php /omd/sites/XXXX/share/pnp4nagios/htdocs/templates/check_mk-slfr_volumes.php

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
$name = "clientQueueDepth";
$ds_name[$ix] = $name;
$opt[$ix] = "--vertical-label 'depth' -u 10 -X0 --title \"$hostname/$servicedesc: $name\" ";
$def[$ix] = "";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[clientQueueDepth] ";
  $def[$ix] .= "AREA:$name#1122cc:\"$name\" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Average %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.0lf \\n\" ";
  }

# ====
$ix = $ix + 1;
$name = "volumeUtilization";
$ds_name[$ix] = $name;
$opt[$ix] = "--vertical-label 'utilization (0.0-1.0)' -u 1 -X0 --title \"$hostname/$servicedesc: $name\" ";
$def[$ix] = "";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[volumeUtilization] ";
  $def[$ix] .= "AREA:$name#885589:\"$name \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %5.3lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Average %5.3lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %5.3lf \\n\" ";
  }

# ====
$ix = $ix + 1;
$ds_name[$ix] = "bytesDelta";
$name = "readBytesDelta";
$opt[$ix] = "--vertical-label 'bytes' -u 10 -X0 --title \"$hostname/$servicedesc: bytesDelta\" ";
$def[$ix] = "";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[readBytesDelta] ";
  $def[$ix] .= "AREA:$name#00dd0099:\"$name  \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %9.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Avg %9.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %9.0lf \\n\" ";
  }
$name = "writeBytesDelta";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:${name}_raw=$RRD[writeBytesDelta] ";
  $def[$ix] .= "CDEF:$name=${name}_raw,-1,* ";
  $def[$ix] .= "AREA:$name#0000dd99:\"$name \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %9.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Avg %9.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %9.0lf \\n\" ";
  }

# ====
$ix = $ix + 1;
$name = "actualIOPS";
$ds_name[$ix] = $name;
$opt[$ix] = "--vertical-label 'IOPS' -u 10 -X0 --title \"$hostname/$servicedesc: $name\" ";
$def[$ix] = "";

if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[actualIOPS] ";
  $def[$ix] .= "AREA:$name#ff8800:\"$name\" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Average %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.0lf \\n\" ";
  }

# ====
$ix = $ix + 1;
$ds_name[$ix] = "opsDelta";
$name = "readOpsDelta";
$opt[$ix] = "--vertical-label 'ops' -u 10 -X0 --title \"$hostname/$servicedesc: opsDelta\" ";
$def[$ix] = "";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[readOpsDelta] ";
  $def[$ix] .= "AREA:$name#00ee00:\"$name  \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Avg %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.0lf \\n\" ";
  }
$name = "writeOpsDelta";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:${name}_raw=$RRD[writeOpsDelta] ";
  $def[$ix] .= "CDEF:$name=${name}_raw,-1,* ";
  $def[$ix] .= "AREA:$name#0000ee:\"$name \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Avg %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.0lf \\n\" ";
  }

 # ====
$ix = $ix + 1;
$ds_name[$ix] = "unalignedDelta";
$name = "unalignedReadsDelta";
$opt[$ix] = "--vertical-label 'ops' -u 10 -X0 --title \"$hostname/$servicedesc: unalignedDelta\" ";
$def[$ix] = "";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[unalignedReadsDelta] ";
  $def[$ix] .= "AREA:$name#00cc00:\"$name  \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %7.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Avg %7.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %7.0lf \\n\" ";
  }
$name = "unalignedWritesDelta";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:${name}_raw=$RRD[unalignedWritesDelta] ";
  $def[$ix] .= "CDEF:$name=${name}_raw,-1,* ";
  $def[$ix] .= "AREA:$name#0000cc:\"$name \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %7.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Avg %7.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %7.0lf \\n\" ";
  }

# ====
$ix = $ix + 1;
$ds_name[$ix] = "latency IO";
$name = "readLatencyUSec";
$opt[$ix] = "--vertical-label 'microseconds' -u 10 -X0 --title \"$hostname/$servicedesc: latency\" ";
$def[$ix] = "";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[readLatencyUSec] ";
  $def[$ix] .= "AREA:$name#00cc00:\"$name  \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Avg %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.0lf \\n\" ";
  }

$name = "writeLatencyUSec";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:${name}_raw=$RRD[writeLatencyUSec] ";
  $def[$ix] .= "CDEF:$name=${name}_raw,-1,* ";
  $def[$ix] .= "AREA:$name#0000cc:\"$name \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Avg %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.0lf \\n\" ";
  }

# ====
$ix = $ix + 1;
$name = "latencyUSec";
$ds_name[$ix] = $name;
$opt[$ix] = "--vertical-label 'microseconds' -u 10 -X0 --title \"$hostname/$servicedesc: latency\" ";
$def[$ix] = "";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[latencyUSec] ";
  $def[$ix] .= "AREA:$name#aa3423:\"$name     \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Average %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.0lf \\n\" ";
  }

# ====
$ix = $ix + 1;
$name = "volumeSize";
$ds_name[$ix] = $name;
$opt[$ix] = "--vertical-label 'megabytes' -u 10 -X0 --title \"$hostname/$servicedesc: $name\" ";
$def[$ix] = "";
if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:${name}_raw=$RRD[volumeSize] ";
  $def[$ix] .= "CDEF:${name}kB=${name}_raw,1024,/ ";
  $def[$ix] .= "CDEF:${name}mB=${name}kB,1024,/ ";
  $def[$ix] .= "AREA:${name}mB#aa3423:\"$name \" ";
  $def[$ix] .= "GPRINT:${name}mB:LAST:\"Last %6.0lf \" ";
  $def[$ix] .= "GPRINT:${name}mB:AVERAGE:\"Avg %6.0lf \" ";
  $def[$ix] .= "GPRINT:${name}mB:MAX:\"Max %6.0lf \\n\" ";
  }

# ====
$ix = $ix + 1;
$name = "burstIOPSCredit";
$ds_name[$ix] = $name;
$opt[$ix] = "--vertical-label 'IOPS' -u 10 -X0 --title \"$hostname/$servicedesc: $name\" ";
$def[$ix] = "";

if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[burstIOPSCredit] ";
  $def[$ix] .= "AREA:$name#1122cc:\"$name\" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Average %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.0lf \\n\" ";
  }

# ====
$ix = $ix + 1;
$name = "throttle";
$ds_name[$ix] = $name;
$opt[$ix] = "--vertical-label 'units?' -u 10 -X0 --title \"$hostname/$servicedesc: $name\" ";
$def[$ix] = "";

if (isset($RRD[$name])) {
  $def[$ix] .= "DEF:$name=$RRD[throttle] ";
  $def[$ix] .= "AREA:$name#ff8800:\"$name   \" ";
  $def[$ix] .= "GPRINT:$name:LAST:\"Last %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:AVERAGE:\"Average %6.0lf \" ";
  $def[$ix] .= "GPRINT:$name:MAX:\"Max %6.0lf \\n\" ";
  }



?>
