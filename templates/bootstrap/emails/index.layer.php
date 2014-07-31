<?php defined('_EXE') or die('Restricted access'); ?>

<?php $config = Registry::getConfig(); ?>

<div marginwidth="0" marginheight="0" style="margin:0;padding:0;background-color:#f5f5f5;width:100%!important">
    <center>
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;margin:0;padding:0;height:100%!important;width:100%!important">
            <tbody>
                <tr>
                    <td align="center" valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" width="550">
                            <tbody>
                                <tr>
                                    <td style="padding:0 15px 0 15px">
                                        <table valign="bottom" border="0" cellpadding="0" cellspacing="0" width="520" height="40">
                                            <tbody>
                                                <tr>
                                                    <td valign="bottom">
                                                        <img width="520" height="5" valign="bottom" src="<?=Url::template("img/emails/top.png");?>"
                                                        style="max-width:520px;display:block;border:none;font-size:14px;font-weight:bold;min-height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table border="0" cellpadding="36" cellspacing="0" width="520" style="border:1px solid #e6e6e6;border-bottom:none;border-top:none;background-color:#ffffff">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <table border="0" cellpadding="0" cellspacing="0" width="445">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" valign="top">
                                                                        <table border="0" cellpadding="0" cellspacing="0" width="445">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td valign="top" style="background-color:#ffffff">
                                                                                        <a href="<?=Url::site();?>" target="_blank">
                                                                                            <h3><?=$config->get("title");?></h3>
                                                                                        </a>
                                                                                    </td>
                                                                                    <td width="200" style="text-align:right">
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" valign="top">
                                                                        <table border="0" cellpadding="0" cellspacing="0" width="445">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td valign="top" style="background-color:#ffffff">
                                                                                        <?=$content;?>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table border="0" cellpadding="0" cellspacing="0" width="520">
                                            <tbody>
                                                <tr>
                                                    <td valign="top">
                                                        <img src="<?=Url::template("img/emails/bottom.png");?>"
                                                        style="max-width:520px;border:none;font-size:14px;font-weight:bold;min-height:auto;line-height:100%;outline:none;text-decoration:none;text-transform:capitalize;display:block" width="520" height="20">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table border="0" cellpadding="5" cellspacing="0" width="520">
                                            <tbody>
                                                <tr>
                                                    <td align="center" valign="top">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="510">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="top">
                                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td valign="middle" width="520">
                                                                                        <div style="color:#b3b3b3;font-family:Helvetica,Arial;font-size:11px;line-height:125%;text-align:center"><?=$config->get("title");?> <?=date("Y");?></div>
                                                                                        <br>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </center>
</div>
