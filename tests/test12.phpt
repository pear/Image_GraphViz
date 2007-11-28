--TEST--
Unit test for graph with ports
--FILE--
<?php

/**
 * Test 12: "Graph of binary search tree"
 *
 * Graph definition taken from GraphViz documentation
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, array(), 'structs', false);

$graph->addNode('node0', array('shape' => 'record',
                                 'label' => '<f0> |<f1> G|<f2> '));
$graph->addNode('node1', array('shape' => 'record',
                                 'label' => '<f0> |<f1> E|<f2> '));
$graph->addNode('node2', array('shape' => 'record',
                                 'label' => '<f0> |<f1> B|<f2> '));
$graph->addNode('node3', array('shape' => 'record',
                                 'label' => '<f0> |<f1> F|<f2> '));
$graph->addNode('node4', array('shape' => 'record',
                                 'label' => '<f0> |<f1> R|<f2> '));
$graph->addNode('node5', array('shape' => 'record',
                                 'label' => '<f0> |<f1> H|<f2> '));
$graph->addNode('node6', array('shape' => 'record',
                                 'label' => '<f0> |<f1> Y|<f2> '));
$graph->addNode('node7', array('shape' => 'record',
                                 'label' => '<f0> |<f1> A|<f2> '));
$graph->addNode('node8', array('shape' => 'record',
                                 'label' => '<f0> |<f1> C|<f2> '));

$graph->addEdge(array('node0' => 'node4'), null,
                array('node0' => 'f2', 'node4' => 'f1'));
$graph->addEdge(array('node0' => 'node1'), null,
                array('node0' => 'f0', 'node1' => 'f1'));
$graph->addEdge(array('node1' => 'node2'), null,
                array('node1' => 'f0', 'node2' => 'f1'));
$graph->addEdge(array('node1' => 'node3'), null,
                array('node1' => 'f2', 'node3' => 'f1'));
$graph->addEdge(array('node2' => 'node8'), null,
                array('node2' => 'f2', 'node8' => 'f1'));
$graph->addEdge(array('node2' => 'node7'), null,
                array('node2' => 'f0', 'node7' => 'f1'));
$graph->addEdge(array('node4' => 'node6'), null,
                array('node4' => 'f2', 'node6' => 'f1'));
$graph->addEdge(array('node4' => 'node5'), null,
                array('node4' => 'f0', 'node5' => 'f1'));

echo $graph->parse();

?>
--EXPECT--
digraph structs {
    node0 [ shape=record,label="<f0> |<f1> G|<f2> " ];
    node1 [ shape=record,label="<f0> |<f1> E|<f2> " ];
    node2 [ shape=record,label="<f0> |<f1> B|<f2> " ];
    node3 [ shape=record,label="<f0> |<f1> F|<f2> " ];
    node4 [ shape=record,label="<f0> |<f1> R|<f2> " ];
    node5 [ shape=record,label="<f0> |<f1> H|<f2> " ];
    node6 [ shape=record,label="<f0> |<f1> Y|<f2> " ];
    node7 [ shape=record,label="<f0> |<f1> A|<f2> " ];
    node8 [ shape=record,label="<f0> |<f1> C|<f2> " ];
    node0:f2 -> node4:f1;
    node0:f0 -> node1:f1;
    node1:f0 -> node2:f1;
    node1:f2 -> node3:f1;
    node2:f2 -> node8:f1;
    node2:f0 -> node7:f1;
    node4:f2 -> node6:f1;
    node4:f0 -> node5:f1;
}
