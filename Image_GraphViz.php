<?php
//
// +----------------------------------------------------------------------+
// | PHP version 4.0                                                      |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2001 The PHP Group                                |
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

class Image_GraphViz {
    var $dot_command   = '/path/to/dot';
    var $neato_command = '/path/to/neato';

    var $graph;

    function GraphViz($directed = true, $attributes = array()) {
        $this->set_directed($directed);
        $this->set_attributes($attributes);
    }

    function image($format = 'svg') {
        if ($file = $this->save_parsed_graph()) {
            $command  = $this->graph['directed'] ? $this->dot_command : $this->neato_command;
            $command .= " -T$format $file";

            @$image = `$command`;
            @unlink($file);

            header('Content-Type: image/' . $format);
            echo $image;
        }
    }

    function add_node($name, $attributes = array()) {
        $this->graph['nodes'][$name] = $attributes;
    }

    function remove_node($name) {
        if (isset($this->graph['nodes'][$name])) {
            unset($this->graph['nodes'][$name]);
        }
    }

    function add_edge($edge, $attributes = array()) {
        if (is_array($edge)) {
            $from = key($edge);
            $to   = $edge[$from];
            $id   = $from . '_' . $to;

            if (!isset($this->graph['edges'][$id])) {
                $this->graph['edges'][$id] = $edge;
            } else {
                $this->graph['edges'][$id] = array_merge($this->graph['edges'][$id], $edge);
            }

            if (is_array($attributes)) {
                if (!isset($this->graph['edge_attributes'][$id])) {
                    $this->graph['edge_attributes'][$id] = $attributes;
                } else {
                    $this->graph['edge_attributes'][$id] = array_merge($this->graph['edge_attributes'][$id], $attributes);
                }
            }
        }
    }

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

    function add_attributes($attributes) {
        if (is_array($attributes)) {
            $this->graph['attributes'] = array_merge($this->graph['attributes'], $attributes);
        }
    }

    function set_attributes($attributes) {
        if (is_array($attributes)) {
            $this->graph['attributes'] = $attributes;
        }
    }

    function set_directed($directed) {
        if (is_bool($directed)) {
            $this->graph['directed'] = $directed;
        }
    }

    function load($file) {
        if ($serialized_graph = implode('', @file($file))) {
            $this->graph = unserialize($serialized_graph);
        }
    }

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

    function parse() {
        $parsed_graph = 'digraph G { ';

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
                  $parsed_graph .= $node . ' [ ' . implode(',', $attribute_list) . ' ]; ';
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

                if (!empty($attribute_list)) {
                  $parsed_graph .= $from . ' -> ' . $to . ' [ ' . implode(',', $attribute_list) . ' ];';
                }
            }
        }

        $parsed_graph .= ' }';

        return $parsed_graph;
    }

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
