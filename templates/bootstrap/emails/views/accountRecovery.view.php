<p><?=Language::translate("EMAILS_ACCOUNT_RECOVERY_EMAIL_TEXT");?></p>
<p>
    <a href="<?=Url::site("login/restore/".$hash);?>" target="_blank">
        <?=Language::translate("EMAILS_ACCOUNT_RECOVERY_EMAIL_LINK");?>
    </a>
</p>
