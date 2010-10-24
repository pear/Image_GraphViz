--TEST--
Unit test for call graph with labeled clusters
--FILE--
<?php

/**
 * Test 17: "Call graph with labeled clusters"
 *
 * Graph definition taken from GraphViz documentation
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, array('size' => 8.6, 'ratio' => 'fill'),
                            'G', false);

$graph->addCluster('cluster_error.h', 'error.h');
$graph->addNode('interp_err', null, 'cluster_error.h');

$graph->addCluster('cluster_sfio.h', 'sfio.h');
$graph->addNode('sfprintf', null, 'cluster_sfio.h');

$graph->addCluster('cluster_ciafan.c', 'ciafan.c');
$graph->addNode('ciafan', null, 'cluster_ciafan.c');
$graph->addNode('computefan', null, 'cluster_ciafan.c');
$graph->addNode('increment', null, 'cluster_ciafan.c');

$graph->addCluster('cluster_util.c', 'util.c');
$graph->addNode('stringdup', null, 'cluster_util.c');
$graph->addNode('fatal', null, 'cluster_util.c');
$graph->addNode('debug', null, 'cluster_util.c');

$graph->addCluster('cluster_query.h', 'query.h');
$graph->addNode('ref', null, 'cluster_query.h');
$graph->addNode('def', null, 'cluster_query.h');

$graph->addCluster('cluster_field.h', '');
$graph->addNode('get_sym_fields', null, 'cluster_field.h');

$graph->addCluster('cluster_stdio.h', 'stdio.h');
$graph->addNode('stdprintf', null, 'cluster_stdio.h');
$graph->addNode('stdsprintf', null, 'cluster_stdio.h');

$graph->addCluster('cluster_<libc.a>', '');
$graph->addNode('getopt', null, 'cluster_<libc.a>');

$graph->addCluster('cluster_stdlib.h', 'stdlib.h');
$graph->addNode('exit', null, 'cluster_stdlib.h');
$graph->addNode('malloc', null, 'cluster_stdlib.h');
$graph->addNode('free', null, 'cluster_stdlib.h');
$graph->addNode('realloc', null, 'cluster_stdlib.h');

$graph->addCluster('cluster_main.c', '');
$graph->addNode('main', null, 'cluster_main.c');

$graph->addCluster('cluster_index.h', '');
$graph->addNode('init_index', null, 'cluster_index.h');

$graph->addCluster('cluster_string.h', 'string.h');
$graph->addNode('strcpy', null, 'cluster_string.h');
$graph->addNode('strlen', null, 'cluster_string.h');
$graph->addNode('strcmp', null, 'cluster_string.h');
$graph->addNode('strcat', null, 'cluster_string.h');

$graph->addEdge(array('ciafan' => 'computefan'));
$graph->addEdge(array('fan' => 'increment'));
$graph->addEdge(array('computefan' => 'fan'));
$graph->addEdge(array('stringdup' => 'fatal'));
$graph->addEdge(array('main' => 'exit'));
$graph->addEdge(array('main' => 'interp_err'));
$graph->addEdge(array('main' => 'ciafan'));
$graph->addEdge(array('main' => 'fatal'));
$graph->addEdge(array('main' => 'malloc'));
$graph->addEdge(array('main' => 'strcpy'));
$graph->addEdge(array('main' => 'getopt'));
$graph->addEdge(array('main' => 'init_index'));
$graph->addEdge(array('main' => 'strlen'));
$graph->addEdge(array('fan' => 'fatal'));
$graph->addEdge(array('fan' => 'ref'));
$graph->addEdge(array('fan' => 'interp_err'));
$graph->addEdge(array('ciafan' => 'def'));
$graph->addEdge(array('fan' => 'free'));
$graph->addEdge(array('computefan' => 'stdprintf'));
$graph->addEdge(array('computefan' => 'get_sym_fields'));
$graph->addEdge(array('fan' => 'exit'));
$graph->addEdge(array('fan' => 'malloc'));
$graph->addEdge(array('increment' => 'strcmp'));
$graph->addEdge(array('computefan' => 'malloc'));
$graph->addEdge(array('fan' => 'stdsprintf'));
$graph->addEdge(array('fan' => 'strlen'));
$graph->addEdge(array('computefan' => 'strcmp'));
$graph->addEdge(array('computefan' => 'realloc'));
$graph->addEdge(array('computefan' => 'strlen'));
$graph->addEdge(array('debug' => 'sfprintf'));
$graph->addEdge(array('debug' => 'strcat'));
$graph->addEdge(array('stringdup' => 'malloc'));
$graph->addEdge(array('fatal' => 'sfprintf'));
$graph->addEdge(array('stringdup' => 'strcpy'));
$graph->addEdge(array('stringdup' => 'strlen'));
$graph->addEdge(array('fatal' => 'exit'));

echo $graph->parse();

?>
--EXPECT--
digraph G {
    size=8.6;
    ratio=fill;
    subgraph "cluster_error.h" {
        graph [ label="error.h" ];
        interp_err;
    }
    subgraph "cluster_sfio.h" {
        graph [ label="sfio.h" ];
        sfprintf;
    }
    subgraph "cluster_ciafan.c" {
        graph [ label="ciafan.c" ];
        ciafan;
        computefan;
        increment;
    }
    subgraph "cluster_util.c" {
        graph [ label="util.c" ];
        stringdup;
        fatal;
        debug;
    }
    subgraph "cluster_query.h" {
        graph [ label="query.h" ];
        ref;
        def;
    }
    subgraph "cluster_field.h" {
        get_sym_fields;
    }
    subgraph "cluster_stdio.h" {
        graph [ label="stdio.h" ];
        stdprintf;
        stdsprintf;
    }
    subgraph "cluster_<libc.a>" {
        getopt;
    }
    subgraph "cluster_stdlib.h" {
        graph [ label="stdlib.h" ];
        exit;
        malloc;
        free;
        realloc;
    }
    subgraph "cluster_main.c" {
        main;
    }
    subgraph "cluster_index.h" {
        init_index;
    }
    subgraph "cluster_string.h" {
        graph [ label="string.h" ];
        strcpy;
        strlen;
        strcmp;
        strcat;
    }
    ciafan -> computefan;
    ciafan -> def;
    fan -> increment;
    fan -> fatal;
    fan -> ref;
    fan -> interp_err;
    fan -> free;
    fan -> exit;
    fan -> malloc;
    fan -> stdsprintf;
    fan -> strlen;
    computefan -> fan;
    computefan -> stdprintf;
    computefan -> get_sym_fields;
    computefan -> malloc;
    computefan -> strcmp;
    computefan -> realloc;
    computefan -> strlen;
    stringdup -> fatal;
    stringdup -> malloc;
    stringdup -> strcpy;
    stringdup -> strlen;
    main -> exit;
    main -> interp_err;
    main -> ciafan;
    main -> fatal;
    main -> malloc;
    main -> strcpy;
    main -> getopt;
    main -> init_index;
    main -> strlen;
    increment -> strcmp;
    debug -> sfprintf;
    debug -> strcat;
    fatal -> sfprintf;
    fatal -> exit;
}