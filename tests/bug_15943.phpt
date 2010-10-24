--TEST--
Bug #15943: Nested subgraphs
--FILE--
<?php

/**
 * Bug 15943: "Nested subgraph"
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 * @link     http://pear.php.net/bugs/bug.php?id=15019
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, '', 'G', true);
$graph->addCluster('A', '');
$graph->addCluster('B', '', array('label' => 'Cluster B'), 'A');
$graph->addCluster('C', '', null, 'A');
$graph->addCluster('D', '', null, 'B');
$graph->addNode('node0', null, 'A');
$graph->addNode('node1', null, 'A');
$graph->addNode('node2', array('color' => 'blue'), 'B');
$graph->addNode('node3', null, 'B');
$graph->addNode('node4', null, 'C');
$graph->addNode('node6', null, 'D');
$graph->addNode('node5');
$graph->addEdge(array('node0' => 'node1'));
$graph->addEdge(array('node2' => 'node3'));
$graph->addEdge(array('node0' => 'node4'));
$graph->addEdge(array('node4' => 'node5'));
$graph->addEdge(array('node5' => 'node6'));

echo $graph->parse();


?>
--EXPECT--
strict digraph G {
    node5;
    subgraph cluster_A {
        node0;
        node1;
        subgraph cluster_B {
            graph [ label="Cluster B" ];
            node2 [ color=blue ];
            node3;
            subgraph cluster_D {
                node6;
            }
        }
        subgraph cluster_C {
            node4;
        }
    }
    node0 -> node1;
    node0 -> node4;
    node2 -> node3;
    node4 -> node5;
    node5 -> node6;
}