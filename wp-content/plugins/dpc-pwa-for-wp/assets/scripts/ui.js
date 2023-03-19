/******/
(function(modules) { // webpackBootstrap
    /******/ // The module cache
    /******/
    var installedModules = {};
    /******/
    /******/ // The require function
    /******/
    function __webpack_require__(moduleId) {
        /******/
        /******/ // Check if module is in cache
        /******/
        if (installedModules[moduleId]) {
            /******/
            return installedModules[moduleId].exports;
            /******/
        }
        /******/ // Create a new module (and put it into the cache)
        /******/
        var module = installedModules[moduleId] = {
            /******/
            i: moduleId,
            /******/
            l: false,
            /******/
            exports: {}
            /******/
        };
        /******/
        /******/ // Execute the module function
        /******/
        modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
        /******/
        /******/ // Flag the module as loaded
        /******/
        module.l = true;
        /******/
        /******/ // Return the exports of the module
        /******/
        return module.exports;
        /******/
    }
    /******/
    /******/
    /******/ // expose the modules object (__webpack_modules__)
    /******/
    __webpack_require__.m = modules;
    /******/
    /******/ // expose the module cache
    /******/
    __webpack_require__.c = installedModules;
    /******/
    /******/ // define getter function for harmony exports
    /******/
    __webpack_require__.d = function(exports, name, getter) {
        /******/
        if (!__webpack_require__.o(exports, name)) {
            /******/
            Object.defineProperty(exports, name, {
                /******/
                configurable: false,
                /******/
                enumerable: true,
                /******/
                get: getter
                /******/
            });
            /******/
        }
        /******/
    };
    /******/
    /******/ // getDefaultExport function for compatibility with non-harmony modules
    /******/
    __webpack_require__.n = function(module) {
        /******/
        var getter = module && module.__esModule ?
            /******/
            function getDefault() {
                return module['default'];
            } :
            /******/
            function getModuleExports() {
                return module;
            };
        /******/
        __webpack_require__.d(getter, 'a', getter);
        /******/
        return getter;
        /******/
    };
    /******/
    /******/ // Object.prototype.hasOwnProperty.call
    /******/
    __webpack_require__.o = function(object, property) {
        return Object.prototype.hasOwnProperty.call(object, property);
    };
    /******/
    /******/ // __webpack_public_path__
    /******/
    __webpack_require__.p = "";
    /******/
    /******/ // Load entry module and return exports
    /******/
    return __webpack_require__(__webpack_require__.s = 0);
    /******/
})
/************************************************************************/
/******/
([
    /* 0 */
    /***/
    (function(module, exports, __webpack_require__) {

        __webpack_require__(1);
        module.exports = __webpack_require__(2);


        /***/
    }),
    /* 1 */
    /***/
    (function(module, exports, __webpack_require__) {

        "use strict";


        (function($, vars) {

            var $body = $('body');
            var offlineClass = 'pwa-offline';

            function updateOnlineStatus(event) {
                if (navigator.onLine) {
                    $body.removeClass(offlineClass);
                } else {
                    $body.addClass(offlineClass);
                }
            }

            $(function() {
                updateOnlineStatus();
            });

            window.addEventListener('online', updateOnlineStatus);
            window.addEventListener('offline', updateOnlineStatus);
        })(jQuery, PwaJsVars);

        /***/
    }),
    /* 2 */
    /***/
    (function(module, exports, __webpack_require__) {

        "use strict";


        (function($, plugin) {

            var active = false;
            var $body = $('body');

            $(function() {

                $('a:not([href^="#"])').click(function(){
                    $body.addClass('pwa_page_transition_'+plugin['TransitionStyle']);
                    setTimeout(function(){ $body.removeClass('pwa_page_transition_'+plugin['TransitionStyle']); }, 2000);
                });
                setTimeout(function(){ $body.removeClass(plugin['TransitionStyle']); }, 1000);

                if ('serviceWorker' in navigator && 'PushManager' in window) {

                    navigator.serviceWorker.ready.then(function(registration) {

                        /**
                         * Show toggler (hidden by default)
                         */

                        $body.addClass('pwa-notification');

                        /**
                         * add trigger
                         */

                        var $toggler = $('#pwa-notification-button');
                        if ($toggler.length) {
                            $toggler.on('click', function() {
                                if (active) {
                                    deregisterPushDevice();
                                } else {
                                    registerPushDevice();
                                }
                            });
                        }

                        /**
                         * check if is already registered
                         */
                        var $loadnotify = $('#loadnotify');
                        registration.pushManager.getSubscription().then(function(subscription) {
                            if (subscription) {
                                changePushStatus(true);
                            }
                            if ($loadnotify.length && !subscription) {
                                registerPushDevice();
                            }
                        });
                    });
                }

                $(window).load(function() {
                    $("#splashscreen").fadeOut("slow");
                });
            });

            function changePushStatus(status) {
                active = status;
                $body.removeClass('pwa-notification--loader');
                if (status) {
                    $body.addClass('pwa-notification--on');
                } else {
                    $body.removeClass('pwa-notification--on');
                }
            }

            var registerPushDevice = function registerPushDevice() {
                $body.addClass('pwa-notification--loader');
                navigator.serviceWorker.ready.then(function(registration) {

                    registration.pushManager.subscribe({
                        userVisibleOnly: true
                    }).then(function(subscription) {
                        var subscription_id = subscription.endpoint.split('fcm/send/')[1];
                        handleSubscriptionID(subscription_id, 'add');
                        changePushStatus(true);
                        $.toast({
                            title: plugin['message_pushadd_success'],
                            duration: 2500,
                            position: 'bottom',
                        });
                    }).catch(function() {
                        changePushStatus(false);
                        $.toast({
                            title: plugin['message_pushadd_failed'],
                            duration: 2500,
                            position: 'bottom',
                        });
                    });
                });
            };

            var deregisterPushDevice = function deregisterPushDevice() {
                $body.addClass('pwa-notification--loader');
                navigator.serviceWorker.ready.then(function(registration) {
                    registration.pushManager.getSubscription().then(function(subscription) {
                        if (!subscription) {
                            return;
                        }
                        subscription.unsubscribe().then(function() {
                            var subscription_id = subscription.endpoint.split('fcm/send/')[1];
                            handleSubscriptionID(subscription_id, 'remove');
                            changePushStatus(false);
                            $.toast({
                                title: plugin['message_pushremove_success'],
                                duration: 2500,
                                position: 'bottom',
                            });
                        }).catch(function() {
                            changePushStatus(true);
                            $.toast({
                                title: plugin['message_pushremove_failed'],
                                duration: 2500,
                                position: 'bottom',
                            });
                        });
                    });
                });
            };

            function handleSubscriptionID(subscription_id, handle) {

                var client = new ClientJS();
                var clientData = {
                    'browser': {
                        'browser': client.getBrowser(),
                        'version': client.getBrowserVersion(),
                        'major': client.getBrowserMajorVersion()
                    },
                    'os': {
                        'os': client.getOS(),
                        'version': client.getOSVersion()
                    },
                    'device': {
                        'device': client.getDevice(),
                        'type': client.getDeviceType(),
                        'vendor': client.getDeviceVendor()
                    }
                };

                var action = 'pwa_ajax_handle_device_id';

                $.ajax({
                    url: plugin['AjaxURL'],
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: action,
                        user_id: subscription_id,
                        handle: handle,
                        clientData: clientData
                    }
                }).done(function(data) {
                    //console.log(data);
                });
            }

            window.pwaRegisterPushDevice = registerPushDevice;
            window.pwaDeregisterPushDevice = deregisterPushDevice;
        })(jQuery, PwaJsVars);

        /***/
    })
    /******/
]);