<?php defined('_EXE') or die('Restricted access'); ?>

<!-- Debug Modal - Session -->
<div class="modal modal-debug fade" id="debugModalSession" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Session</h4>
            </div>
            <div class="modal-body">
                <?php if($_SESSION){ ?>
                    <?php echo "<pre>".Helper::sanitize(print_r($_SESSION, true))."</pre>"; ?>
                <?php }else{ ?>
                    <blockquote>
                        <p>No session data</p>
                    </blockquote>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- /Debug Modal - Session -->
