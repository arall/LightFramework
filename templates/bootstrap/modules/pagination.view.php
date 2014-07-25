<?php defined('_EXE') or die('Restricted access'); ?>

<?php $pages = $pag['limit'] ? ceil($pag['total'] / $pag['limit']) : $pag['total']; ?>
<?php $url = Registry::getUrl(); ?>
<?php $app = $url->app; ?>
<?php $action = $url->action; ?>

<?php if ($pages) { ?>
    <ul class="pagination">
        <li class="<?php if(($pag['limitStart']/$pag['limit'])==0) echo "disabled"; ?>">
            <a data-app="<?=$app?>" data-action="<?=$action?>" data-limit="<?=(int) $pag['limit']?>" data-limitstart="0">
                &laquo;
            </a>
        </li>
        <?php for ($i=0; $i<$pages; $i++) { ?>
            <li class="<?php if($i == ($pag['limitStart']/$pag['limit'])) echo "active"; ?>">
                <a data-app="<?=$app?>" data-action="<?=$action?>" data-limit="<?=(int) $pag['limit']?>" data-limitstart="<?=(int) ($i*$pag['limit'])?>">
                    <?=(int) $i+1?><span class="sr-only"></span>
                </a>
            </li>
        <?php } ?>
        <li class="<?php if(($pag['limitStart']/$pag['limit'])==$pages-1) echo "disabled"; ?>">
            <a data-app="<?=$app?>" data-action="<?=$action?>" data-limit="<?=(int) $pag['limit']?>" data-limitstart="<?=(int) (($pages-1)*$pag['limit'])?>">
                &raquo;
            </a>
        </li>
    </ul>
<?php }
