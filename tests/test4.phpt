--TEST--
Unit test for HTML-like labels
--FILE--
<?php

/**
 * Test 4: "HTML-like labels"
 *
 * Graph definition taken from GraphViz documentation
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, array('rankdir' => 'LR'), 'G', false);

$graph->addNode('a', array('shape' => 'plaintext',
                           'label' => '<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0">
  <TR><TD ROWSPAN="3" BGCOLOR="yellow">class</TD></TR>
  <TR><TD PORT="here" BGCOLOR="lightblue">qualifier</TD></TR>
</TABLE>'));

$graph->addNode('b', array('shape' => 'ellipse',
                           'style' => 'filled',
                           'label' => '<TABLE BGCOLOR="bisque">
  <TR><TD COLSPAN="3">elephant</TD>
      <TD ROWSPAN="2" BGCOLOR="chartreuse"
          VALIGN="bottom" ALIGN="right">two</TD> </TR>
  <TR><TD COLSPAN="2" ROWSPAN="2">
        <TABLE BGCOLOR="grey">
          <TR> <TD>corn</TD> </TR>
          <TR> <TD BGCOLOR="yellow">c</TD> </TR>
          <TR> <TD>f</TD> </TR>
        </TABLE> </TD>
      <TD BGCOLOR="white">penguin</TD>
  </TR>
  <TR> <TD COLSPAN="2" BORDER="4" ALIGN="right" PORT="there">4</TD> </TR>
</TABLE>
  '), 'subgraph');

$graph->addNode('c', array('shape' => 'plaintext',
                           'label' => 'long line 1<BR/>line 2<BR ALIGN="LEFT"/>line 3<BR ALIGN="RIGHT"/>'), 'subgraph');

$graph->addSubgraph('subgraph', '', array('rank' => 'same'));

$graph->addEdge(array('c' => 'b'));

$graph->addNode('d', array('shape' => 'triangle'));

$graph->addEdge(array('d' => 'c'), array('label' => '<TABLE>
  <TR><TD BGCOLOR="red" WIDTH="10"> </TD>
      <TD>Edge labels<BR/>also</TD>
      <TD BGCOLOR="blue" WIDTH="10"> </TD>
  </TR>
</TABLE>'));

$graph->addEdge(array('a' => 'b'), array('arrowtail' => 'diamond'),
                array('a' => 'here', 'b' => 'there'));

echo $graph->parse();

?>
--EXPECT--
digraph G {
    rankdir=LR;
    a [ shape=plaintext,label=<<TABLE BORDER="0" CELLBORDER="1" CELLSPACING="0">
  <TR><TD ROWSPAN="3" BGCOLOR="yellow">class</TD></TR>
  <TR><TD PORT="here" BGCOLOR="lightblue">qualifier</TD></TR>
</TABLE>> ];
    d [ shape=triangle ];
    subgraph "subgraph" {
        graph [ rank=same ];
        b [ shape=ellipse,style=filled,label=<<TABLE BGCOLOR="bisque">
  <TR><TD COLSPAN="3">elephant</TD>
      <TD ROWSPAN="2" BGCOLOR="chartreuse"
          VALIGN="bottom" ALIGN="right">two</TD> </TR>
  <TR><TD COLSPAN="2" ROWSPAN="2">
        <TABLE BGCOLOR="grey">
          <TR> <TD>corn</TD> </TR>
          <TR> <TD BGCOLOR="yellow">c</TD> </TR>
          <TR> <TD>f</TD> </TR>
        </TABLE> </TD>
      <TD BGCOLOR="white">penguin</TD>
  </TR>
  <TR> <TD COLSPAN="2" BORDER="4" ALIGN="right" PORT="there">4</TD> </TR>
</TABLE>
  > ];
        c [ shape=plaintext,label=<long line 1<BR/>line 2<BR ALIGN="LEFT"/>line 3<BR ALIGN="RIGHT"/>> ];
    }
    c -> b;
    d -> c [ label=<<TABLE>
  <TR><TD BGCOLOR="red" WIDTH="10"> </TD>
      <TD>Edge labels<BR/>also</TD>
      <TD BGCOLOR="blue" WIDTH="10"> </TD>
  </TR>
</TABLE>> ];
    a:here -> b:there [ arrowtail=diamond ];
}