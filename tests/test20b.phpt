--TEST--
Unit test for graph with edges on clusters not "cluster"-named IDs
--FILE--
<?php

/**
 * Test 17: "Graph with edges on clusters not 'cluster'-named IDs"
 *
 * Graph definition taken from GraphViz documentation
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, array('compound' => true), 'G', false);

$graph->addCluster(0, '');
$graph->addNode('a', null, 0);
$graph->addNode('b', null, 0);
$graph->addNode('c', null, 0);
$graph->addNode('d', null, 0);

$graph->addEdge(array('a' => 'b'));
$graph->addEdge(array('a' => 'c'));
$graph->addEdge(array('b' => 'd'));
$graph->addEdge(array('c' => 'd'));

$graph->addCluster(1, '');
$graph->addNode('e', null, 1);
$graph->addNode('f', null, 1);
$graph->addNode('g', null, 1);

$graph->addEdge(array('e' => 'g'));
$graph->addEdge(array('e' => 'f'));

$graph->addEdge(array('b' => 'f'), array('lhead' => 1));
$graph->addEdge(array('d' => 'e'));
$graph->addEdge(array('c' => 'g'), array('ltail' => 0,
                                         'lhead' => 1));
$graph->addEdge(array('c' => 'e'), array('ltail' => 0));

$graph->addEdge(array('d' => 'h'));

echo $graph->parse();

?>
--EXPECT--
digraph G {
    compound=true;
    subgraph cluster_0 {
        a;
        b;
        c;
        d;
    }
    subgraph cluster_1 {
        e;
        f;
        g;
    }
    a -> b;
    a -> c;
    b -> d;
    b -> f [ lhead=cluster_1 ];
    c -> d;
    c -> g [ ltail=cluster_0,lhead=cluster_1 ];
    c -> e [ ltail=cluster_0 ];
    e -> g;
    e -> f;
    d -> e;
    d -> h;
}