<?php defined('_EXE') or die('Restricted access'); ?>

<!-- Debug Modal - Messages -->
<div class="modal modal-debug fade" id="debugModalMessages<?=$debugModalId;?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Messages</h4>
            </div>
            <div class="modal-body">
                <?php if(count($debug["messages"])){ ?>
                    <ul class="list-group">
                        <?php foreach($debug["messages"] as $message){ ?>
                            <li class="list-group-item">
                                <blockquote>
                                    <?=Helper::printDebugMessage($message["message"]);?>
                                </blockquote>
                                <pre><?=Helper::sanitize($message['trace']);?></pre>
                            </li>
                        <?php } ?>
                    </ul>
                <?php }else{ ?>
                    <blockquote>
                        <p>No messages data</p>
                    </blockquote>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- /Debug Modal - Messages -->
