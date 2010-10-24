--TEST--
Unit test for nodes, subgraphs and clusters using keyword as name
--FILE--
<?php

/**
 * Test 5: Keywords
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, null, 'strict', true);

$graph->addNode('graph');

$graph->addSubgraph('subgraph', '');
$graph->addSubgraph('digraph', '');

$graph->addNode('node', null, 'subgraph');
$graph->addNode('edge', null, 'digraph');

$graph->addEdge(array('node' => 'edge'));

echo $graph->parse();

?>
--EXPECT--
strict digraph "strict" {
    "graph";
    subgraph "subgraph" {
        "node";
    }
    subgraph "digraph" {
        "edge";
    }
    "node" -> "edge";
}