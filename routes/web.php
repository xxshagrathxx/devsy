<?php

use App\Http\Controllers\core\AuthController;
use App\Http\Controllers\core\PermissionController;
use App\Http\Controllers\core\ProfileController;
use App\Http\Controllers\core\RoleController;
use App\Http\Controllers\core\SettingsController;
use App\Http\Controllers\core\TranslateController;
use App\Http\Controllers\core\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ 
        
        $controller_path = 'App\Http\Controllers';

        // Main Page Route
        // Route::get('/', $controller_path . '\dashboard\Analytics@index')->name('dashboard-analytics');
        
        // layout
        Route::get('/layouts/without-menu', $controller_path . '\layouts\WithoutMenu@index')->name('layouts-without-menu');
        Route::get('/layouts/without-navbar', $controller_path . '\layouts\WithoutNavbar@index')->name('layouts-without-navbar');
        Route::get('/layouts/fluid', $controller_path . '\layouts\Fluid@index')->name('layouts-fluid');
        Route::get('/layouts/container', $controller_path . '\layouts\Container@index')->name('layouts-container');
        Route::get('/layouts/blank', $controller_path . '\layouts\Blank@index')->name('layouts-blank');
        
        // pages
        Route::get('/pages/account-settings-account', $controller_path . '\pages\AccountSettingsAccount@index')->name('pages-account-settings-account');
        Route::get('/pages/account-settings-notifications', $controller_path . '\pages\AccountSettingsNotifications@index')->name('pages-account-settings-notifications');
        Route::get('/pages/account-settings-connections', $controller_path . '\pages\AccountSettingsConnections@index')->name('pages-account-settings-connections');
        Route::get('/pages/misc-error', $controller_path . '\pages\MiscError@index')->name('pages-misc-error');
        Route::get('/pages/misc-under-maintenance', $controller_path . '\pages\MiscUnderMaintenance@index')->name('pages-misc-under-maintenance');
        
        // authentication
        Route::get('/auth/login-basic', $controller_path . '\authentications\LoginBasic@index')->name('auth-login-basic');
        Route::get('/auth/register-basic', $controller_path . '\authentications\RegisterBasic@index')->name('auth-register-basic');
        Route::get('/auth/forgot-password-basic', $controller_path . '\authentications\ForgotPasswordBasic@index')->name('auth-reset-password-basic');
        
        // cards
        Route::get('/cards/basic', $controller_path . '\cards\CardBasic@index')->name('cards-basic');
        
        // User Interface
        Route::get('/ui/accordion', $controller_path . '\user_interface\Accordion@index')->name('ui-accordion');
        Route::get('/ui/alerts', $controller_path . '\user_interface\Alerts@index')->name('ui-alerts');
        Route::get('/ui/badges', $controller_path . '\user_interface\Badges@index')->name('ui-badges');
        Route::get('/ui/buttons', $controller_path . '\user_interface\Buttons@index')->name('ui-buttons');
        Route::get('/ui/carousel', $controller_path . '\user_interface\Carousel@index')->name('ui-carousel');
        Route::get('/ui/collapse', $controller_path . '\user_interface\Collapse@index')->name('ui-collapse');
        Route::get('/ui/dropdowns', $controller_path . '\user_interface\Dropdowns@index')->name('ui-dropdowns');
        Route::get('/ui/footer', $controller_path . '\user_interface\Footer@index')->name('ui-footer');
        Route::get('/ui/list-groups', $controller_path . '\user_interface\ListGroups@index')->name('ui-list-groups');
        Route::get('/ui/modals', $controller_path . '\user_interface\Modals@index')->name('ui-modals');
        Route::get('/ui/navbar', $controller_path . '\user_interface\Navbar@index')->name('ui-navbar');
        Route::get('/ui/offcanvas', $controller_path . '\user_interface\Offcanvas@index')->name('ui-offcanvas');
        Route::get('/ui/pagination-breadcrumbs', $controller_path . '\user_interface\PaginationBreadcrumbs@index')->name('ui-pagination-breadcrumbs');
        Route::get('/ui/progress', $controller_path . '\user_interface\Progress@index')->name('ui-progress');
        Route::get('/ui/spinners', $controller_path . '\user_interface\Spinners@index')->name('ui-spinners');
        Route::get('/ui/tabs-pills', $controller_path . '\user_interface\TabsPills@index')->name('ui-tabs-pills');
        Route::get('/ui/toasts', $controller_path . '\user_interface\Toasts@index')->name('ui-toasts');
        Route::get('/ui/tooltips-popovers', $controller_path . '\user_interface\TooltipsPopovers@index')->name('ui-tooltips-popovers');
        Route::get('/ui/typography', $controller_path . '\user_interface\Typography@index')->name('ui-typography');
        
        // extended ui
        Route::get('/extended/ui-perfect-scrollbar', $controller_path . '\extended_ui\PerfectScrollbar@index')->name('extended-ui-perfect-scrollbar');
        Route::get('/extended/ui-text-divider', $controller_path . '\extended_ui\TextDivider@index')->name('extended-ui-text-divider');
        
        // icons
        Route::get('/icons/boxicons', $controller_path . '\icons\Boxicons@index')->name('icons-boxicons');
        
        // form elements
        Route::get('/forms/basic-inputs', $controller_path . '\form_elements\BasicInput@index')->name('forms-basic-inputs');
        Route::get('/forms/input-groups', $controller_path . '\form_elements\InputGroups@index')->name('forms-input-groups');
        
        // form layouts
        Route::get('/form/layouts-vertical', $controller_path . '\form_layouts\VerticalForm@index')->name('form-layouts-vertical');
        Route::get('/form/layouts-horizontal', $controller_path . '\form_layouts\HorizontalForm@index')->name('form-layouts-horizontal');
        
        // tables
        Route::get('/tables/basic', $controller_path . '\tables\Basic@index')->name('tables-basic');

        // Login
            Route::get('login', [AuthController::class, 'index'])->name('login');
            Route::post('login-check', [AuthController::class, 'loginCheck'])->name('login.check'); 
        // ./Login

        Route::middleware('auth')->group(function() {
            // Authentication
                Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard'); 
                // Route::get('registration', [AuthController::class, 'registration'])->name('register-user');
                // Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom'); 
                Route::get('signout', [AuthController::class, 'signOut'])->name('signout');
                // Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
            // ./Authentication

            Route::prefix('/users')->middleware('role_or_permission:show_users|show_roles')->group(function() {
                // Users
                    Route::prefix('/users')->middleware('role_or_permission:show_users')->group(function() {
                        Route::get('/all', [UserController::class, 'index'])->middleware('permission:show_users')->name('users-users-all');
                        Route::get('/create', [UserController::class, 'create'])->middleware('permission:create_users')->name('users-users-create');
                        Route::post('/store', [UserController::class, 'store'])->middleware('permission:create_users')->name('users-users-store');
                        Route::get('/show/{id}', [UserController::class, 'show'])->middleware('permission:show_users')->name('users-users-show');
                        Route::get('/edit/{id}', [UserController::class, 'edit'])->middleware('permission:update_users')->name('users-users-edit');
                        Route::post('/update/{id}', [UserController::class, 'update'])->middleware('permission:update_users')->name('users-users-update');
                        Route::get('/delete/{id}', [UserController::class, 'destroy'])->middleware('permission:delete_users')->name('users-users-delete');
                    });
                // ./Users

                // Roles
                    Route::prefix('/roles')->middleware('role_or_permission:show_roles')->group(function() {
                        Route::get('/all', [RoleController::class, 'index'])->middleware('permission:show_roles')->name('users-roles-all');
                        Route::get('/create', [RoleController::class, 'create'])->middleware('permission:create_roles')->name('users-roles-create');
                        Route::post('/store', [RoleController::class, 'store'])->middleware('permission:create_roles')->name('users-roles-store');
                        Route::get('/edit/{id}', [RoleController::class, 'edit'])->middleware('permission:update_roles')->name('users-roles-edit');
                        Route::post('/update/{id}', [RoleController::class, 'update'])->middleware('permission:update_roles')->name('users-roles-update');
                        Route::get('/delete/{id}', [RoleController::class, 'destroy'])->middleware('permission:delete_roles')->name('users-roles-delete');

                        Route::get('/edit/assign-permissions/{id}', [RoleController::class, 'assignPermissions'])->middleware('permission:assign_permissions')->name('users-roles-edit-assign-permissions');
                        Route::post('/update/permissions/sync', [RoleController::class, 'assignPermissionsUpdate'])->middleware('permission:update_permissions')->name('users-roles-update-assign-permissions');
                    });
                // ./Roles
            });

            // Pages

                // Translates
                Route::prefix('/translates')->middleware('arabicOnly', 'permission:show_translates')->group(function() {
                    Route::post('/store', [TranslateController::class, 'store'])->middleware('permission:create_translates')->name('translates-store');
                    Route::post('/update', [TranslateController::class, 'update'])->middleware('permission:update_translates')->name('translates-update');
                    Route::get('/edit', [TranslateController::class, 'edit'])->middleware('permission:update_translates')->name('translates-edit');
                    Route::get('/delete/{id}', [TranslateController::class, 'destroy'])->middleware('permission:delete_translates')->name('translates-delete');
                });
                // ./Translates

                // Profile
                    Route::prefix('/profile')->group(function() {
                        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile-edit');
                        Route::post('/update', [ProfileController::class, 'update'])->name('profile-update');
                    });
                // ./Profile

                // Settings
                Route::prefix('/settings')->middleware('permission:update_settings')->group(function() {
                        Route::get('/edit', [SettingsController::class, 'edit'])->name('settings-edit');
                        Route::post('/update', [SettingsController::class, 'update'])->name('settings-update');
                    });
                // ./Settings

            // ./Pages
        });
    });


