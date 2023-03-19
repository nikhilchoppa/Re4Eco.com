var client = new ClientJS();
var isiPhoneSafari = client.isMobileIOS() && client.isSafari();
var isiPhoneStandalone = ("standalone" in window.navigator) && window.navigator.standalone;
var isChrome = client.isChrome();
var isFirefox = client.isFirefox();
var isAndroid = client.isMobileAndroid();
var isAndroidStandalone = window.matchMedia('(display-mode: standalone)').matches;
var isiPhoneOverlayShown = getCookie("iphoneOverlay");
var isChromeOverlayShown = getCookie("chromeOverlay");
var isChromeOverlayShown2 = getCookie("chromeOverlay2");
var isFirefoxOverlayShown = getCookie("firefoxOverlay");
var isBrowsingApp = document.referrer.length > 0 && document.referrer.indexOf(window.location.hostname) != -1;
var isHomePage = localStorage.getItem('homeURL') == window.location.href;
var forms = document.getElementsByTagName('form');
var isFormPresent = typeof(forms) != 'undefined' && forms != null;

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie(name) {
    document.cookie = name + '=; Max-Age=-99999999;';
}

function showiPhoneOverlay() {
    document.querySelector(".addiphone").style.display = 'block';
}

function hideiPhoneOverlay() {
    document.querySelector(".addiphone").style.display = 'none';
    setCookie('iphoneOverlay', 'shown', PwaJsVars['hideForDays']);
}

function showChromeOverlay() {
    document.querySelector(".addchrome").style.display = 'block';
}

function hideChromeOverlay() {
    document.querySelector(".addchrome").style.display = 'none';
    setCookie('chromeOverlay', 'shown', PwaJsVars['hideForDays']);
}

function showChromeOverlay2() {
    document.querySelector(".addchrome2").style.display = 'block';
}

function hideChromeOverlay2() {
    document.querySelector(".addchrome2").style.display = 'none';
    setCookie('chromeOverlay2', 'shown', PwaJsVars['hideForDays']);
}

function showFirefoxOverlay() {
    document.querySelector(".addfirefox").style.display = 'block';
}

function hideFirefoxOverlay() {
    document.querySelector(".addfirefox").style.display = 'none';
    setCookie('firefoxOverlay', 'shown', PwaJsVars['hideForDays']);
}

function showRestoreSession() {
    document.querySelector(".iosmodal-overlay").style.display = 'block';
}

function hideRestoreSession() {
    document.querySelector(".iosmodal-overlay").style.display = 'none';
}

function restoreSession() {
    window.location.replace(localStorage.getItem('lastURL'));
}

document.addEventListener('DOMContentLoaded', function() {
    // IOS
    if (isiPhoneSafari && isiPhoneStandalone == false && isiPhoneOverlayShown == null && document.getElementById("instovrlyssafari-enabled")) {
        setTimeout(function() {
            showiPhoneOverlay();
        }, 5000);
    }

    if (isiPhoneStandalone) {
        // stop link clicks out of the standalone mode
        var noddy, remotes = false;
        document.addEventListener('click', function(event) {
            noddy = event.target;

            if (noddy.tagName.toLowerCase() !== 'a' || noddy.hostname !== window.location.hostname || noddy.pathname !== window.location.pathname || !/#/.test(noddy.href)) return;

            while (noddy.nodeName !== "A" && noddy.nodeName !== "HTML") {
                noddy = noddy.parentNode;
            }

            if ('href' in noddy && noddy.href.indexOf('http') !== -1 && (noddy.href.indexOf(document.location.host) !== -1 || remotes)) {
                event.preventDefault();
                document.location.href = noddy.href;
            }
        }, false);

        // persist state on standalone mode
        if (document.getElementById("iospersist-enabled")) {
            if (localStorage.getItem('lastURL') === null) {
                localStorage.setItem('homeURL', window.location.href);
                localStorage.setItem('lastURL', 'HomePage');
            } else {
                if (isBrowsingApp) {
                    if (isHomePage) {
                        localStorage.removeItem('lastURL');
                    } else {
                        localStorage.setItem('lastURL', window.location.href);
                    }
                } else {
                    setTimeout(function() {
                        showRestoreSession();
                    }, 1000);
                }
            }
        }

        // display rotate device notification based on orientation
        if (document.getElementById("rotatenotice-enabled")) {
            setInterval(function() {
                if ((PwaJsVars['orientation'] == 'portrait' && window.matchMedia("(orientation: landscape)").matches) || (PwaJsVars['orientation'] == 'landscape' && window.matchMedia("(orientation: portrait)").matches)) {
                    document.querySelector(".rotateNotice").style.display = 'flex';
                    window.onorientationchange = function() {
                        document.querySelector(".rotateNotice").style.display = 'none';
                    };
                }
            }, 100);
        }
    }

    // ANDROID
    if (isAndroid && isAndroidStandalone == false) {
        if (isChrome && isChromeOverlayShown == null && isChromeOverlayShown2 == null && document.getElementById("instovrlyschrome-enabled")) {
            navigator.serviceWorker.getRegistrations().then(registrations => {
                if (!registrations.length == 0) {
                    var installPromptEvent = void 0;
                    window.addEventListener('beforeinstallprompt', function(event) {

                        event.preventDefault();

                        installPromptEvent = event;

                        setTimeout(function() {
                            showChromeOverlay();
                        }, 5000);

                        var btnAdd = document.getElementById('button-addtohome');
                        btnAdd.addEventListener('click', function() {
                            hideChromeOverlay();
                            installPromptEvent.prompt();
                            installPromptEvent.userChoice.then(function(choice) {
                                if (choice.outcome === 'accepted') {
                                    // User accepted the A2HS prompt
                                } else {
                                    showChromeOverlay();
                                }
                                installPromptEvent = null;
                            });
                        });
                    });
                } else {
                    setTimeout(function() {
                        showChromeOverlay2();
                    }, 5000);
                }
            });
        } else if (isFirefox && isFirefoxOverlayShown == null && document.getElementById("instovrlysfirefox-enabled")) {
            setTimeout(function() {
                showFirefoxOverlay();
            }, 5000);
        }
    }

    // BOTH
    if (isAndroidStandalone || isiPhoneStandalone) {
        if (isFormPresent) {
            for (var i = 0; i < forms.length; i++) {
                forms[i].setAttribute("data-persist", "garlic");
            }
        }
    }
});