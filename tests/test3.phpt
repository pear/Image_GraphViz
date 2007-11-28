--TEST--
Unit test for fancy graph (comment, colors, shapes)
--FILE--
<?php

/**
 * Test 3: "Fancy graph"
 *
 * Graph definition taken from GraphViz documentation
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, null, 'G', false);

$graph->addNode('main', array('shape' => 'box',
                              'comment' => 'this is a comment'));

$graph->addEdge(array('main' => 'parse'), array('weight' => 8));

$graph->addEdge(array('parse' => 'execute'));
$graph->addEdge(array('main' => 'init'), array('style' => 'dotted'));
$graph->addEdge(array('main' => 'cleanup'));
$graph->addEdge(array('execute' => 'make_string'));
$graph->addEdge(array('execute' => 'printf'));
$graph->addEdge(array('init' => 'make_string'));

$graph->addEdge(array('main' => 'printf'), array('style' => 'bold',
                                                 'label' => '100 times'));
$graph->addNode('make_string', array('label' => "make a\nstring"));
$graph->addNode('compare', array('shape' => 'box',
                                 'style' => 'filled',
                                 'color' => '.7 .3 1.0'));
$graph->addEdge(array('execute' => 'compare'), array('color' => 'red',
                                                     'comment' => 'so is this'));

echo $graph->parse();

?>
--EXPECT--
digraph G {
    main [ shape=box,comment="this is a comment" ];
    make_string [ label="make a\nstring" ];
    compare [ shape=box,style=filled,color=".7 .3 1.0" ];
    main -> parse [ weight=8 ];
    main -> init [ style=dotted ];
    main -> cleanup;
    main -> printf [ style=bold,label="100 times" ];
    parse -> execute;
    execute -> make_string;
    execute -> printf;
    execute -> compare [ color=red,comment="so is this" ];
    init -> make_string;
}