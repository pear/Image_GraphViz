--TEST--
Unit test for graph with edges on clusters
--FILE--
<?php

/**
 * Test 17: "Graph with edges on clusters"
 *
 * Graph definition taken from GraphViz documentation
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, array('compound' => true), 'G', false);

$graph->addCluster('cluster0', '');
$graph->addNode('a', null, 'cluster0');
$graph->addNode('b', null, 'cluster0');
$graph->addNode('c', null, 'cluster0');
$graph->addNode('d', null, 'cluster0');

$graph->addEdge(array('a' => 'b'));
$graph->addEdge(array('a' => 'c'));
$graph->addEdge(array('b' => 'd'));
$graph->addEdge(array('c' => 'd'));

$graph->addCluster('cluster1', '');
$graph->addNode('e', null, 'cluster1');
$graph->addNode('f', null, 'cluster1');
$graph->addNode('g', null, 'cluster1');

$graph->addEdge(array('e' => 'g'));
$graph->addEdge(array('e' => 'f'));

$graph->addEdge(array('b' => 'f'), array('lhead' => 'cluster1'));
$graph->addEdge(array('d' => 'e'));
$graph->addEdge(array('c' => 'g'), array('ltail' => 'cluster0',
                                         'lhead' => 'cluster1'));
$graph->addEdge(array('c' => 'e'), array('ltail' => 'cluster0'));

$graph->addEdge(array('d' => 'h'));

echo $graph->parse();

?>
--EXPECT--
digraph G {
    compound=true;
    subgraph cluster0 {
        a;
        b;
        c;
        d;
    }
    subgraph cluster1 {
        e;
        f;
        g;
    }
    a -> b;
    a -> c;
    b -> d;
    b -> f [ lhead=cluster1 ];
    c -> d;
    c -> g [ ltail=cluster0,lhead=cluster1 ];
    c -> e [ ltail=cluster0 ];
    e -> g;
    e -> f;
    d -> e;
    d -> h;
}