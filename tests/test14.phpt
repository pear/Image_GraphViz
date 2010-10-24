--TEST--
Unit test for graphs with ports
--FILE--
<?php

/**
 * Test 14: "Drawing of records (revisited)"
 *
 * Graph definition taken from GraphViz documentation
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, array(), 'structs', false);

$graph->addNode('struct1', array('shape' => 'record',
                                 'label' => '<f0> left|<f1> middle|<f2> right'));
$graph->addNode('struct2', array('shape' => 'record',
                                 'label' => '<f0> one|<f1> two'));
$graph->addNode('struct3', array('shape' => 'record',
                                 'label' => "hello\nworld | { b |{c|<here> d|e}| f}| g | h"));
$graph->addEdge(array('struct1' => 'struct2'), array(),
                array('struct1' => 'f1', 'struct2' => 'f0'));
$graph->addEdge(array('struct1' => 'struct3'), array(),
                array('struct1' => 'f1', 'struct3' => 'here'));

echo $graph->parse();

?>
--EXPECT--
digraph structs {
    struct1 [ shape=record,label="<f0> left|<f1> middle|<f2> right" ];
    struct2 [ shape=record,label="<f0> one|<f1> two" ];
    struct3 [ shape=record,label="hello\nworld | { b |{c|<here> d|e}| f}| g | h" ];
    struct1:f1 -> struct2:f0;
    struct1:f1 -> struct3:here;
}