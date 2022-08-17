<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['mailtest'] = 'Test';

$route['cpanel'] = 'cpanel/loginctl';
$route['cpanel/login'] = 'cpanel/loginctl/login';
$route['cpanel/home'] = 'cpanel/dashboardctl';
$route['cpanel/denied/(:any)'] = 'cpanel/dashboardctl/denied/$1';
$route['cpanel/logout'] = 'cpanel/loginctl/logout';
$route['cpanel/users'] = 'cpanel/usersctl';
$route['cpanel/users/(:any)'] = 'cpanel/usersctl/$1';
$route['cpanel/users/(:any)/(:num)'] = 'cpanel/usersctl/$1/$2';
$route['cpanel/groups'] = 'cpanel/groupsctl';
$route['cpanel/groups/(:any)'] = 'cpanel/groupsctl/$1';
$route['cpanel/groups/(:any)/(:num)'] = 'cpanel/groupsctl/$1/$2';

$route['cpanel/section'] = 'cpanel/sectionctl';
$route['cpanel/section/(:any)'] = 'cpanel/sectionctl/$1';
$route['cpanel/section/(:any)/(:num)'] = 'cpanel/sectionctl/$1/$2';

$route['cpanel/products'] = 'cpanel/Productctl';
$route['cpanel/products/(:any)'] = 'cpanel/Productctl/$1';
$route['cpanel/products/(:any)/(:num)'] = 'cpanel/Productctl/$1/$2';

$route['cpanel/merchants'] = 'cpanel/Merchantctl';
$route['cpanel/merchants/(:any)'] = 'cpanel/Merchantctl/$1';
$route['cpanel/merchants/(:any)/(:num)'] = 'cpanel/Merchantctl/$1/$2';

$route['cpanel/components'] = 'cpanel/componentsctl';
$route['cpanel/components/(:any)'] = 'cpanel/componentsctl/$1';
$route['cpanel/components/author/add'] = 'cpanel/componentsctl/add_author';
$route['cpanel/components/author/edit/(:num)'] = 'cpanel/componentsctl/edit_author/$1';
$route['cpanel/components/author/delete'] = 'cpanel/componentsctl/delete_author';
$route['cpanel/components/tags/add'] = 'cpanel/componentsctl/add_tags';
$route['cpanel/components/tags/edit/(:num)'] = 'cpanel/componentsctl/edit_tags/$1';

$route['cpanel/content'] = 'cpanel/contentctl';
$route['cpanel/content/(:any)'] = 'cpanel/contentctl/$1';
$route['cpanel/content/article/add'] = 'cpanel/contentctl/add_article';
$route['cpanel/content/article/edit/(:num)'] = 'cpanel/contentctl/edit_article/$1';
$route['cpanel/content/article/get_image'] = 'cpanel/contentctl/get_image';
$route['cpanel/content/article/get_product'] = 'cpanel/contentctl/get_product';
$route['cpanel/content/(:any)/(:num)'] = 'cpanel/contentctl/$1/$2';

$route['cpanel/approval'] = 'cpanel/Approvalctl';
$route['cpanel/approval/(:any)'] = 'cpanel/Approvalctl/$1';
$route['cpanel/approval/(:any)/(:num)'] = 'cpanel/Approvalctl/$1/$2';

$route['cpanel/image_library'] = 'cpanel/imagectl';
$route['cpanel/image_library/(:any)'] = 'cpanel/imagectl/$1';
$route['cpanel/template'] = 'cpanel/templatectl';
$route['cpanel/template/(:any)'] = 'cpanel/templatectl/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['(.+)/(:num).html'] = 'homecontroller/article/$2';
$route['(.+)'] = 'homecontroller/section';