--TEST--
Request #20036: Enable default values to be set by node, edge, or graph.
--FILE--
<?php

/**
 * Request 20036: "Enable default values to be set by node, edge, or graph."
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Aaron McClimont <mcclimont@internode.on.net>
 * @link     http://pear.php.net/bugs/bug.php?id=20036
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, array(), 'GraphVis');

$graph->addAttributes(array(
  'graph' => array('fontname' => 'Helvetica-Oblique', 'fontsize' => 24, 'label' => 'GraphVis')
  , 'node' => array('color' => 'white', 'fontname' => 'Helvetica')
  , 'edge' => array('color' => 'red')));
  
echo $graph->parse();
?>
--EXPECT--
strict digraph GraphVis {
    graph [
        fontname="Helvetica-Oblique";
        fontsize=24;
        label=GraphVis;
    ];
    node [
        color=white;
        fontname=Helvetica;
    ];
    edge [
        color=red;
    ];
}