<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('Modules\Admin\Controllers');
$routes->setDefaultController('Admin');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->add('/', 'Admin::index');
$routes->add('/admin', 'Admin::index',['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/dashboard', 'Admin::dashboard', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/login', 'Admin::index',['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/logout', 'Admin::logout',['namespace' => 'Modules\Admin\Controllers']);

//Admin Common Routes  
$routes->add('/admin/activate_inactivate', 'Admin::activate_inactivate', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/delete', 'Admin::delete', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/delete_all', 'Admin::delete_all', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/active_inactive_all', 'Admin::active_inactive_all', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/changerowpriority', 'Admin::changerowpriority', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/common_form_validation', 'Admin::common_form_validation', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/common_edit_form_validation', 'Admin::common_edit_form_validation', ['namespace' => 'Modules\Admin\Controllers']);

//Roles Routes
$routes->add('/admin/roles', 'Roles::index', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/active_roles', 'Roles::active_roles', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/inactive_roles', 'Roles::inactive_roles', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/roles/add_role', 'Roles::add_role', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/roles/edit_role/(:num)', 'Roles::edit_role/$1', ['namespace' => 'Modules\Admin\Controllers']);

// Shifts Routes
$routes->add('/admin/shifts', 'Shift::index', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/active_shifts', 'Shift::active_shifts', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/inactive_shifts', 'Shift::inactive_shifts', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/shifts/add_shift', 'Shift::add_shift', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/shifts/edit_shift/(:num)', 'Shift::edit_shift/$1', ['namespace' => 'Modules\Admin\Controllers']);

// Organization Type Routes
$routes->add('/admin/organization_types', 'OrganizationType::index', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/active_organization_types', 'OrganizationType::active_organization_types', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/inactive_organization_types', 'OrganizationType::inactive_organization_types', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/organization_types/add_organization_type', 'OrganizationType::add_organization_type', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/organization_types/edit_organization_type/(:num)', 'OrganizationType::edit_organization_type/$1', ['namespace' => 'Modules\Admin\Controllers']);

// Organization Routes
$routes->add('/admin/organizations', 'Organization::index', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/active_organizations', 'Organization::active_organizations', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/inactive_organizations', 'Organization::inactive_organizations', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/organizations/add_organization', 'Organization::add_organization', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/organizations/edit_organization/(:num)', 'Organization::edit_organization/$1', ['namespace' => 'Modules\Admin\Controllers']);

// Branches Routes
$routes->add('/admin/branches', 'Branch::index', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/active_branches', 'Branch::active_branches', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/inactive_branches', 'Branch::inactive_branches', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/branches/add_branch', 'Branch::add_branch', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/branches/edit_branch/(:num)', 'Branch::edit_branch/$1', ['namespace' => 'Modules\Admin\Controllers']);

//departments Routes
$routes->add('/admin/departments', 'Departments::index', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/active_departments', 'Departments::active_departments', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/inactive_departments', 'Departments::inactive_departments', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/departments/add_department', 'Departments::add_department', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/departments/edit_department/(:num)', 'Departments::edit_department/$1', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/departments/departmentsajax', 'Departments::departmentsajax', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/departments/updatedepartmentsajax', 'Departments::updatedepartmentsajax', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/departments/getbranches', 'Departments::getbranches', ['namespace' => 'Modules\Admin\Controllers']);


// Buildings Routes
$routes->add('/admin/buildings', 'Building::index', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/active_buildings', 'Building::active_buildings', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/inactive_buildings', 'Building::inactive_buildings', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/buildings/add_building', 'Building::add_building', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/buildings/edit_building/(:num)', 'Building::edit_building/$1', ['namespace' => 'Modules\Admin\Controllers']);

// floors Routes
$routes->add('/admin/floors', 'Floor::index', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/active_floors', 'Floor::active_floors', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/inactive_floors', 'Floor::inactive_floors', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/floors/add_floor', 'Floor::add_floor', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/floors/edit_floor/(:num)', 'Floor::edit_floor/$1', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/floors/getbuildings', 'Floor::getbuildings', ['namespace' => 'Modules\Admin\Controllers']);

// rooms Routes
$routes->add('/admin/rooms', 'Room::index', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/active_rooms', 'Room::active_rooms', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/inactive_rooms', 'Room::inactive_rooms', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/rooms/add_room', 'Room::add_room', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/rooms/edit_room/(:num)', 'Room::edit_room/$1', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/rooms/getbuildings', 'Room::getbuildings', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/rooms/getfloors', 'Room::getfloors', ['namespace' => 'Modules\Admin\Controllers']);


// Employees Routes
$routes->add('/admin/employees', 'Employee::index', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/active_employees', 'Employee::active_employees', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/inactive_employees', 'Employee::inactive_employees', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/employees/add_employee', 'Employee::add_employee', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/employees/edit_employee/(:num)', 'Employee::edit_employee/$1', ['namespace' => 'Modules\Admin\Controllers']);

// Cities Routes
$routes->add('/admin/cities', 'City::index', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/active_cities', 'City::active_cities', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/inactive_cities', 'City::inactive_cities', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/cities/add_city', 'City::add_city', ['namespace' => 'Modules\Admin\Controllers']);
$routes->add('/admin/cities/edit_city/(:num)', 'City::edit_city/$1', ['namespace' => 'Modules\Admin\Controllers']);


/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
