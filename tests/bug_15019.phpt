--TEST--
Bug #15019: addCluster using attributes twice
--FILE--
<?php

/**
 * Bug 15019: "addCluster using attributes twice"
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 * @link     http://pear.php.net/bugs/bug.php?id=15019
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, '', 'Bug', true);
$graph->addCluster('cluster_0', 'Cluster',
    array('fontcolor' => 'black', 'style' => 'filled' ));
$graph->addNode( 'Node', '', 'cluster_0');
echo $graph->parse();

?>
--EXPECT--
strict digraph Bug {
    subgraph cluster_0 {
        graph [ fontcolor=black,style=filled,label=Cluster ];
        "Node" [ 0="" ];
    }
}
