--TEST--
Unit test for Graph with polygonal shapes
--FILE--
<?php

/**
 * Test 5: "Graph with polygonal shapes"
 *
 * Graph definition taken from GraphViz documentation
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, null, 'G', false);

$graph->addNode('a', array('shape' => 'polygon',
                           'sides' => 5,
                           'peripheries' => 3,
                           'color' => 'lightblue',
                           'style' => 'filled'));
$graph->addNode('c', array('shape' => 'polygon',
                           'sides' => 4,
                           'skew' => .4,
                           'label' => 'hello world'));
$graph->addNode('d', array('shape' => 'invtriangle'));
$graph->addNode('e', array('shape' => 'polygon',
                           'sides' => 4,
                           'distortion' => .7));

$graph->addEdge(array('a' => 'b'));
$graph->addEdge(array('b' => 'c'));
$graph->addEdge(array('b' => 'd'));

echo $graph->parse();

?>
--EXPECT--
digraph G {
    a [ shape=polygon,sides=5,peripheries=3,color=lightblue,style=filled ];
    c [ shape=polygon,sides=4,skew=0.4,label="hello world" ];
    d [ shape=invtriangle ];
    e [ shape=polygon,sides=4,distortion=0.7 ];
    a -> b;
    b -> c;
    b -> d;
}