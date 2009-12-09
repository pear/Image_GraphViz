--TEST--
Unit test for graph with clusters
--FILE--
<?php

/**
 * Test 17: "Process diagram with clusters"
 *
 * Graph definition taken from GraphViz documentation
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, array(), 'G', false);

// cluster0
$graph->addCluster('cluster0', 'process #1',
                   array('style' => 'filled', 'color' => 'lightgrey'));
$graph->addNode('a0', null, 'cluster0');
$graph->addNode('a1', null, 'cluster0');
$graph->addNode('a2', null, 'cluster0');
$graph->addNode('a3', null, 'cluster0');
$graph->addEdge(array('a0' => 'a1'));
$graph->addEdge(array('a1' => 'a2'));
$graph->addEdge(array('a2' => 'a3'));

// cluster1
$graph->addCluster('cluster1', 'process #2',
                   array('color' => 'blue'));
$graph->addNode('b0', null, 'cluster1');
$graph->addNode('b1', null, 'cluster1');
$graph->addNode('b2', null, 'cluster1');
$graph->addNode('b3', null, 'cluster1');
$graph->addEdge(array('b0' => 'b1'));
$graph->addEdge(array('b1' => 'b2'));
$graph->addEdge(array('b2' => 'b3'));

// Global
$graph->addNode('start', array('shape' => 'Mdiamond'));
$graph->addNode('end', array('shape' => 'Msquare'));

$graph->addEdge(array('start' => 'a0'));
$graph->addEdge(array('start' => 'b0'));

$graph->addEdge(array('a1' => 'b3'));
$graph->addEdge(array('b2' => 'a3'));
$graph->addEdge(array('a3' => 'a0'));
$graph->addEdge(array('a3' => 'end'));
$graph->addEdge(array('b3' => 'end'));

echo $graph->parse();

?>
--EXPECT--
digraph G {
    start [ shape=Mdiamond ];
    end [ shape=Msquare ];
    subgraph cluster0 {
        graph [ style=filled,color=lightgrey,label="process #1" ];
        a0;
        a1;
        a2;
        a3;
    }
    subgraph cluster1 {
        graph [ color=blue,label="process #2" ];
        b0;
        b1;
        b2;
        b3;
    }
    a0 -> a1;
    a1 -> a2;
    a1 -> b3;
    a2 -> a3;
    b0 -> b1;
    b1 -> b2;
    b2 -> b3;
    b2 -> a3;
    start -> a0;
    start -> b0;
    a3 -> a0;
    a3 -> end;
    b3 -> end;
}