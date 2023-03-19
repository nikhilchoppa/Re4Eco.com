var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function(obj) {
    return typeof obj;
} : function(obj) {
    return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
};

var _createClass = function() {
    function defineProperties(target, props) {
        for (var i = 0; i < props.length; i++) {
            var descriptor = props[i];
            descriptor.enumerable = descriptor.enumerable || false;
            descriptor.configurable = true;
            if ("value" in descriptor) descriptor.writable = true;
            Object.defineProperty(target, descriptor.key, descriptor);
        }
    }
    return function(Constructor, protoProps, staticProps) {
        if (protoProps) defineProperties(Constructor.prototype, protoProps);
        if (staticProps) defineProperties(Constructor, staticProps);
        return Constructor;
    };
}();

function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
        throw new TypeError("Cannot call a class as a function");
    }
}

var OfflineForm = function() {

    function OfflineForm(element) {
        var _this = this;
        _classCallCheck(this, OfflineForm);
        this.form = element;
        this.id = element.id;
        this.action = element.action;
        this.data = {};
              
        if (!navigator.onLine) {
            this.form.addEventListener('submit', function(e) {
                return _this.handleSubmit(e);
            });
        } else {
            window.addEventListener('load', function() {
                return _this.checkStorage();
            });
        }
    }
    _createClass(OfflineForm, [{
        key: 'handleSubmit',
        value: function handleSubmit(e) {
            // handle ofline submit
            e.preventDefault();
            this.getFormData();
            var stored = this.storeData();
            if (stored) {
              jQuery.toast({
                title: 'Your data was saved and will be submitted once you come back online',
                duration: 3000,
                position: 'bottom',
              });
              this.form.reset();
            }
        }
    }, {
        key: 'storeData',
        value: function storeData() {
            // save data in localStorage
            if (typeof Storage !== 'undefined') {
                var entry = {
                    time: new Date().getTime(),
                    data: this.data
                };

                localStorage.setItem(this.id, JSON.stringify(entry));
                return true;
            }
            return false;
        }
    }, {
        key: 'sendData',
        value: function sendData() {
            // send ajax call to server
            var _this2 = this;
            jQuery.ajax({
                url: this.action,
                type: 'POST',
                data: this.data,
            }).done(function(data) {
                localStorage.removeItem(_this2.id);
                _this2.form.reset();
            }).fail(function(data, textStatus, xhr) {
                 console.log("error", data.status);
            });       
        }
    }, {
        key: 'checkStorage',
        value: function checkStorage() {
            // check if we have saved data in localStorage

            if (typeof Storage !== 'undefined') {
                var item = localStorage.getItem(this.id);
                var entry = item && JSON.parse(item);

                if (entry) {
                    // discard submissions older than one day
                    var now = new Date().getTime();
                    var day = 24 * 60 * 60 * 1000;
                    if (now - day > entry.time) {
                        localStorage.removeItem(this.id);
                        return;
                    }

                    // we have saved form data, try to submit it 
                    this.data = entry.data;
                    var sent = this.sendData();
                    if (sent) {
              			jQuery.toast({
              			  title: 'Your offline saved data was successfully submitted',
              			  duration: 3000,
              			  position: 'bottom',
              			});
                    }
                }
            }
        }
    }, {
        key: 'getFormData',
        value: function getFormData() {
            // simple parser, get form data as object
            var field = void 0;
            var i = void 0;
            var data = {};

            if (_typeof(this.form) === 'object' && this.form.nodeName === 'FORM') {
                var len = this.form.elements.length;
                for (i = 0; i < len; i += 1) {
                    field = this.form.elements[i];
                    if (field.name &&
                        !field.disabled &&
                        field.type !== 'file' &&
                        field.type !== 'reset' &&
                        field.type !== 'submit') {
                        data[field.name] = field.value || '';
                    }
                }
            }
            this.data = data;
        }
    }]);
    return OfflineForm;
}();