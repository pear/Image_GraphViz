<?php
//
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Sebastian Bergmann <sb@sebastian-bergmann.de>               |
// |          Dr. Volker Göbbels <vmg@arachnion.de>                       |
// +----------------------------------------------------------------------+
//
// $Id$
//

/**
* PEAR::Image_GraphViz
*
* Purpose
*
*     Allows for the creation of and the work with directed
*     and undirected graphs and their visualization with
*     AT&T's GraphViz tools. These can be found at
*     http://www.research.att.com/sw/tools/graphviz/
*
* Example
*
*     require_once 'Image/GraphViz.php';
*     $graph = new Image_GraphViz();
*
*     $graph->add_node('Node1', array('URL'      => 'http://link1',
*                                     'label'    => 'This is a label',
*                                     'shape'    => 'box'
*                                    )
*                     );
*     $graph->add_node('Node2', array('URL'      => 'http://link2',
*                                     'fontsize' => '14'
*                                    )
*                     );
*     $graph->add_node('Node3', array('URL'      => 'http://link3',
*                                     'fontsize' => '20'
*                                    )
*                     );
*
*     $graph->add_edge(array('Node1' => 'Node2'), array('label' => 'Edge Label'));
*     $graph->add_edge(array('Node1' => 'Node2'), array('color' => 'red'));
*
*     $graph->image();
*
* @author  Sebastian Bergmann <sb@sebastian-bergmann.de>
*          Dr. Volker Göbbels <vmg@arachnion.de>
* @package Image
*/
class Image_GraphViz {
    /**
    * Path to GraphViz/dot command
    *
    * @var  string
    */
    var $dot_command   = '/path/to/dot';

    /**
    * Path to GraphViz/neato command
    *
    * @var  string
    */
    var $neato_command = '/path/to/neato';

    /**
    * Representation of the graph
    *
    * @var  array
    */
    var $graph;

    /**
    * Constructor
    *
    * @param  boolean Directed (true) or undirected (false) graph.
    * @param  array   Attributes of the graph
    * @access public
    */
    function Image_GraphViz($directed = true, $attributes = array()) {
        $this->set_directed($directed);
        $this->set_attributes($attributes);
    }

    /**
    * Output image of the graph in a given format.
    *
    * @param  string  Format of the output image.
    *                 This may be one of the formats supported by GraphViz.
    * @access public
    */

    function image($format = 'svg') {
        if ($file = $this->save_parsed_graph()) {
            $outputfile = $file . '.' . $format;
            $command  = $this->graph['directed'] ? $this->dot_command : $this->neato_command;
            $command .= " -T$format -o$outputfile $file";

            @$image = @`$command`;
            @unlink($file);

            header('Content-Type: image/' . $format);
            header('Content-Length: ' . filesize($outputfile));

            $fp = fopen($outputfile, 'rb');

            if ($fp) {
                echo fread($fp, filesize($outputfile));
                fclose($fp);
                @unlink($outputfile);
            }
        }
    }

    /**
    * Add a note to the graph.
    *
    * @param  string  Name of the node.
    * @param  array   Attributes of the node.
    * @access public
    */
    function add_node($name, $attributes = array()) {
        $this->graph['nodes'][$name] = $attributes;
    }

    /**
    * Remove a node from the graph.
    *
    * @param  Name of the node to be removed.
    * @access public
    */
    function remove_node($name) {
        if (isset($this->graph['nodes'][$name])) {
            unset($this->graph['nodes'][$name]);
        }
    }

    /**
    * Add an edge to the graph.
    *
    * @param  array Start and End node of the edge.
    * @param  array Attributes of the edge.
    * @access public
    */
    function add_edge($edge, $attributes = array()) {
        if (is_array($edge)) {
            $from = key($edge);
            $to   = $edge[$from];
            $id   = $from . '_' . $to;

            if (!isset($this->graph['edges'][$id])) {
                $this->graph['edges'][$id] = $edge;
            } else {
                $this->graph['edges'][$id] = array_merge(
                  $this->graph['edges'][$id],
                  $edge
                );
            }

            if (is_array($attributes)) {
                if (!isset($this->graph['edge_attributes'][$id])) {
                    $this->graph['edge_attributes'][$id] = $attributes;
                } else {
                    $this->graph['edge_attributes'][$id] = array_merge(
                      $this->graph['edge_attributes'][$id],
                      $attributes
                    );
                }
            }
        }
    }

    /**
    * Remove an edge from the graph.
    *
    * @param  array Start and End node of the edge to be removed.
    * @access public
    */
    function remove_edge($edge) {
        if (is_array($edge)) {
              $from = key($edge);
              $to   = $edge[$from];
              $id   = $from . '_' . $to;

            if (isset($this->graph['edges'][$id])) {
                unset($this->graph['edges'][$id]);
            }

            if (isset($this->graph['edge_attributes'][$id])) {
                unset($this->graph['edge_attributes'][$id]);
            }
        }
    }

    /**
    * Add attributes to the graph.
    *
    * @param  array Attributes to be added to the graph.
    * @access public
    */
    function add_attributes($attributes) {
        if (is_array($attributes)) {
            $this->graph['attributes'] = array_merge(
              $this->graph['attributes'],
              $attributes
            );
        }
    }

    /**
    * Set attributes of the graph.
    *
    * @param  array Attributes to be set for the graph.
    * @access public
    */
    function set_attributes($attributes) {
        if (is_array($attributes)) {
            $this->graph['attributes'] = $attributes;
        }
    }

    /**
    * Set directed/undirected flag for the graph.
    *
    * @param  boolean Directed (true) or undirected (false) graph.
    * @access public
    */
    function set_directed($directed) {
        if (is_bool($directed)) {
            $this->graph['directed'] = $directed;
        }
    }

    /**
    * Load graph from file.
    *
    * @param  string  File to load graph from.
    * @access public
    */
    function load($file) {
        if ($serialized_graph = implode('', @file($file))) {
            $this->graph = unserialize($serialized_graph);
        }
    }

    /**
    * Save graph to file.
    *
    * @param  string  File to save the graph to.
    * @return mixed   File the graph was saved to, false on failure.
    * @access public
    */
    function save($file = '') {
        $serialized_graph = serialize($this->graph);

        if (empty($file)) {
            $file = tempnam('/tmp', 'graph_');
        }

        if ($fp = @fopen($file, 'w')) {
            @fputs($fp, $serialized_graph);
            @fclose($fp);

            return $file;
        }

        return false;
    }

    /**
    * Parse the graph into GraphViz markup.
    *
    * @return string  GraphViz markup
    * @access public
    */
    function parse() {
        $parsed_graph = "digraph G { \n";

        if (isset($this->graph['attributes'])) {
            foreach ($this->graph['attributes'] as $key => $value) {
                $attribute_list[] = $key . '="' . $value . '"';
            }

            if (!empty($attribute_list)) {
              $parsed_graph .= implode(',', $attribute_list) . '; ';
            }
        }

        if (isset($this->graph['nodes'])) {
            foreach($this->graph['nodes'] as $node => $attributes) {
                unset($attribute_list);

                foreach($attributes as $key => $value) {
                    $attribute_list[] = $key . '="' . $value . '"';
                }

                if (!empty($attribute_list)) {
                    $parsed_graph .= sprintf(
                      "\"%s\" [ %s ];\n",
                      addslashes(stripslashes($node)),
                      implode(',', $attribute_list)
                    );
                }
            }
        }

        if (isset($this->graph['edges'])) {
            foreach($this->graph['edges'] as $label => $node) {
                unset($attribute_list);

                $from = key($node);
                $to   = $node[$from];

                foreach($this->graph['edge_attributes'][$label] as $key => $value) {
                    $attribute_list[] = $key . '="' . $value . '"';
                }

                $parsed_graph .= sprintf(
                  '"%s" -> "%s"',
                  addslashes(stripslashes($from)),
                  addslashes(stripslashes($to))
                );
                
                if (!empty($attribute_list)) {
                    $parsed_graph .= sprintf(
                      ' [ %s ]',
                      implode(',', $attribute_list)
                    );
                }

                $parsed_graph .= ';';
            }
        }

        return $parsed_graph . ' }';
    }

    /**
    * Save GraphViz markup to file.
    *
    * @param  string  File to write the GraphViz markup to.
    * @return mixed   File to which the GraphViz markup was
    *                 written, false on failure.
    * @access public
    */
    function save_parsed_graph($file = '') {
        $parsed_graph = $this->parse();

        if (!empty($parsed_graph)) {
            if (empty($file)) {
                $file = tempnam('/tmp', 'graph_');
            }

            if ($fp = @fopen($file, 'w')) {
                @fputs($fp, $parsed_graph);
                @fclose($fp);

                return $file;
            }
        }

        return false;
    }
}
?>
