--TEST--
Unit test for undirected graph
--FILE--
<?php

/**
 * Test 1: "Process States in an Operating System Kernel"
 *
 * Graph definition taken from GraphViz documentation
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 * @version  $Id$
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(false, null, 'G', false);

$graph->addEdge(array('run' => 'intr'));
$graph->addEdge(array('intr' => 'runbl'));
$graph->addEdge(array('runbl' => 'run'));
$graph->addEdge(array('run' => 'kernel'));
$graph->addEdge(array('kernel' => 'zombie'));
$graph->addEdge(array('kernel' => 'sleep'));
$graph->addEdge(array('kernel' => 'runmem'));
$graph->addEdge(array('sleep' => 'swap'));
$graph->addEdge(array('swap' => 'runswap'));
$graph->addEdge(array('runswap' => 'new'));
$graph->addEdge(array('runswap' => 'runmem'));
$graph->addEdge(array('new' => 'runmem'));
$graph->addEdge(array('sleep' => 'runmem'));

echo $graph->parse();

?>
--EXPECT--
graph G {
    run -- intr;
    run -- kernel;
    intr -- runbl;
    runbl -- run;
    kernel -- zombie;
    kernel -- sleep;
    kernel -- runmem;
    sleep -- swap;
    sleep -- runmem;
    swap -- runswap;
    runswap -- new;
    runswap -- runmem;
    new -- runmem;
}