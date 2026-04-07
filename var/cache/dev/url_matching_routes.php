<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_wdt/styles' => [[['_route' => '_wdt_stylesheet', '_controller' => 'web_profiler.controller.profiler::toolbarStylesheetAction'], null, null, null, false, false, null]],
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/xdebug' => [[['_route' => '_profiler_xdebug', '_controller' => 'web_profiler.controller.profiler::xdebugAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/api/v2/auth/login' => [[['_route' => 'api_revit_login', '_controller' => 'App\\Controller\\API\\RevitAPIController::login'], null, ['POST' => 0], null, false, false, null]],
        '/api/v2/projects' => [[['_route' => 'api_revit_create_project', '_controller' => 'App\\Controller\\API\\RevitAPIController::createProject'], null, ['POST' => 0], null, false, false, null]],
        '/apu' => [[['_route' => 'app_apu_index', '_controller' => 'App\\Controller\\APUController::index'], null, null, null, true, false, null]],
        '/apu/create' => [[['_route' => 'app_apu_create', '_controller' => 'App\\Controller\\APUController::create'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/admin' => [[['_route' => 'app_admin', '_controller' => 'App\\Controller\\AdminController::index'], null, null, null, false, false, null]],
        '/admin/users' => [[['_route' => 'app_admin_users', '_controller' => 'App\\Controller\\AdminController::users'], null, null, null, false, false, null]],
        '/admin/users/create' => [[['_route' => 'app_admin_users_create', '_controller' => 'App\\Controller\\AdminController::createUser'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/admin/logs' => [[['_route' => 'app_admin_logs', '_controller' => 'App\\Controller\\AdminController::logs'], null, null, null, false, false, null]],
        '/admin/tenant' => [[['_route' => 'app_admin_tenant', '_controller' => 'App\\Controller\\AdminController::tenantSettings'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/' => [[['_route' => 'app_dashboard', '_controller' => 'App\\Controller\\DashboardController::index'], null, null, null, false, false, null]],
        '/dashboard' => [[['_route' => 'app_dashboard_alt', '_controller' => 'App\\Controller\\DashboardController::index'], null, null, null, false, false, null]],
        '/favicon.ico' => [[['_route' => 'app_favicon', '_controller' => 'App\\Controller\\FaviconController::favicon'], null, null, null, false, false, null]],
        '/password/forgot' => [[['_route' => 'app_password_forgot', '_controller' => 'App\\Controller\\PasswordResetController::forgotPassword'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/profile' => [[['_route' => 'app_profile', '_controller' => 'App\\Controller\\ProfileController::index'], null, null, null, false, false, null]],
        '/profile/edit' => [[['_route' => 'app_profile_edit', '_controller' => 'App\\Controller\\ProfileController::edit'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/profile/change-password' => [[['_route' => 'app_profile_change_password', '_controller' => 'App\\Controller\\ProfileController::changePassword'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/profile/preferences' => [[['_route' => 'app_profile_preferences', '_controller' => 'App\\Controller\\ProfileController::preferences'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/profile/reset-theme' => [[['_route' => 'app_profile_reset_theme', '_controller' => 'App\\Controller\\ProfileController::resetTheme'], null, ['POST' => 0], null, false, false, null]],
        '/revit/upload' => [[['_route' => 'app_revit_upload', '_controller' => 'App\\Controller\\RevitUploadController::upload'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/revit/files' => [[['_route' => 'app_revit_files', '_controller' => 'App\\Controller\\RevitUploadController::listFiles'], null, ['GET' => 0], null, false, false, null]],
        '/login' => [[['_route' => 'app_login', '_controller' => 'App\\Controller\\SecurityController::login'], null, null, null, false, false, null]],
        '/logout' => [[['_route' => 'app_logout', '_controller' => 'App\\Controller\\SecurityController::logout'], null, null, null, false, false, null]],
        '/2fa/verify' => [[['_route' => 'app_2fa_verify', '_controller' => 'App\\Controller\\SecurityController::verify2FA'], null, null, null, false, false, null]],
        '/2fa/setup' => [[['_route' => 'app_2fa_setup', '_controller' => 'App\\Controller\\SecurityController::setup2FA'], null, null, null, false, false, null]],
        '/security' => [[['_route' => 'app_security', '_controller' => 'App\\Controller\\SecuritySettingsController::index'], null, null, null, false, false, null]],
        '/security/2fa/enable' => [[['_route' => 'app_security_2fa_enable', '_controller' => 'App\\Controller\\SecuritySettingsController::enable2FA'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/security/2fa/disable' => [[['_route' => 'app_security_2fa_disable', '_controller' => 'App\\Controller\\SecuritySettingsController::disable2FA'], null, ['POST' => 0], null, false, false, null]],
        '/security/2fa/recovery-codes' => [[['_route' => 'app_security_2fa_recovery_codes', '_controller' => 'App\\Controller\\SecuritySettingsController::showRecoveryCodes'], null, null, null, false, false, null]],
        '/system' => [[['_route' => 'app_system', '_controller' => 'App\\Controller\\SystemController::index'], null, null, null, false, false, null]],
        '/system/monitoring' => [[['_route' => 'app_system_monitoring', '_controller' => 'App\\Controller\\SystemController::monitoring'], null, null, null, false, false, null]],
        '/system/errors' => [[['_route' => 'app_system_errors', '_controller' => 'App\\Controller\\SystemController::errors'], null, null, null, false, false, null]],
        '/system/alerts' => [[['_route' => 'app_system_alerts', '_controller' => 'App\\Controller\\SystemController::alerts'], null, null, null, false, false, null]],
        '/system/tenants' => [[['_route' => 'app_system_tenants', '_controller' => 'App\\Controller\\SystemController::tenants'], null, null, null, false, false, null]],
        '/system/tenants/create' => [[['_route' => 'app_system_tenants_create', '_controller' => 'App\\Controller\\SystemController::createTenant'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/test/logs' => [[['_route' => 'app_test_logs', '_controller' => 'App\\Controller\\TestController::testLogs'], null, null, null, false, false, null]],
        '/test/error' => [[['_route' => 'app_test_error', '_controller' => 'App\\Controller\\TestController::testError'], null, null, null, false, false, null]],
        '/test/mail' => [[['_route' => 'app_test_mail', '_controller' => 'App\\Controller\\TestController::testMail'], null, null, null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/(?'
                        .'|font/([^/\\.]++)\\.woff2(*:98)'
                        .'|([^/]++)(?'
                            .'|/(?'
                                .'|search/results(*:134)'
                                .'|router(*:148)'
                                .'|exception(?'
                                    .'|(*:168)'
                                    .'|\\.css(*:181)'
                                .')'
                            .')'
                            .'|(*:191)'
                        .')'
                    .')'
                .')'
                .'|/a(?'
                    .'|p(?'
                        .'|i/v2/projects/([^/]++)/(?'
                            .'|elements(*:245)'
                            .'|calculations(*:265)'
                        .')'
                        .'|u/([^/]++)/e(?'
                            .'|dit(*:292)'
                            .'|xport/excel(*:311)'
                        .')'
                    .')'
                    .'|dmin/users/([^/]++)/(?'
                        .'|edit(*:348)'
                        .'|toggle(*:362)'
                    .')'
                .')'
                .'|/password/reset/([^/]++)(*:396)'
                .'|/revit/file/([^/]++)(?'
                    .'|(*:427)'
                    .'|/(?'
                        .'|delete(*:445)'
                        .'|reprocess(*:462)'
                    .')'
                .')'
                .'|/s(?'
                    .'|ecurity/sessions/([^/]++)/revoke(*:509)'
                    .'|ystem/tenants/([^/]++)/edit(*:544)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        98 => [[['_route' => '_profiler_font', '_controller' => 'web_profiler.controller.profiler::fontAction'], ['fontName'], null, null, false, false, null]],
        134 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        148 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        168 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        181 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        191 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        245 => [[['_route' => 'api_revit_send_elements', '_controller' => 'App\\Controller\\API\\RevitAPIController::sendElements'], ['projectId'], ['POST' => 0], null, false, false, null]],
        265 => [[['_route' => 'api_revit_get_calculations', '_controller' => 'App\\Controller\\API\\RevitAPIController::getCalculations'], ['projectId'], ['GET' => 0], null, false, false, null]],
        292 => [[['_route' => 'app_apu_edit', '_controller' => 'App\\Controller\\APUController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        311 => [[['_route' => 'app_apu_export_excel', '_controller' => 'App\\Controller\\APUController::exportExcel'], ['id'], null, null, false, false, null]],
        348 => [[['_route' => 'app_admin_users_edit', '_controller' => 'App\\Controller\\AdminController::editUser'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        362 => [[['_route' => 'app_admin_users_toggle', '_controller' => 'App\\Controller\\AdminController::toggleUser'], ['id'], ['POST' => 0], null, false, false, null]],
        396 => [[['_route' => 'app_password_reset', '_controller' => 'App\\Controller\\PasswordResetController::resetPassword'], ['token'], ['GET' => 0, 'POST' => 1], null, false, true, null]],
        427 => [[['_route' => 'app_revit_file_detail', '_controller' => 'App\\Controller\\RevitUploadController::fileDetail'], ['id'], ['GET' => 0], null, false, true, null]],
        445 => [[['_route' => 'app_revit_file_delete', '_controller' => 'App\\Controller\\RevitUploadController::deleteFile'], ['id'], ['POST' => 0], null, false, false, null]],
        462 => [[['_route' => 'app_revit_file_reprocess', '_controller' => 'App\\Controller\\RevitUploadController::reprocessFile'], ['id'], ['POST' => 0], null, false, false, null]],
        509 => [[['_route' => 'app_security_session_revoke', '_controller' => 'App\\Controller\\SecuritySettingsController::revokeSession'], ['id'], ['POST' => 0], null, false, false, null]],
        544 => [
            [['_route' => 'app_system_tenants_edit', '_controller' => 'App\\Controller\\SystemController::editTenant'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
