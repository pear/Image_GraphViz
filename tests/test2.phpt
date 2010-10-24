--TEST--
Unit test for HTML-like labels and ports
--FILE--
<?php

/**
 * Test 2: "HTML-like labels"
 *
 * Graph definition taken from GraphViz documentation
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 * @version  $Id$
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, null, 'structs', false);

$graph->addNode('struct1', array(
    'shape' => 'plaintext',
    'label' => '<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0">
   <TR><TD>left</TD><TD PORT="f1">mid dle</TD><TD PORT="f2">right</TD></TR>
</TABLE>'));

$graph->addNode('struct2', array(
    'shape' => 'plaintext',
    'label' => '<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0">
   <TR><TD PORT="f0">one</TD><TD>two</TD></TR>
</TABLE>'));

$graph->addNode('struct3', array(
    'shape' => 'plaintext',
    'label' => '<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0" CELLPADDING="4">
   <TR>
      <TD ROWSPAN="3">hello<BR/>world</TD>
      <TD COLSPAN="3">b</TD>
      <TD ROWSPAN="3">g</TD>
      <TD ROWSPAN="3">h</TD>
   </TR>
   <TR>
      <TD>c</TD><TD PORT="here">d</TD><TD>e</TD>
   </TR>
   <TR>
      <TD COLSPAN="3">f</TD>
   </TR>
</TABLE>'));

$graph->addEdge(array('struct1' => 'struct2'), null, array('struct1' => 'f1',
                                                           'struct2' => 'f0'));

$graph->addEdge(array('struct1' => 'struct3'), null, array('struct1' => 'f2',
                                                           'struct3' => 'here'));
echo $graph->parse();

?>
--EXPECT--
digraph structs {
    struct1 [ shape=plaintext,label=<<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0">
   <TR><TD>left</TD><TD PORT="f1">mid dle</TD><TD PORT="f2">right</TD></TR>
</TABLE>> ];
    struct2 [ shape=plaintext,label=<<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0">
   <TR><TD PORT="f0">one</TD><TD>two</TD></TR>
</TABLE>> ];
    struct3 [ shape=plaintext,label=<<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0" CELLPADDING="4">
   <TR>
      <TD ROWSPAN="3">hello<BR/>world</TD>
      <TD COLSPAN="3">b</TD>
      <TD ROWSPAN="3">g</TD>
      <TD ROWSPAN="3">h</TD>
   </TR>
   <TR>
      <TD>c</TD><TD PORT="here">d</TD><TD>e</TD>
   </TR>
   <TR>
      <TD COLSPAN="3">f</TD>
   </TR>
</TABLE>> ];
    struct1:f1 -> struct2:f0;
    struct1:f2 -> struct3:here;
}