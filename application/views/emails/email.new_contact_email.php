<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; margin: 0; padding: 0;">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?= lang('email_title_new_user_account') ?></title>
</head>
<body bgcolor="#f6f6f6" style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; margin: 0; padding: 0;">
<table class="body-wrap" style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; width: 100%; margin: 0; padding: 20px;">
    <tr style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; margin: 0; padding: 0;">
        <td style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; margin: 0; padding: 0;"></td>
        <td class="container" bgcolor="#FFFFFF" style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 20px; border: 1px solid #f0f0f0;">
            <div class="content" style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; max-width: 600px; display: block; margin: 0 auto; padding: 0;">
                <div><p><img  alt="logo" style="height:100px;"  src="<?= S3_URL.S3_BUCKET_NAME ?>/images/<?= $logo; ?>" /></p></div>
                <table style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; width: 100%; margin: 0; padding: 0;">
                    <tr style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; margin: 0; padding: 0;">
                        <td style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; margin: 0; padding: 0;">
                            <p style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 0px; padding: 0;" class=''><?= lang('email_dear') ?> <strong><?= ucwords($user_name); ?></strong>,</p>
                            <br />
                            <p style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;" class=''><?= lang('contact_us_thanks_email_text1'); ?> </p>
                            <p style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;" class=''><?= sprintf(lang('contact_us_thanks_email_text2'),$subject); ?></p>
                            <p style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;" class=''><?= lang('contact_us_thanks_email_text3'); ?> </p>
                            <p style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;" class=''><?= lang('contact_us_thanks_email_text4'); ?> </p>
                            <p style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;" class=''><?= lang('contact_us_thanks_email_text5'); ?> </p>
                            <p style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">                                
                            <?= sprintf(lang('email_text_further_assistance'), $reply_email, $reply_email) ?>
                            </p>
                            <p style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;"><?= $email_signature; ?></p>                            
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; margin: 0; padding: 0;"></td>
    </tr>
</table>
<table class="footer-wrap" style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; width: 100%; clear: both !important; margin: 0; padding: 0;">
    <tr style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; margin: 0; padding: 0;">
        <td style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; margin: 0; padding: 0;"></td>
        <td class="container" style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 0;">
            <div class="content" style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; max-width: 600px; display: block; margin: 0 auto; padding: 0;">
                <table style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; width: 100%; margin: 0; padding: 0;">
                    <tr style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; margin: 0; padding: 0;">
                        <td align="center" style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; margin: 0; padding: 0;">
                            <p style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; line-height: 1.6; color: #666; font-weight: normal; margin: 0 0 10px; padding: 0;">
                                <a href="<?= site_url() ?>" style="text-decoration: none;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; color: #999; margin: 0; padding: 0;"><?= sprintf(lang("unsubscribe_emails_txt"), site_url(),site_url()); ?></a>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; margin: 0; padding: 0;"></td>
    </tr>
</table>
<table class="footer-wrap" style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; width: 100%; clear: both !important; margin: 0; padding: 0;">
    <tr style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; margin: 0; padding: 0;">
        <td style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; margin: 0; padding: 0;"></td>
        <td class="container" style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto; padding: 0;">
            <div class="content" style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; max-width: 600px; display: block; margin: 0 auto; padding: 0;">
                <table style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; width: 100%; margin: 0; padding: 0;">
                    <tr style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; margin: 0; padding: 0;">
                        <td align="center" style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; margin: 0; padding: 0;">
                            <p style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; line-height: 1.6; color: #666; font-weight: normal; margin: 0 0 10px; padding: 0;"><a href="#" style="text-decoration: none;font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; color: #999; margin: 0; padding: 0;"><?= sprintf(lang('powered_by'),'http://thepic.cloud','thePic.cloud | All-in-one Photo Studio Management System | Online Solutions for Photographers');  ?></a></p>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td style="font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;  line-height: 1.6; margin: 0; padding: 0;"></td>
    </tr>
</table>
</body>
</html>