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
        '/cron/run' => [[['_route' => 'cron_run', '_controller' => 'App\\Controller\\CronController::run'], null, ['POST' => 0], null, false, false, null]],
        '/' => [[['_route' => 'app_dashboard', '_controller' => 'App\\Controller\\DashboardController::index'], null, null, null, false, false, null]],
        '/dashboard' => [[['_route' => 'app_dashboard_alt', '_controller' => 'App\\Controller\\DashboardController::index'], null, null, null, false, false, null]],
        '/__trigger_error_for_test' => [[['_route' => 'app_trigger_error_for_test', '_controller' => 'App\\Controller\\DevErrorController::trigger'], null, null, null, false, false, null]],
        '/favicon.ico' => [[['_route' => 'app_favicon', '_controller' => 'App\\Controller\\FaviconController::favicon'], null, null, null, false, false, null]],
        '/items' => [[['_route' => 'app_item_index', '_controller' => 'App\\Controller\\ItemController::index'], null, null, null, true, false, null]],
        '/items/create' => [[['_route' => 'app_item_create', '_controller' => 'App\\Controller\\ItemController::create'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/password/forgot' => [[['_route' => 'app_password_forgot', '_controller' => 'App\\Controller\\PasswordResetController::forgotPassword'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/profile' => [[['_route' => 'app_profile', '_controller' => 'App\\Controller\\ProfileController::index'], null, null, null, false, false, null]],
        '/profile/edit' => [[['_route' => 'app_profile_edit', '_controller' => 'App\\Controller\\ProfileController::edit'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/profile/change-password' => [[['_route' => 'app_profile_change_password', '_controller' => 'App\\Controller\\ProfileController::changePassword'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/profile/preferences' => [[['_route' => 'app_profile_preferences', '_controller' => 'App\\Controller\\ProfileController::preferences'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/profile/reset-theme' => [[['_route' => 'app_profile_reset_theme', '_controller' => 'App\\Controller\\ProfileController::resetTheme'], null, ['POST' => 0], null, false, false, null]],
        '/projects' => [[['_route' => 'app_project_index', '_controller' => 'App\\Controller\\ProjectController::index'], null, null, null, true, false, null]],
        '/projects/create' => [[['_route' => 'app_project_create', '_controller' => 'App\\Controller\\ProjectController::create'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/revit/upload' => [[['_route' => 'app_revit_upload', '_controller' => 'App\\Controller\\RevitUploadController::upload'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/revit/files' => [[['_route' => 'app_revit_files', '_controller' => 'App\\Controller\\RevitUploadController::listFiles'], null, ['GET' => 0], null, false, false, null]],
        '/login' => [[['_route' => 'app_login', '_controller' => 'App\\Controller\\SecurityController::login'], null, null, null, false, false, null]],
        '/logout' => [[['_route' => 'app_logout', '_controller' => 'App\\Controller\\SecurityController::logout'], null, null, null, false, false, null]],
        '/2fa/verify' => [[['_route' => 'app_2fa_verify', '_controller' => 'App\\Controller\\SecurityController::verify2FA'], null, null, null, false, false, null]],
        '/superadmin/verify-email' => [[['_route' => 'app_superadmin_verify_email', '_controller' => 'App\\Controller\\SecurityController::verifySuperAdminEmail'], null, null, null, false, false, null]],
        '/2fa/setup' => [[['_route' => 'app_2fa_setup', '_controller' => 'App\\Controller\\SecurityController::setup2FA'], null, null, null, false, false, null]],
        '/security' => [[['_route' => 'app_security', '_controller' => 'App\\Controller\\SecuritySettingsController::index'], null, null, null, false, false, null]],
        '/security/2fa/enable' => [[['_route' => 'app_security_2fa_enable', '_controller' => 'App\\Controller\\SecuritySettingsController::enable2FA'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/security/2fa/disable' => [[['_route' => 'app_security_2fa_disable', '_controller' => 'App\\Controller\\SecuritySettingsController::disable2FA'], null, ['POST' => 0], null, false, false, null]],
        '/security/2fa/recovery-codes' => [[['_route' => 'app_security_2fa_recovery_codes', '_controller' => 'App\\Controller\\SecuritySettingsController::showRecoveryCodes'], null, null, null, false, false, null]],
        '/security/2fa/recovery-codes/regenerate' => [[['_route' => 'app_security_2fa_recovery_codes_regenerate', '_controller' => 'App\\Controller\\SecuritySettingsController::regenerateRecoveryCodes'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/system' => [[['_route' => 'app_system', '_controller' => 'App\\Controller\\SystemController::index'], null, null, null, false, false, null]],
        '/system/monitoring' => [[['_route' => 'app_system_monitoring', '_controller' => 'App\\Controller\\SystemController::monitoring'], null, null, null, false, false, null]],
        '/system/errors' => [[['_route' => 'app_system_errors', '_controller' => 'App\\Controller\\SystemController::errors'], null, null, null, false, false, null]],
        '/system/alerts' => [[['_route' => 'app_system_alerts', '_controller' => 'App\\Controller\\SystemController::alerts'], null, null, null, false, false, null]],
        '/system/tenants' => [[['_route' => 'app_system_tenants', '_controller' => 'App\\Controller\\SystemController::tenants'], null, null, null, false, false, null]],
        '/system/tenants/create' => [[['_route' => 'app_system_tenants_create', '_controller' => 'App\\Controller\\SystemController::createTenant'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/test/logs' => [[['_route' => 'app_test_logs', '_controller' => 'App\\Controller\\TestController::testLogs'], null, null, null, false, false, null]],
        '/test/error' => [[['_route' => 'app_test_error', '_controller' => 'App\\Controller\\TestController::testError'], null, null, null, false, false, null]],
        '/test/mail' => [[['_route' => 'app_test_mail', '_controller' => 'App\\Controller\\TestController::testMail'], null, null, null, false, false, null]],
        '/webauthn/credentials' => [[['_route' => 'webauthn_list', '_controller' => 'App\\Controller\\WebAuthnController::listCredentials'], null, null, null, false, false, null]],
        '/webauthn/register/start' => [[['_route' => 'webauthn_register_start', '_controller' => 'App\\Controller\\WebAuthnController::startRegistration'], null, ['POST' => 0], null, false, false, null]],
        '/webauthn/register/finish' => [[['_route' => 'webauthn_register_finish', '_controller' => 'App\\Controller\\WebAuthnController::finishRegistration'], null, ['POST' => 0], null, false, false, null]],
        '/webauthn/login/start' => [[['_route' => 'webauthn_login_start', '_controller' => 'App\\Controller\\WebAuthnController::startLogin'], null, ['POST' => 0], null, false, false, null]],
        '/webauthn/login/finish' => [[['_route' => 'webauthn_login_finish', '_controller' => 'App\\Controller\\WebAuthnController::finishLogin'], null, ['POST' => 0], null, false, false, null]],
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
                        .'|u/(?'
                            .'|([^/]++)/e(?'
                                .'|dit(*:295)'
                                .'|xport/excel(*:314)'
                            .')'
                            .'|create\\-for\\-rubro/(\\d+)(*:347)'
                        .')'
                    .')'
                    .'|dmin/users/([^/]++)/(?'
                        .'|edit(*:384)'
                        .'|toggle(*:398)'
                    .')'
                .')'
                .'|/uploads/avatars/([^/]++)(*:433)'
                .'|/items/(?'
                    .'|(\\d+)/edit(*:461)'
                    .'|(\\d+)/delete(*:481)'
                .')'
                .'|/s(?'
                    .'|e(?'
                        .'|t\\-locale/([^/]++)(*:517)'
                        .'|curity/sessions/([^/]++)/revoke(*:556)'
                    .')'
                    .'|ystem/tenants/([^/]++)/edit(*:592)'
                .')'
                .'|/p(?'
                    .'|assword/reset/([^/]++)(*:628)'
                    .'|rojects/(?'
                        .'|(\\d+)(*:652)'
                        .'|(\\d+)/edit(*:670)'
                        .'|(\\d+)/delete(*:690)'
                        .'|(\\d+)/duplicate(*:713)'
                        .'|([^/]++)/templates(?'
                            .'|(*:742)'
                            .'|/(?'
                                .'|create(*:760)'
                                .'|(\\d+)(*:773)'
                                .'|(\\d+)/edit(*:791)'
                                .'|(\\d+)/add\\-item(*:814)'
                                .'|(\\d+)/remove\\-item/(\\d+)(*:846)'
                                .'|(\\d+)/duplicate(*:869)'
                                .'|(\\d+)/delete(*:889)'
                            .')'
                        .')'
                    .')'
                .')'
                .'|/re(?'
                    .'|ports/project/(?'
                        .'|(\\d+)/plantilla/(\\d+)(*:945)'
                        .'|(\\d+)/plantilla/(\\d+)/pdf(*:978)'
                        .'|(\\d+)/plantilla/(\\d+)/excel(*:1013)'
                        .'|(\\d+)/full(*:1032)'
                        .'|(\\d+)/full/pdf(*:1055)'
                        .'|(\\d+)/full/excel(*:1080)'
                    .')'
                    .'|vit/file/([^/]++)(?'
                        .'|(*:1110)'
                        .'|/(?'
                            .'|delete(*:1129)'
                            .'|reprocess(*:1147)'
                        .')'
                    .')'
                .')'
                .'|/webauthn/revoke/([^/]++)(*:1184)'
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
        295 => [[['_route' => 'app_apu_edit', '_controller' => 'App\\Controller\\APUController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        314 => [[['_route' => 'app_apu_export_excel', '_controller' => 'App\\Controller\\APUController::exportExcel'], ['id'], null, null, false, false, null]],
        347 => [[['_route' => 'app_apu_create_for_rubro', '_controller' => 'App\\Controller\\APUController::createForRubro'], ['plantillaRubroId'], ['GET' => 0, 'POST' => 1], null, false, true, null]],
        384 => [[['_route' => 'app_admin_users_edit', '_controller' => 'App\\Controller\\AdminController::editUser'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        398 => [[['_route' => 'app_admin_users_toggle', '_controller' => 'App\\Controller\\AdminController::toggleUser'], ['id'], ['POST' => 0], null, false, false, null]],
        433 => [[['_route' => 'avatar_serve', '_controller' => 'App\\Controller\\AvatarController::serve'], ['filename'], ['GET' => 0], null, false, true, null]],
        461 => [[['_route' => 'app_item_edit', '_controller' => 'App\\Controller\\ItemController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        481 => [[['_route' => 'app_item_delete', '_controller' => 'App\\Controller\\ItemController::delete'], ['id'], ['POST' => 0], null, false, false, null]],
        517 => [[['_route' => 'app_set_locale', '_controller' => 'App\\Controller\\LocaleController::setLocale'], ['locale'], null, null, false, true, null]],
        556 => [[['_route' => 'app_security_session_revoke', '_controller' => 'App\\Controller\\SecuritySettingsController::revokeSession'], ['id'], ['POST' => 0], null, false, false, null]],
        592 => [[['_route' => 'app_system_tenants_edit', '_controller' => 'App\\Controller\\SystemController::editTenant'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        628 => [[['_route' => 'app_password_reset', '_controller' => 'App\\Controller\\PasswordResetController::resetPassword'], ['token'], ['GET' => 0, 'POST' => 1], null, false, true, null]],
        652 => [[['_route' => 'app_project_show', '_controller' => 'App\\Controller\\ProjectController::show'], ['id'], null, null, false, true, null]],
        670 => [[['_route' => 'app_project_edit', '_controller' => 'App\\Controller\\ProjectController::edit'], ['id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        690 => [[['_route' => 'app_project_delete', '_controller' => 'App\\Controller\\ProjectController::delete'], ['id'], ['POST' => 0], null, false, false, null]],
        713 => [[['_route' => 'app_project_duplicate', '_controller' => 'App\\Controller\\ProjectController::duplicate'], ['id'], ['POST' => 0], null, false, false, null]],
        742 => [[['_route' => 'app_template_index', '_controller' => 'App\\Controller\\TemplateController::index'], ['projectId'], null, null, true, false, null]],
        760 => [[['_route' => 'app_template_create', '_controller' => 'App\\Controller\\TemplateController::create'], ['projectId'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        773 => [[['_route' => 'app_template_show', '_controller' => 'App\\Controller\\TemplateController::show'], ['projectId', 'id'], null, null, false, true, null]],
        791 => [[['_route' => 'app_template_edit', '_controller' => 'App\\Controller\\TemplateController::edit'], ['projectId', 'id'], ['GET' => 0, 'POST' => 1], null, false, false, null]],
        814 => [[['_route' => 'app_template_add_item', '_controller' => 'App\\Controller\\TemplateController::addRubro'], ['projectId', 'id'], ['POST' => 0], null, false, false, null]],
        846 => [[['_route' => 'app_template_remove_item', '_controller' => 'App\\Controller\\TemplateController::removeRubro'], ['projectId', 'id', 'prId'], ['POST' => 0], null, false, true, null]],
        869 => [[['_route' => 'app_template_duplicate', '_controller' => 'App\\Controller\\TemplateController::duplicate'], ['projectId', 'id'], ['POST' => 0], null, false, false, null]],
        889 => [[['_route' => 'app_template_delete', '_controller' => 'App\\Controller\\TemplateController::delete'], ['projectId', 'id'], ['POST' => 0], null, false, false, null]],
        945 => [[['_route' => 'app_report_plantilla', '_controller' => 'App\\Controller\\ReportController::preview'], ['projectId', 'id'], null, null, false, true, null]],
        978 => [[['_route' => 'app_report_plantilla_pdf', '_controller' => 'App\\Controller\\ReportController::pdf'], ['projectId', 'id'], null, null, false, false, null]],
        1013 => [[['_route' => 'app_report_plantilla_excel', '_controller' => 'App\\Controller\\ReportController::excel'], ['projectId', 'id'], null, null, false, false, null]],
        1032 => [[['_route' => 'app_report_project_full', '_controller' => 'App\\Controller\\ReportController::projectFull'], ['id'], null, null, false, false, null]],
        1055 => [[['_route' => 'app_report_project_full_pdf', '_controller' => 'App\\Controller\\ReportController::projectFullPdf'], ['id'], null, null, false, false, null]],
        1080 => [[['_route' => 'app_report_project_full_excel', '_controller' => 'App\\Controller\\ReportController::projectFullExcel'], ['id'], null, null, false, false, null]],
        1110 => [[['_route' => 'app_revit_file_detail', '_controller' => 'App\\Controller\\RevitUploadController::fileDetail'], ['id'], ['GET' => 0], null, false, true, null]],
        1129 => [[['_route' => 'app_revit_file_delete', '_controller' => 'App\\Controller\\RevitUploadController::deleteFile'], ['id'], ['POST' => 0], null, false, false, null]],
        1147 => [[['_route' => 'app_revit_file_reprocess', '_controller' => 'App\\Controller\\RevitUploadController::reprocessFile'], ['id'], ['POST' => 0], null, false, false, null]],
        1184 => [
            [['_route' => 'webauthn_revoke', '_controller' => 'App\\Controller\\WebAuthnController::revoke'], ['id'], ['POST' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
