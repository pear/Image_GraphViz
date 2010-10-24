--TEST--
Unit test for graph with ports
--FILE--
<?php

/**
 * Test 16: "Drawing of hash table"
 *
 * Graph definition taken from GraphViz documentation
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, array(), 'G', false);

$graph->setAttributes(array('nodesep' => 0.05,
                            'rankdir' => 'LR'));

$graph->addNode('node0', array('shape' => 'record',
                               'label' => '<f0> |<f1> |<f2> |<f3> |<f4> |<f5> |<f6> | ',
                               'height' => 2.5));
$graph->addNode('node1', array('shape' => 'record',
                               'label' => '{<n> n14 | 719 |<p> }'));
$graph->addNode('node2', array('shape' => 'record',
                               'label' => '{<n> a1 | 805 |<p> }'));
$graph->addNode('node3', array('shape' => 'record',
                               'label' => '{<n> i9 | 718 |<p> }'));
$graph->addNode('node4', array('shape' => 'record',
                               'label' => '{<n> e5 | 989 |<p> }'));
$graph->addNode('node5', array('shape' => 'record',
                               'label' => '{<n> t20 | 959 |<p> }'));
$graph->addNode('node6', array('shape' => 'record',
                               'label' => '{<n> o15 | 794 |<p> }'));
$graph->addNode('node7', array('shape' => 'record',
                               'label' => '{<n> s19 | 659 |<p> }'));

$graph->addEdge(array('node0' => 'node1'), null,
                array('node0' => 'f0', 'node1' => 'n'));
$graph->addEdge(array('node0' => 'node2'), null,
                array('node0' => 'f1', 'node2' => 'n'));
$graph->addEdge(array('node0' => 'node3'), null,
                array('node0' => 'f2', 'node3' => 'n'));
$graph->addEdge(array('node0' => 'node4'), null,
                array('node0' => 'f5', 'node4' => 'n'));
$graph->addEdge(array('node0' => 'node5'), null,
                array('node0' => 'f6', 'node5' => 'n'));
$graph->addEdge(array('node2' => 'node6'), null,
                array('node2' => 'p', 'node6' => 'n'));
$graph->addEdge(array('node4' => 'node7'), null,
                array('node4' => 'p', 'node7' => 'n'));

echo $graph->parse();

?>
--EXPECT--
digraph G {
    nodesep=0.05;
    rankdir=LR;
    node0 [ shape=record,label="<f0> |<f1> |<f2> |<f3> |<f4> |<f5> |<f6> | ",height=2.5 ];
    node1 [ shape=record,label="{<n> n14 | 719 |<p> }" ];
    node2 [ shape=record,label="{<n> a1 | 805 |<p> }" ];
    node3 [ shape=record,label="{<n> i9 | 718 |<p> }" ];
    node4 [ shape=record,label="{<n> e5 | 989 |<p> }" ];
    node5 [ shape=record,label="{<n> t20 | 959 |<p> }" ];
    node6 [ shape=record,label="{<n> o15 | 794 |<p> }" ];
    node7 [ shape=record,label="{<n> s19 | 659 |<p> }" ];
    node0:f0 -> node1:n;
    node0:f1 -> node2:n;
    node0:f2 -> node3:n;
    node0:f5 -> node4:n;
    node0:f6 -> node5:n;
    node2:p -> node6:n;
    node4:p -> node7:n;
}