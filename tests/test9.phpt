--TEST--
Unit test for graph with constrained rank clusters
--FILE--
<?php

/**
 * Test 9: "Graph with constrained ranks"
 *
 * Graph definition taken from GraphViz documentation
 *
 * @category Image
 * @package  Image_GraphViz
 * @author   Philippe Jausions <jausions@php.net>
 */
require_once 'Image/GraphViz.php';

$graph = new Image_GraphViz(true, array('ranksep' => .75),
                            'asde91', false);

/* the time-line graph */
$graph->addEdge(array('past' => 1978));
$graph->addEdge(array(1978 => 1980));
$graph->addEdge(array(1980 => 1982));
$graph->addEdge(array(1982 => 1983));
$graph->addEdge(array(1983 => 1985));
$graph->addEdge(array(1985 => 1986));
$graph->addEdge(array(1986 => 1987));
$graph->addEdge(array(1987 => 1988));
$graph->addEdge(array(1988 => 1989));
$graph->addEdge(array(1989 => 1990));
$graph->addEdge(array(1990 => 'future'));

/* program types graph */
$graph->addSubgraph('type', '', array('rank' => 'same'));

$graph->addNode('Software IS', null, 'type');
$graph->addNode('Configuration Mgt', null, 'type');
$graph->addNode('Architecture & Libraries', null, 'type');
$graph->addNode('Process', null, 'type');

/* time graphs */
$graph->addSubgraph('past', '', array('rank' => 'same'));
$graph->addSubgraph(1978, '', array('rank' => 'same'));
$graph->addSubgraph(1980, '', array('rank' => 'same'));
$graph->addSubgraph(1982, '', array('rank' => 'same'));
$graph->addSubgraph(1983, '', array('rank' => 'same'));
$graph->addSubgraph(1985, '', array('rank' => 'same'));
$graph->addSubgraph(1986, '', array('rank' => 'same'));
$graph->addSubgraph(1987, '', array('rank' => 'same'));
$graph->addSubgraph(1988, '', array('rank' => 'same'));
$graph->addSubgraph(1989, '', array('rank' => 'same'));
$graph->addSubgraph(1990, '', array('rank' => 'same'));
$graph->addSubgraph('future', '', array('rank' => 'same'));

/* programs */
$graph->addNode('Bourne sh', null, 'past');
$graph->addNode('make', null, 'past');
$graph->addNode('SCCS', null, 'past');
$graph->addNode('yacc', null, 'past');
$graph->addNode('cron', null, 'past');

$graph->addNode('Reiser cpp', null, 1978);
$graph->addNode('Cshell', null, 1978);

$graph->addNode('emacs', null, 1980);
$graph->addNode('build', null, 1980);
$graph->addNode('vi', null, 1980);

$graph->addNode('<curses>', null, 1982);
$graph->addNode('RCS', null, 1982);
$graph->addNode('IMX', null, 1982);
$graph->addNode('SYNED', null, 1982);

$graph->addNode('ksh', null, 1983);
$graph->addNode('IFS', null, 1983);
$graph->addNode('TTU', null, 1983);

$graph->addNode('nmake', null, 1985);
$graph->addNode('Peggy', null, 1985);

$graph->addNode('ncpp', null, 1986);
$graph->addNode('ksh-i', null, 1986);
$graph->addNode('<curses-i>', null, 1986);
$graph->addNode('PG2', null, 1986);
$graph->addNode('C*', null, 1986);

$graph->addNode('Ansi cpp', null, 1987);
$graph->addNode('nmake 2.0', null, 1987);
$graph->addNode('3D File System', null, 1987);
$graph->addNode('fdelta', null, 1987);
$graph->addNode('DAG', null, 1987);
$graph->addNode('CSAS', null, 1987);

$graph->addNode('CIA', null, 1988);
$graph->addNode('SBCS', null, 1988);
$graph->addNode('ksh-88', null, 1988);
$graph->addNode('PEGASUS/PML', null, 1988);
$graph->addNode('PAX', null, 1988);
$graph->addNode('backtalk', null, 1988);

$graph->addNode('CIA++', null, 1989);
$graph->addNode('APP', null, 1989);
$graph->addNode('SHIP', null, 1989);
$graph->addNode('DataShare', null, 1989);
$graph->addNode('ryacc', null, 1989);
$graph->addNode('Mosaic', null, 1989);

$graph->addNode('libft', null, 1990);
$graph->addNode('CoShell', null, 1990);
$graph->addNode('DIA', null, 1990);
$graph->addNode('IFS-i', null, 1990);
$graph->addNode('kyacc', null, 1990);
$graph->addNode('sfio', null, 1990);
$graph->addNode('yeast', null, 1990);
$graph->addNode('ML-X', null, 1990);
$graph->addNode('DOT', null, 1990);

$graph->addNode('Adv. Software Technology', null, 'future');

/* hierachy */
$graph->addEdge(array('SCCS' => 'RCS'));
$graph->addEdge(array('SCCS' => '3D File System'));
$graph->addEdge(array('SCCS' => 'nmake'));
$graph->addEdge(array('make' => 'nmake'));
$graph->addEdge(array('make' => 'build'));
$graph->addEdge(array('Bourne sh' => 'Cshell'));
$graph->addEdge(array('Bourne sh' => 'ksh'));
$graph->addEdge(array('yacc' => 'ryacc'));
$graph->addEdge(array('cron' => 'yeast'));

$graph->addEdge(array('Reiser cpp' => 'ncpp'));
$graph->addEdge(array('Cshell' => 'ksh'));

$graph->addEdge(array('build' => 'nmake 2.0'));
$graph->addEdge(array('vi' => 'ksh'));
$graph->addEdge(array('vi' => '<curses>'));
$graph->addEdge(array('emacs' => 'ksh'));

$graph->addEdge(array('RCS' => 'SBCS'));
$graph->addEdge(array('RCS' => 'fdelta'));
$graph->addEdge(array('<curses>' => '<curses-i>'));
$graph->addEdge(array('SYNED' => 'Peggy'));
$graph->addEdge(array('IMX' => 'TTU'));

$graph->addEdge(array('ksh' => 'nmake'));
$graph->addEdge(array('ksh' => 'ksh-i'));
$graph->addEdge(array('ksh' => 'ksh-88'));
$graph->addEdge(array('IFS' => '<curses-i>'));
$graph->addEdge(array('IFS' => 'sfio'));
$graph->addEdge(array('IFS' => 'IFS-i'));
$graph->addEdge(array('TTU' => 'PG2'));

$graph->addEdge(array('nmake' => 'ksh'));
$graph->addEdge(array('nmake' => 'ncpp'));
$graph->addEdge(array('nmake' => '3D File System'));
$graph->addEdge(array('nmake' => 'nmake 2.0'));
$graph->addEdge(array('Peggy' => 'PEGASUS/PML'));
$graph->addEdge(array('Peggy' => 'ryacc'));

$graph->addEdge(array('C*' => 'CSAS'));
$graph->addEdge(array('ncpp' => 'Ansi cpp'));
$graph->addEdge(array('<curses-i>' => 'fdelta'));
$graph->addEdge(array('ksh-i' => 'ksh-88'));
$graph->addEdge(array('PG2' => 'backtalk'));

$graph->addEdge(array('DAG' => 'Sotware IS'));
$graph->addEdge(array('DAG' => 'DOT'));
$graph->addEdge(array('DAG' => 'DIA'));
$graph->addEdge(array('CSAS' => 'CIA'));
$graph->addEdge(array('Ansi cpp' => 'Configuration Mgt'));
$graph->addEdge(array('fdelta' => 'SBCS'));
$graph->addEdge(array('fdelta' => 'PAX'));
$graph->addEdge(array('3D File System' => 'Configuration Mgt'));
$graph->addEdge(array('nmake 2.0' => 'Configuration Mgt'));
$graph->addEdge(array('nmake 2.0' => 'CoShell'));

$graph->addEdge(array('CIA' => 'CIA++'));
$graph->addEdge(array('CIA' => 'DIA'));
$graph->addEdge(array('SBCS' => 'Configuration Mgt'));
$graph->addEdge(array('PAX' => 'SHIP'));
$graph->addEdge(array('ksh-88' => 'Configuration Mgt'));
$graph->addEdge(array('ksh-88' => 'Architecture & Libraries'));
$graph->addEdge(array('ksh-88' => 'sfio'));
$graph->addEdge(array('PEGASUS/PML' => 'ML-X'));
$graph->addEdge(array('PEGASUS/PML' => 'Architecture & Libraries'));
$graph->addEdge(array('backtalk' => 'DataShare'));

$graph->addEdge(array('CIA++' => 'Software IS'));
$graph->addEdge(array('APP' => 'DIA'));
$graph->addEdge(array('APP' => 'Software IS'));
$graph->addEdge(array('SHIP' => 'Configuration Mgt'));
$graph->addEdge(array('DataShare' => 'Architecture & Libraries'));
$graph->addEdge(array('ryacc' => 'kyacc'));
$graph->addEdge(array('Mosaic' => 'Process'));

$graph->addEdge(array('DOT' => 'Software IS'));
$graph->addEdge(array('DIA' => 'Software IS'));
$graph->addEdge(array('libft' => 'Software IS'));
$graph->addEdge(array('CoShell' => 'Configuration Mgt'));
$graph->addEdge(array('CoShell' => 'Architecture & Libraries'));
$graph->addEdge(array('sfio' => 'Architecture & Libraries'));
$graph->addEdge(array('IFS-i' => 'Architecture & Libraries'));
$graph->addEdge(array('ML-X' => 'Architecture & Libraries'));
$graph->addEdge(array('kyacc' => 'Architecture & Libraries'));
$graph->addEdge(array('yeast' => 'Process'));

$graph->addEdge(array('Architecture & Libraries' => 'Adv. Software Technology'));
$graph->addEdge(array('Software IS' => 'Adv. Software Technology'));
$graph->addEdge(array('Configuration Mgt' => 'Adv. Software Technology'));
$graph->addEdge(array('Process' => 'Adv. Software Technology'));

echo $graph->parse();

?>
--EXPECT--
digraph asde91 {
    ranksep=0.75;
    subgraph type {
        graph [ rank=same ];
        "Software IS";
        "Configuration Mgt";
        "Architecture & Libraries";
        Process;
    }
    subgraph past {
        graph [ rank=same ];
        "Bourne sh";
        make;
        SCCS;
        yacc;
        cron;
    }
    subgraph 1978 {
        graph [ rank=same ];
        "Reiser cpp";
        Cshell;
    }
    subgraph 1980 {
        graph [ rank=same ];
        emacs;
        build;
        vi;
    }
    subgraph 1982 {
        graph [ rank=same ];
        "<curses>";
        RCS;
        IMX;
        SYNED;
    }
    subgraph 1983 {
        graph [ rank=same ];
        ksh;
        IFS;
        TTU;
    }
    subgraph 1985 {
        graph [ rank=same ];
        nmake;
        Peggy;
    }
    subgraph 1986 {
        graph [ rank=same ];
        ncpp;
        "ksh-i";
        "<curses-i>";
        PG2;
        "C*";
    }
    subgraph 1987 {
        graph [ rank=same ];
        "Ansi cpp";
        "nmake 2.0";
        "3D File System";
        fdelta;
        DAG;
        CSAS;
    }
    subgraph 1988 {
        graph [ rank=same ];
        CIA;
        SBCS;
        "ksh-88";
        "PEGASUS/PML";
        PAX;
        backtalk;
    }
    subgraph 1989 {
        graph [ rank=same ];
        "CIA++";
        APP;
        SHIP;
        DataShare;
        ryacc;
        Mosaic;
    }
    subgraph 1990 {
        graph [ rank=same ];
        libft;
        CoShell;
        DIA;
        "IFS-i";
        kyacc;
        sfio;
        yeast;
        "ML-X";
        DOT;
    }
    subgraph future {
        graph [ rank=same ];
        "Adv. Software Technology";
    }
    past -> 1978;
    1978 -> 1980;
    1980 -> 1982;
    1982 -> 1983;
    1983 -> 1985;
    1985 -> 1986;
    1986 -> 1987;
    1987 -> 1988;
    1988 -> 1989;
    1989 -> 1990;
    1990 -> future;
    SCCS -> RCS;
    SCCS -> "3D File System";
    SCCS -> nmake;
    make -> nmake;
    make -> build;
    "Bourne sh" -> Cshell;
    "Bourne sh" -> ksh;
    yacc -> ryacc;
    cron -> yeast;
    "Reiser cpp" -> ncpp;
    Cshell -> ksh;
    build -> "nmake 2.0";
    vi -> ksh;
    vi -> "<curses>";
    emacs -> ksh;
    RCS -> SBCS;
    RCS -> fdelta;
    "<curses>" -> "<curses-i>";
    SYNED -> Peggy;
    IMX -> TTU;
    ksh -> nmake;
    ksh -> "ksh-i";
    ksh -> "ksh-88";
    IFS -> "<curses-i>";
    IFS -> sfio;
    IFS -> "IFS-i";
    TTU -> PG2;
    nmake -> ksh;
    nmake -> ncpp;
    nmake -> "3D File System";
    nmake -> "nmake 2.0";
    Peggy -> "PEGASUS/PML";
    Peggy -> ryacc;
    "C*" -> CSAS;
    ncpp -> "Ansi cpp";
    "<curses-i>" -> fdelta;
    "ksh-i" -> "ksh-88";
    PG2 -> backtalk;
    DAG -> "Sotware IS";
    DAG -> DOT;
    DAG -> DIA;
    CSAS -> CIA;
    "Ansi cpp" -> "Configuration Mgt";
    fdelta -> SBCS;
    fdelta -> PAX;
    "3D File System" -> "Configuration Mgt";
    "nmake 2.0" -> "Configuration Mgt";
    "nmake 2.0" -> CoShell;
    CIA -> "CIA++";
    CIA -> DIA;
    SBCS -> "Configuration Mgt";
    PAX -> SHIP;
    "ksh-88" -> "Configuration Mgt";
    "ksh-88" -> "Architecture & Libraries";
    "ksh-88" -> sfio;
    "PEGASUS/PML" -> "ML-X";
    "PEGASUS/PML" -> "Architecture & Libraries";
    backtalk -> DataShare;
    "CIA++" -> "Software IS";
    APP -> DIA;
    APP -> "Software IS";
    SHIP -> "Configuration Mgt";
    DataShare -> "Architecture & Libraries";
    ryacc -> kyacc;
    Mosaic -> Process;
    DOT -> "Software IS";
    DIA -> "Software IS";
    libft -> "Software IS";
    CoShell -> "Configuration Mgt";
    CoShell -> "Architecture & Libraries";
    sfio -> "Architecture & Libraries";
    "IFS-i" -> "Architecture & Libraries";
    "ML-X" -> "Architecture & Libraries";
    kyacc -> "Architecture & Libraries";
    yeast -> Process;
    "Architecture & Libraries" -> "Adv. Software Technology";
    "Software IS" -> "Adv. Software Technology";
    "Configuration Mgt" -> "Adv. Software Technology";
    Process -> "Adv. Software Technology";
}