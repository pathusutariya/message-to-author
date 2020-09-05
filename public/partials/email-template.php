<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title><?= bloginfo() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding: 10px 0 30px 0;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                <tr>
                    <td align="center" bgcolor="#70bbd9" style="padding: 40px 30px 30px 30px; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif; text-align: left"><?php bloginfo(); ?> Message for Author</td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                    <b>Hi! </b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
									<?= $message ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                                    &copy; <?= ''.date('Y').' ' ?><?= bloginfo(); ?>
                                </td>
                                <!--                                <td align="right" width="25%">-->
                                <!--                                    <table border="0" cellpadding="0" cellspacing="0">-->
                                <!--                                        <tr>-->
                                <!--                                            <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">-->
                                <!--                                                <a href="http://www.twitter.com/" style="color: #ffffff;">-->
                                <!--                                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/tw.gif" alt="Twitter" width="38" height="38" style="display: block;" border="0"/>-->
                                <!--                                                </a>-->
                                <!--                                            </td>-->
                                <!--                                            <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>-->
                                <!--                                            <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">-->
                                <!--                                                <a href="http://www.twitter.com/" style="color: #ffffff;">-->
                                <!--                                                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/fb.gif" alt="Facebook" width="38" height="38" style="display: block;" border="0"/>-->
                                <!--                                                </a>-->
                                <!--                                            </td>-->
                                <!--                                        </tr>-->
                                <!--                                    </table>-->
                                <!--                                </td>-->
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>