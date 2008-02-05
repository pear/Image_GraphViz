--TEST--
Request #12913: PEAR_Error on failure
--FILE--
<?php

/**
 * Request 12913: "PEAR_Error on failure"
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 * @link     http://pear.php.net/bugs/bug.php?id=12913
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, array(), 'G', true, true);

$graph->addNode('Node1', array('label' => 'Node1'), 'cluster_1');

$result = $graph->image('unavailable_format');
if (PEAR::isError($result)) {
    echo "PEAR_Error\n";
}

$graph = new Image_GraphViz(true, array(), 'G', true, false);

$graph->addNode('Node1', array('label' => 'Node1'), 'cluster_1');

$result = $graph->image('unavailable_format');
if ($result === false) {
    echo "Boolean\n";
}

?>
--EXPECT--
PEAR_Error
Boolean
