<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


// CONSTANTS for mail
define('SMTP_HOST','mail.vinfotech.com');
define('SMTP_USER','pradeep@vinfotech.com');
define('SMTP_PASS','V452001');
define('SMTP_PORT','25');
define('MAILPATH','');
define('MAILTYPE','html');
define('CHARSET','iso-8859-1');
define('WORD_WRAP',TRUE);
define('FROM_EMAIL','noreply@inksmash.com');
define('FROM_NO_REPLY','');
define('FROM_NAME','Admin');
define('SUPPORT_EMAIL','');


// CONSTANTS for Table
define('POLLS_COOKIE_EXPIRE_TIME',time()+60*5);
define('TERM_DATA','category_term');
define('TERM_HIERARCHY','category_term_hierarchy');
/*
switch($_SERVER['SERVER_NAME'])
{
	case '192.168.0.172':
		define('FB_APP_ID','283074341776753');
		break;
	case '174.120.141.136':
		define('FB_APP_ID','393451360675383');
		break;
	case 'devinksmash.elasticbeanstalk.com':
		define('FB_APP_ID','341550032592079');
		break;
	default:
		define('FB_APP_ID','341550032592079');
}
//local
define('FB_APP_ID','283074341776753');
//test
define('FB_APP_ID','393451360675383');
//live
define('FB_APP_ID','158026374323440');
define('FB_APP_ID','341550032592079');
*/


define('AWS_API_KEY', 'AKIAJUIXVQBPPKWKFLBA');
define('AWS_API_SECRET_KEY', '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');
define('AWS_LANG', 'com');
define('AWS_ASSOCIATE_TAG', 'ASSOCIATE TAG');
define('AWS_ANOTHER_ASSOCIATE_TAG', 'ANOTHER ASSOCIATE TAG');


// define s3 aws api key and secret key for
define('AWS_S3_API_KEY', 'AKIAIHSYHDMSBWJZQXKQ');
define('AWS_S3_SECRET_KEY', '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');
switch($_SERVER['SERVER_NAME'])
{
	case '192.168.0.172':
	case 'localhost':
		define('ROOT_PATH',$_SERVER['DOCUMENT_ROOT'].'/ink-smash/');
		define('PROTOCOL','mail');
		define('FB_APP_ID','125154367647736');
		define('BUCKET_NAME', 'ink-staging');
		define('S3_URL', 'https://s3.amazonaws.com/');
		break;
	case '118.139.164.242':
		define('ROOT_PATH',$_SERVER['DOCUMENT_ROOT'].'/ink-smash/');
		define('PROTOCOL','mail');
		define('FB_APP_ID','393451360675383');
		define('BUCKET_NAME', 'ink-staging');
		define('S3_URL', 'https://s3.amazonaws.com/');		
		break;
	case 'devinksmash.elasticbeanstalk.com':
		define('ROOT_PATH',$_SERVER['DOCUMENT_ROOT'].'/');
		define('PROTOCOL','mail');
		define('FB_APP_ID','341550032592079');
		define('BUCKET_NAME', 'ink-live');
		define('S3_URL', 'https://s3.amazonaws.com/');
		break;
	default:
		define('ROOT_PATH',$_SERVER['DOCUMENT_ROOT'].'/');
		define('PROTOCOL','mail');
		define('FB_APP_ID','341550032592079');
		define('BUCKET_NAME', 'ink-live');
		define('S3_URL', 'https://s3.amazonaws.com/');
}
//CONSTANT FOR AMAZON SITE DEFAULT USER CODE
define('DEFAULT_AMAZON_USER_CODE','rtco01-20');

// CONSTANT FOR SUB CATEGORY NAME " QNA"
define('QNA_SUB_CATEGORY_ID','17');



/* *********************************EMAIL FORMAT*********************************** */

//Base template for mail
define("MAIL_TEMPLATE",'<div>{MAIL_BODY}<br><br>Your InkSmash Support Team<br><a href="http://www.inksmash.com">www.inksmash.com</a><br><br>{MAIL_FOOTER}</div>');



//Welcome email for Inksmash and email verification link 
define("WELCOME_INKSMASH_MAIL_SUBJECT","[Inksmash] Thank you for registering with InkSmash!");

define("WELCOME_INKSMASH_MAIL","Hi {FIRST_NAME},<br><br>Welcome to InkSmash. Details of your account are as follows.<br><br>User Name : {FIRST_NAME}<br><br>Please click on the link below to activate your account:<br><br><a href='{EMAIL_VERIFIED_LINK}'>{EMAIL_VERIFIED_LINK}</a><br><br>For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a><br><br>Thank you!");
	
define("WELCOME_INKSMASH_MAIL_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");


//Welcome email for Inksmash and email verification link 
define("VERIFICATION_DONE_MAIL_SUBJECT","[Inksmash] Registration at InkSmash successful!");

define("VERIFICATION_DONE_MAIL","Hi {FIRST_NAME},<br><br>Welcome to InkSmash:). Your account is now confirmed. Please log in to your account at <a href='http://www.inksmash.com/user/login'>Login</a><br><br>For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a><br><br>Thank you!");
	
define("VERIFICATION_DONE_MAIL_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");


//User Forgot Password
define("USER_FORGOT_PASSWORD_SUBJECT","[Inksmash] Password reminder!");

define("USER_FORGOT_PASSWORD_MAIL","Hi {FIRST_NAME},<br><br>A request was made to change the password for your account.  If this was made in error, you may ignore this e-mail, otherwise, Please click on the link below to change your password. (or copy and paste it on your browser).<br><br><a href='{CHANGE_PASS_LINK}'>{CHANGE_PASS_LINK}</a>");

define("USER_FORGOT_PASSWORD_MAIL_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");




//User Forgot Username
// CREATED DATE :- 2012-12-14.(Friday)
define("USER_FORGOT_USERNAME_SUBJECT","[Inksmash] Username reminder!");

define("USER_FORGOT_USERNAME_MAIL","Hi {PROFILE_NAME},<br><br>A request was made to retrieve the username for your account.
The username for your account is :- <a href='{PROFILE_LINK}'>{USER_NAME}</a>.<br>If this was made in error, you may ignore this e-mail, otherwise, Please click on the link below to login with your username. (or copy and paste it on your browser).<br><br><a href='{CHANGE_USERNAME_LINK}'>{CHANGE_USERNAME_LINK}</a>");

define("USER_FORGOT_USERNAME_MAIL_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");


//User Password Changed
define("USER_CHANGED_PASSWORD_SUBJECT","[Inksmash] Change of Account Information!");

define("USER_CHANGED_PASSWORD_MAIL","Hi {FIRST_NAME},<br><br>You have chosen to change your password. Please log in with the new password. For any queries, suggestions or assistance please contact the InkSmash support Team at <a href='mailto:feedback@inksmash.com'>feedback@inksmash.com</a><br><br>For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a><br><br>Thank you!");

define("USER_CHANGED_PASSWORD_MAIL_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");



// contact form submittion user notification
define("CONTACT_FROM_NOTIFICATION_TO_USER_SUBJECT","[Inksmash] Your request submitted successfully!");

define("CONTACT_FROM_NOTIFICATION_TO_USER_MAIL","Hi {NAME},<br><br>We have noted your request. We will process it soon and get back to you. Thanks for writing to us:)<br><br>For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a> and you may sign up on inksmash from <a href='www.inksmash.com'>www.inksmash.com</a><br><br>Thank you!");

define("CONTACT_FROM_NOTIFICATION_TO_USER_MAIL_FOOTER","");



// contact form submission to admin 
define("CONTACT_FROM_NOTIFICATION_TO_ADMIN_SUBJECT","[Inksmash] You have a new enquiry!");

define("CONTACT_FROM_NOTIFICATION_TO_ADMIN_MAIL","Hi Admin,<br><br>A new user has posted the details on your account. Details are:<br>Name: {NAME}<br>Email: {EMAIL}<br> Country: {COUNTRY}<br>Telephone: {PHONE}<br>Comments:<br>{COMMENT}<br><br>Thank you!");

define("CONTACT_FROM_NOTIFICATION_TO_ADMIN_MAIL_FOOTER","");


//User Active By Admin
define("USER_ACTIVE_SUBJECT","[Inksmash] Inksmash User Actived");
define("USER_ACTIVE_MAIL","<h3>Account Activated, {USER_NAME}! </h3>
Your Inksmash account is now active. If you are still having problems, please send an email to <a style=\"color:#000;\" href='mailto:info@timefix.com'>info@timefix.com</a><br />");
define("USER_ACTIVE_MAIL_FOOTER","You are receiving this email because a TimeFix user created an account  with this email address. If you are the owner of this email address and did not create the appointment, just ignore this message and the account will remain inactive.</p>");



//USER Inactive By Admin
define("USER_INACTIVE_SUBJECT","[Inksmash] Inksmash User De-actived");
define("USER_INACTIVE_MAIL","<h3>Account Inactive, {USER_NAME}! </h3>
Your TimeFix account has been dectivated due to the following reason(s):<br /><br />
<b>{INACTIVE_REASON}</b>
<br /><br />
In order to activate your account, please login to TimeFix and resolve the above mentioned issue(s).<br /> 
If you are still having problems, please send an email to support!.<br />");
define("USER_INACTIVE_MAIL_FOOTER","You are receiving this email because a TimeFix user created an account  with this email address. If you are the owner of this email address and did not create the appointment, just ignore this message and the account will remain inactive.</p>");



/* here we are define constant for notifications. */
define("NOTIFICATION_FROM_INKSMASH","[Inksmash] Notification!");

/*  SOMEONE_MAKE_COMMENT_ON_YOUR_POST MAIL SECTION */
define("SOMEONE_MAKE_COMMENT_ON_YOUR_POST", "[Inksmash] Comment posted on your Ink");

define("SOMEONE_MAKE_COMMENT_ON_YOUR_POST_MAIL","Hi {FIRST_NAME},<br>There's a new comment posted on your Ink {POST_TITLE} by {COMMENTER_NAME}.<br> The comment is : <br><br> {COMMENT} <br><br> For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a><br><br>Thank you!");

define("SOMEONE_MAKE_COMMENT_ON_YOUR_POST_MAIL_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");


/* SOMEONE_ANSWER_YOUR_QUESTION MAIL SECTION */
define("SOMEONE_ANSWER_YOUR_QUESTION", "[Inksmash] Answer posted on your Question");

define("SOMEONE_ANSWER_YOUR_QUESTION_MAIL","Hi {FIRST_NAME},<br> There’s a new answer added to your Question posted {POST_TITLE}  	by {COMMENTER_NAME}.<br>The comment is :<br><br>{COMMENT}  <br><br>For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a><br><br>Thank you!");

define("SOMEONE_ANSWER_YOUR_QUESTION_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");



/* SOMEONE_COMMENTS_ON_YOU_COMMENTED MAIL SECTION */
define("SOMEONE_COMMENTS_ON_YOU_COMMENTED","[Inksmash] New comment added after you posted a comment");

define("SOMEONE_COMMENTS_ON_YOU_COMMENTED_MAIL","Hi {FIRST_NAME},<br> There’s a new comment added to the post {POST_TITLE} by {COMMENTER_NAME}.<br> The comment is : <br><br> {COMMENT} <br><br>For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a><br><br>Thank you!");

define("SOMEONE_COMMENTS_ON_YOU_COMMENTED_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");


/* SOMEONE_COMMENTS_ON_YOU_COMMENTED MAIL SECTION */
define("SOMEONE_ANSWERED_QUESTION_YOU_ANSWERED","[Inksmash] New answer added after you posted a answer");

define("SOMEONE_ANSWERED_QUESTION_YOU_ANSWERED_MAIL","Hi {FIRST_NAME},<br> There’s a new answer added to the post {POST_TITLE} by {COMMENTER_NAME}.<br>The comment is :<br><br>{COMMENT} <br><br>For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a><br><br>Thank you!");

define("SOMEONE_ANSWERED_QUESTION_YOU_ANSWERED_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");


/* YOUR ANSWER WILL BE SELECTED AS BEST ANSWER */
define("MAKE_BEST_ANSWER","[Inksmash] Your answer marked as the best one :)");

define("MAKE_BEST_ANSWER_MAIL","Hi {FIRST_NAME},<br> You has posted an answer a Question posted on {POST_TITLE} by {POST_OWNER}.<br> Well done and we wish to have you answer more such questions :).<br><br>For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a><br><br>Thank you!");

define("MAKE_BEST_ANSWER_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");


/* SOMEONE_START_FOLLOWING_YOU MAIL SECTION */
define("SOMEONE_START_FOLLOWING_YOU","[Inksmash] You have a new follower");

define("SOMEONE_START_FOLLOWING_YOU_MAIL","Hi {FOLLOWING_NAME},<br> {FOLLOWER_NAME} has started following you. You can follow them back to keep yourself updated with all posts that user is posting. <br><br>For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a><br><br>Thank you!");

define("SOMEONE_START_FOLLOWING_YOU_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");


/* SOMEONE_START_FOLLOWING_YOU MAIL SECTION */
define("RECEIVE_EMAIL_WITHIN_INKSMASH","[Inksmash] You have a new message in your inbox");

define("RECEIVE_EMAIL_WITHIN_INKSMASH_MAIL","Hi {RECEIVER_NAME},<br>You have a new message posted by {SENDER_NAME} to your inbox at Inksmash.{MESSAGE_INBOX}<br><br>For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a><br><br>Thank you!");

define("RECEIVE_EMAIL_WITHIN_INKSMASH_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");


/* SOMEONE_START_FOLLOWING_YOU MAIL SECTION */
define("SOMEONE_ANSWER_PUBLISHERS_POLL","[Inksmash] New user answered your poll");

define("SOMEONE_ANSWER_PUBLISHERS_POLL_MAIL","Hi {PUBLISHER_NAME},<br>{ANSWER_NAME} posted their views on your poll.{POLL_URL} <br><br>For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a><br><br>Thank you!");

define("SOMEONE_ANSWER_PUBLISHERS_POLL_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");


/* SOMEONE SUBSCRIBE BY EMAIL */
define("SUBSCRIPTION_SUBJECT","[Inksmash] Your subscription with Inksmash");

define("SUBSCRIPTION_MAIL","Hi ,<br>You are succesfully subscribed with us by this {MAIL} Email Id.<br><br>For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a><br><br>Thank you!");

define("SUBSCRIPTION_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");


/* End of file constants.php */
/* Location: ./application/config/constants.php */