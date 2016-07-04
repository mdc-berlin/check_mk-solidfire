# check_mk-solidfire
check_mk scripts to collect cluster and volume information from a solidfire system

<b>SolidFireAgentCluster.py</b> - python script to communicate with SolidFire cluster

The above script requires a caller script:
checkmk1:# cat /usr/lib/check_mk_agent/plugins/slfr-cluster.sh
/usr/bin/python /usr/lib/check_mk_agent/SolidFireAgentCluster.py slfr_cluster_ip 443 adminuser password mvip

<b>slfr_cluster</b> - check_mk script to process cluster section<br>
<b>check_mk-slfr_cluster.php</b> - pnp4nagios format

<b>slfr_volumes</b> - check_mk script to process volumes section<br>
<b>check_mk-slfr_volumes.php</b> - pnp4nagios format

<b>slfr_nodes</b> - check_mk script to process nodes section<br>
<b>check_mk-slfr_nodes.php</b> - pnp4nagios format
