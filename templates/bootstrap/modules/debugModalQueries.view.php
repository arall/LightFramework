<?php defined('_EXE') or die('Restricted access'); ?>

<!-- Debug Modal - Queries -->
<div class="modal modal-debug fade" id="debugModalQueries<?=$debugModalId?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Queries <small>Total time: <?=$debug['sqlTime']?> ms</small></h4>
            </div>
            <div class="modal-body">
                <?php if(count($debug["queries"])){ ?>
                    <div class="panel-group" id="debugAcordion">
                    <?php foreach($debug["queries"] as $i=>$query){ ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$debugModalId?><?=$i?>">
                                        <?php if(!$query['error']){ ?>
                                            <span class="label label-success">OK</span>
                                        <?php }else{ ?>
                                            <span class="label label-danger">Error</span>
                                        <?php } ?>
                                        <?=(strlen($query['query']) > 100) ? substr($query['query'],0,100).' ...' : $query['query'];?>
                                        <span class="badge pull-right"><?=$query['time']?> ms</span>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse<?=$debugModalId?><?=$i?>" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <?php if($query['error']){ ?>
                                        <?php $sqlErrror = true; ?>
                                        <blockquote class="danger">
                                            <h4>Error</h4>
                                            <?=Helper::sanitize($query['error']);?>
                                        </blockquote>
                                    <?php } ?>
                                    <?=SqlFormatter::format($query['query'])?>
                                    <?php if($query['trace']){ ?>
                                        <pre><?=Helper::sanitize($query['trace']);?></pre>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php }else{ ?>
                    <blockquote>
                        <p>No queries</p>
                    </blockquote>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- /Debug Modal - Queries -->
