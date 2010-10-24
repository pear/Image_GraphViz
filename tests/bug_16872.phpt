--TEST--
Bug #16872: Cluster IDs start with "cluster"
--FILE--
<?php

/**
 * Bug 16872: "Cluster IDs start with 'cluster'"
 *
 * Cluster ID must start with "cluster" to have a box around it
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 * @link     http://pear.php.net/bugs/bug.php?id=16872
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, array('rankdir' => 'LR',
                                        'ranksep' => .75),
                         'sp_d_rcp_001', false);
$graph->addCluster('pck_courbe_rcp', 'pck_courbe_rcp',
                array('color' => 'green'));
$graph->addNode('sp_d_rcp_001', array('shape' => 'component'), 'pck_courbe_rcp');
$result = array(
    array('tab' => 'courbe_rcp', 'action' => 'S'),
    array('tab' => 'courbe_rcp', 'action' => 'D'),
    array('tab' => 'detail_rcp', 'action' => 'S'),
    array('tab' => 'detail_rcp', 'action' => 'D'),
);
$lst_tab = array();
foreach ($result as $row) {
    $table = $row['tab'];
    $action = $row['action'];
    if (array_key_exists($table, $lst_tab) == false){
        $graph->addNode($table, array('shape' => 'box'));
        $lst_tab[] = $table;
    }
    $color = ($action == 'D') ? 'red' : 'blue';
    $graph->addEdge(array('sp_d_rcp_001' => $table),
                 array('color' => $color,
                       'label' => $action,
                       'id' => $action.$table));
}

echo $graph->parse();

?>
--EXPECT--
digraph sp_d_rcp_001 {
    rankdir=LR;
    ranksep=0.75;
    courbe_rcp [ shape=box ];
    detail_rcp [ shape=box ];
    subgraph cluster_pck_courbe_rcp {
        graph [ color=green,label=pck_courbe_rcp ];
        sp_d_rcp_001 [ shape=component ];
    }
    sp_d_rcp_001 -> courbe_rcp [ color=blue,label=S,id=Scourbe_rcp ];
    sp_d_rcp_001 -> courbe_rcp [ color=red,label=D,id=Dcourbe_rcp ];
    sp_d_rcp_001 -> detail_rcp [ color=blue,label=S,id=Sdetail_rcp ];
    sp_d_rcp_001 -> detail_rcp [ color=red,label=D,id=Ddetail_rcp ];
}