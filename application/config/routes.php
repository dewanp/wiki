<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/





$route['default_controller'] = "home";
$route['404_override'] = '';
$route['[A-Za-z0-9~%.:_\-]*/post/(:num)-([A-Za-z0-9~%.:_\-]*)'] = "post/view/$1";
$route['[A-Za-z0-9~%.:_\-]*/post/:any/:any/(:num)-([A-Za-z0-9~%.:_\-]*)'] = "post/view/$1";
$route['contest/(:num)-([A-Za-z0-9~%.:_\-]*)/(:num)'] = "contest/view/$1/$3";
//$route['contest/viewwinners/(:num)-([A-Za-z0-9~%.:_\-]*)'] = "contest/viewwinners";
$route['search'] = "search";


// static pages
$route['help-center'] = "page/help_center";
$route['about-inksmash'] = "page/about_inksmash";
$route['creating-post'] = "page/creating_post";
$route['creating-account'] = "page/creating_account";
$route['my-profile'] = "page/my_profile";
$route['following-user'] = "page/following_user";
$route['user-dashboard'] = "page/user_dashboard";
$route['dos-and-donts'] = "page/dos_and_donots";
$route['selecting-post-type'] = "page/selecting_post_type";
$route['choose-suitable-title'] = "page/choose_suitable_title";
$route['add-related-tags'] = "page/add_related_tags";
$route['share-social-networks'] = "page/share_social_networks";
$route['using-blocks'] = "page/using_blocks";
$route['earnings-section'] = "page/earnings_section";
$route['how-to-make-money'] = "page/how_to_make_money";
$route['setting-adsense-account'] = "page/setting_adsense_account";
$route['setting-amazon-affiliate-account'] = "page/setting_amazon_affiliate_account";
$route['tips-to-make-money'] = "page/tips_to_make_money";
$route['faq'] = "page/faq";
$route['terms-of-service'] = "page/terms_of_service";
$route['take-tour'] = "page/take_tour";
$route['what-we-do'] = "page/what_we_do";
$route['press-information'] = "page/press_information";
$route['official-blog'] = "page/official_blog";
$route['contact-us'] = "page/contact_us";
$route['management'] = "page/management";
$route['how-it-works'] = "page/how_it_works";

$route['admin'] = "admin/login";
$route['([A-Za-z0-9~%.:_\-]*)'] = "user/profile/$1";
$route['([A-Za-z0-9~%.:_\-]*)/favorites'] = "user/profile/$1/favorites";




/* End of file routes.php */
/* Location: ./application/config/routes.php */