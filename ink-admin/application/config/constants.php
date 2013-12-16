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
define('FROM_EMAIL','pradeep@vinfotech.com');
define('FROM_NO_REPLY','');
define('FROM_NAME','Admin');
define('SUPPORT_EMAIL','');


// CONSTANTS for Table
define('POLLS_COOKIE_EXPIRE_TIME',time()+60*5);
define('TERM_DATA','category_term');
define('TERM_HIERARCHY','category_term_hierarchy');


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
		define('PROTOCOL','smtp');
		define('FB_APP_ID','125154367647736');
		define('BUCKET_NAME', 'ink-staging');
		define('S3_URL', 'https://s3.amazonaws.com/');
		break;
	case '174.120.141.136':
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


/* *********************************EMAIL FORMAT*********************************** */

//Base template for mail

define("MAIL_TEMPLATE",'<div>{MAIL_BODY}<br>InkSmash Support Team<br><a href="http://www.inksmash.com">www.inksmash.com</a><br><br>{MAIL_FOOTER}</div>');


//ADMIN_VERIFY_ACCOUNT email for Inksmash  

define("ADMIN_VERIFY_ACCOUNT_MAIL_SUBJECT","Your account has been activated!");

define("ADMIN_VERIFY_ACCOUNT_MAIL","Hi {USER_NAME},<br><br>Welcome to InkSmash. Now would be able to make a post or any activity on the site as the Admin has activate your account.<br><br>For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a><br><br>Thank you!");
	
define("ADMIN_VERIFY_ACCOUNT_MAIL_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");



//SUSPEND_ACCOUNT_MAIL 

define("SUSPEND_ACCOUNT_MAIL_SUBJECT","Your account has been suspended!");

define("SUSPEND_ACCOUNT_MAIL","Hi {USER_NAME},<br><br>Welcome to InkSmash. Now would not be able to make a post or any activity on the site as the Admin has suspended your account.<br><br>If you wish to write about this issue, please contact admin at <a href='mailto:support@inksmash.com'>support@inksmash.com</a><br><br>Thank you!");
	
define("SUSPEND_ACCOUNT_MAIL_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");



//RESUME_ACCOUNT_MAIL 

define("RESUME_ACCOUNT_MAIL_SUBJECT","Your account has been activated!");

define("RESUME_ACCOUNT_MAIL","Hi {USER_NAME},<br><br>Welcome to InkSmash. Now would be able to make a post or any activity on the site as the Admin has reactivate your account.<br><br>For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a><br><br>Thank you!");
	
define("RESUME_ACCOUNT_MAIL_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");



//User Forgot Password
 
define("USER_FORGOT_PASSWORD_SUBJECT","Password reminder!");

define("USER_FORGOT_PASSWORD_MAIL","Hi {USER_NAME},<br><br>A request was made to change the password for your account.  If this was made in error, you may ignore this e-mail, otherwise, Please click on the link below to change your password. (or copy and paste it on your browser).<br><br><a href='{CHANGE_PASS_LINK}'>{CHANGE_PASS_LINK}</a><br><br>For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a><br><br>Thank you!");

define("USER_FORGOT_PASSWORD_MAIL_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");



//User VERIFICATION_MAIL
define("VERIFICATION_MAIL_SUBJECT","Welcome to InkSmash!");

define("VERIFICATION_MAIL","Hi {USER_NAME},<br><br> Please click on the link below verify your account. (or copy and paste it on your browser).<br><br><a href='{VERIFICATION_LINK}'>{VERIFICATION_LINK}</a><br><br>For any questions or assistance write to us anytime at <a href='mailto:info@inksmash.com'>info@inksmash.com</a><br><br>Thank you!");
	
define("VERIFICATION_MAIL_FOOTER","You are receiving this email because a Inksmash user  created an account with this email address. If you are the owner of this email  address and did not create the Inksmash account, just ignore this message and  the account will remain inactive.");



//User Active By Admin
define("USER_ACTIVE_SUBJECT","Inksmash User Actived");

define("USER_ACTIVE_MAIL","<h3>Account Activated, {USER_NAME}! </h3>
Your Inksmash account is now active. If you are still having problems, please send an email to <a style=\"color:#000;\" href='mailto:info@timefix.com'>info@timefix.com</a><br />");

define("USER_ACTIVE_MAIL_FOOTER","You are receiving this email because a TimeFix user created an account  with this email address. If you are the owner of this email address and did not create the appointment, just ignore this message and the account will remain inactive.</p>");



//USER Inactive By Admin
define("USER_INACTIVE_SUBJECT","Inksmash User De-actived");

define("USER_INACTIVE_MAIL","<h3>Account Inactive, {USER_NAME}! </h3>
Your TimeFix account has been dectivated due to the following reason(s):<br /><br />
<b>{INACTIVE_REASON}</b>
<br /><br />
In order to activate your account, please login to TimeFix and resolve the above mentioned issue(s).<br /> 
If you are still having problems, please send an email to support!.<br />");

define("USER_INACTIVE_MAIL_FOOTER","You are receiving this email because a TimeFix user created an account  with this email address. If you are the owner of this email address and did not create the appointment, just ignore this message and the account will remain inactive.</p>");



/* End of file constants.php */
/* Location: ./application/config/constants.php */