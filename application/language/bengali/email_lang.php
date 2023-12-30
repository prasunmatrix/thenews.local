<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['email_must_be_array'] = 'The email validation method must be passed an array.';
$lang['email_invalid_address'] = 'Invalid email address: %s';
$lang['email_attachment_missing'] = 'Unable to locate the following email attachment: %s';
$lang['email_attachment_unreadable'] = 'Unable to open this attachment: %s';
$lang['email_no_from'] = 'Cannot send mail with no "From" header.';
$lang['email_no_recipients'] = 'You must include recipients: To, Cc, or Bcc';
$lang['email_send_failure_phpmail'] = 'Unable to send email using PHP mail(). Your server might not be configured to send mail using this method.';
$lang['email_send_failure_sendmail'] = 'Unable to send email using PHP Sendmail. Your server might not be configured to send mail using this method.';
$lang['email_send_failure_smtp'] = 'Unable to send email using PHP SMTP. Your server might not be configured to send mail using this method.';
$lang['email_sent'] = 'Your message has been successfully sent using the following protocol: %s';
$lang['email_no_socket'] = 'Unable to open a socket to Sendmail. Please check settings.';
$lang['email_no_hostname'] = 'You did not specify a SMTP hostname.';
$lang['email_smtp_error'] = 'The following SMTP error was encountered: %s';
$lang['email_no_smtp_unpw'] = 'Error: You must assign a SMTP username and password.';
$lang['email_failed_smtp_login'] = 'Failed to send AUTH LOGIN command. Error: %s';
$lang['email_smtp_auth_un'] = 'Failed to authenticate username. Error: %s';
$lang['email_smtp_auth_pw'] = 'Failed to authenticate password. Error: %s';
$lang['email_smtp_data_failure'] = 'Unable to send data: %s';
$lang['email_exit_status'] = 'Exit status code: %s';

$lang['email_news_user_register_text_1'] = 'We are very happy to have you as a new member of our site.';
$lang['email_news_user_register_text_2'] = 'Your account has been created successfully.';
$lang['email_news_user_register_text_3'] = 'Click on the below button to verify your email address.';
$lang['verify_your_email'] = 'Verify your email';

$lang['welcome'] = 'Welcome %s';
$lang['email_text_further_assistance'] = 'In case you need further assistance, feel free to send an email to <a href="mailto:%1$s">%1$s</a>';
$lang['email_dear'] = "Dear";

$lang['new_subscription_email_text1'] = "Your email is subscribed for newsletter successfully. Now you will receive new updated, news, and Important information directoly in your inbox.";
$lang['new_subscription_email_text2'] = "To verify your email please click on the below button.";
$lang['verify_email'] = "Verify Email";

$lang['your_email_is_subscribed_successfully'] = "Your email is subscribed successfully.";

$lang['contact_us_thanks_email_text1'] = "Thanks for contact with us.";
$lang['contact_us_thanks_email_text2'] = "We appreciate you contacting us about <strong>%s</strong>. One of our customer happiness members will be getting back to you shortly.";
$lang['contact_us_thanks_email_text3'] = "While we do our best to answer your queries quickly, it may take about 24 hours to receive a response from us during peak hours.";
$lang['contact_us_thanks_email_text4'] = "Thanks in advance for your patience.";
$lang['contact_us_thanks_email_text5'] = "Have a great day!";

$lang['reset_your_account_password'] = 'Reset your account password.';

$lang['forgot_password_email_text_1'] = "You are receiving this email because we received a password reset request for your account. Click on the below <strong>Reset Password</strong> button to change your account password.";
$lang['forgot_password_email_text_2'] = "<strong>If you did not request a password reset, no further action is required.</strong>";
$lang['forgot_password_email_text_3'] = "Note that you can change your password only once by tapping the below button. Below link will be expired in the next <strong>15 minutes</strong>.";

$lang['reset_password'] = "Reset Password";

$lang['unsubscribe_emails_txt'] = "This email is sent from <a href='%s' style='color:#999;text-decoration:none;'>%s</a>";
$lang['powered_by'] = "Powered by: <a href='%s' style='color:#999;text-decoration:none;' target='_BLANK'>%s</a>";

$lang['thanks_for_the_subscription'] = "Thanks for the subscription";
$lang['email_subscription_text_1'] = "Thanks for the <strong>PB24</strong> news subscription. Now you can enjoy the full access of the news.";
$lang['email_subscription_text_2'] = "Your subscription end date will be <strong>%s</strong>. Your payment ID: <strong>%s</strong>.";
