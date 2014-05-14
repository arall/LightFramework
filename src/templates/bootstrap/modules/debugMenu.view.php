<?php defined('_EXE') or die('Restricted access'); ?>

<nav class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
    <div class="navbar-header">
        <!-- Page Load Debug -->
        <span class="navbar-brand" title="Page load time">
            <span class="glyphicon glyphicon-time"></span>
            <small><?=round(((microtime(true)-(int)$debug["started"])*1000), 2);?> ms</small>
        </span>
        <!-- PHP Memory Usage Debug -->
        <span class="navbar-brand" title="PHP memory usage">
            <span class="glyphicon glyphicon-fire"></span>
            <small><?=Helper::formatBytes(memory_get_usage());?></small>
        </span>
        <!-- Session size Debug -->
        <span class="navbar-brand" data-toggle="modal" title="Session size" data-target="#debugModalSession">
            <span class="glyphicon glyphicon-cloud"></span>
            <small><?=Helper::formatBytes(strlen(serialize($_SESSION)));?></small>
        </span>
        <!-- Current Queries Debug -->
        <a class="navbar-brand" data-toggle="modal" title="Current total executed queries" data-target="#debugModalQueriesCurrent">
            <span class="glyphicon glyphicon-cloud-upload"></span>
            <small><?=(int)count($debug["queries"]);?></small>
            <?php if($debug['sqlError']){ ?>
                <span class="glyphicon glyphicon-warning-sign" style="color:#d9534f;"></span>
            <?php } ?>
        </a>
        <!-- Previous Queries Debug -->
        <?php if($_SESSION['debug']["queries"]){ ?>
            <a class="navbar-brand" data-toggle="modal" title="Previous total executed queries" data-target="#debugModalQueriesLast">
                <span class="glyphicon glyphicon-cloud-download"></span>
                <small><?=(int)count($_SESSION['debug']["queries"]);?></small>
                <?php if($_SESSION['debug']['sqlError']){ ?>
                    <span class="glyphicon glyphicon-warning-sign" style="color:#d9534f;"></span>
                <?php } ?>
            </a>
        <?php } ?>
        <!-- Current Messages Debug -->
        <a class="navbar-brand" data-toggle="modal" title="Current Custom messages" data-target="#debugModalMessagesCurrent">
            <span class="glyphicon glyphicon-comment"></span>
            <small><?=(int)count($debug["messages"]);?></small>
        </a>
        <!-- Ajax Messages Debug  -->
        <a class="navbar-brand" data-toggle="modal" title="Ajax Custom messages" data-target="#debugModalMessagesAjax">
            <span class="glyphicon glyphicon-flash"></span>
            <small id="debugCounterMessagesAjax">0</small>
        </a>
    </div>
</nav>