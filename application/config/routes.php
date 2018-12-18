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
| When you set this options to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['login'] = "login";
$route['login/check'] = "login/check";
$route['login/logout'] = "login/logout";

$route['customer'] = "customer";
$route['customer/create'] = "customer/create";
$route['customer/update(:num)'] = "customer/update/$1";
$route['customer/edit/(:num)'] = "customer/edit/$1";
$route['customer/delete/(:num)'] = "customer/delete/$1";
$route['customer/change_action/(:num)/(:any)'] = "customer/active_inactive/$1/$2";

$route['category'] = "category";
$route['category/create'] = "category/create";
$route['category/update(:num)'] = "category/update/$1";
$route['category/edit/(:num)'] = "category/edit/$1";
$route['category/delete/(:num)'] = "category/delete/$1";
$route['category/change_action/(:num)/(:any)'] = "category/active_inactive/$1/$2";

$route['options'] = "options";
$route['options/create'] = "options/create";
$route['options/update(:num)'] = "options/update/$1";
$route['options/edit/(:num)'] = "options/edit/$1";
$route['options/delete/(:num)'] = "options/delete/$1";
$route['options/change_action/(:num)/(:any)'] = "options/active_inactive/$1/$2";

$route['product'] = "product";
$route['product/create'] = "product/create";
$route['product/update(:num)'] = "product/update/$1";
$route['product/edit/(:num)'] = "product/edit/$1";
$route['product/delete/(:any)'] = "product/delete/$1";
$route['product/change_action/(:num)/(:any)'] = "product/active_inactive/$1/$2";



