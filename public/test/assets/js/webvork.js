(function() {
    document.addEventListener("DOMContentLoaded", function() {
        var forms = document.querySelectorAll('.buyForm');
        var prefixes = [2,32,33,34,35,36,37,38,39,42,43,44,45,53,54,55,56,60,61,62,63,64,65,68,69,73,74,75,76,77,80,800,801,802,803,804,805,810,811,812,813,814,815,816,817,818,819,82,83,84,85,86,871,872,873,874,875,876,88,89,90,91,92,93,94,95,96,97,98,99]
        var prefixesForLength = [2,32,34,35,36,37,38,39,42,43,44,45,52,53,54,55,56,73,74,75,76,77]
        function removeDirections(phone) {
            var regEx = /^(?:(?:\+66|0066|66)[\s-]{0,3}(?:\(0\)[\s-]{0,3})?|0)/

            return phone.replace(regEx, "");
        }
        function removeSpecialChars(phone) {
            var regEx = /\|&;\$%@"<>\(\)\+/g;

            return phone.replace(regEx, "");
        }
        function addZeroStart(phone) {
            if (phone[0] != 0) {
                phone = '0' + phone
            }

            return phone;
        }
        function checkForPrefix(phone) {
            var regStr = "^0(";
            regStr += prefixes.join("|");
            regStr += ")";

            var regEx = new RegExp(regStr);
            return regEx.test(phone);
        }
        function checkWhatLength(phone) {
            var regStr = "^0(";
            regStr += prefixesForLength.join("|");
            regStr += ")";

            var regEx = new RegExp(regStr);
            return regEx.test(phone);
        }
        function checkPhoneLength(phone) {
            phone = phone.replace(/\D+/g, '');
            var whatLength = checkWhatLength(phone);
            if (whatLength) {
                if (phone.length < 9 || phone.length > 10) {
                    return false
                }
                return true
            } else {
                if (phone.length != 10) {
                    return false
                }
                return true
            }
        }
        function phoneValidation(phone) {
            phone = removeDirections(phone);
            phone = removeSpecialChars(phone);
            phone = addZeroStart(phone);
            var prefix = checkForPrefix(phone);
            var length = checkPhoneLength(phone);
            if (prefix && length || phone == 1234567890) {
                return true;
            }
            return false;
        }
        forms.forEach(function(form, index) {
            form.addEventListener('submit', function(e) {
                var phone = form.querySelector('input[name="phone"]').value;
                var phoneInputField = form.querySelector('input[name="phone"]');
                var msg = form.querySelector('.message1');
                var loader = form.querySelector('.loader');
                var submitBtn = form.querySelector('.submit-form');
                if (phoneValidation(phone)) {
                    msg.style.display = 'none';
                    loader.style.display = 'block';
                    submitBtn.disabled = true;
                    phoneInputField.style.borderColor = 'inherit';
                    return true;
                } else {
                    e.preventDefault();
                    msg.style.display = 'none';
                    phoneInputField.style.borderColor = 'inherit';
                    if (!phoneValidation(phone)) {
                        phoneInputField.style.border = '1px solid #D91E18';
                        msg.style.display = 'block';
                        msg.textContent = 'รูปแบบโทรศัพท์ไม่ถูกต้อง';
                    }
                }
            })
        })
    })
    document.querySelectorAll('buyForm')
        .forEach(function(form) {
            var submit = form.querySelector('.submit-form');
            bindFormControl(form, submit, '');
        });
    document.querySelectorAll('buyForm')
        .forEach(function(form) {
            var submit = form.querySelector('.submit-form');
            bindFormControl(form, submit, '');
        });
    var bindFormControl = function(form, submit, language) {
        if (!isDomElement(form)) {
            throw 'Invalid form element';
        }
        if (!isDomElement(submit)) {
            throw 'Invalid form element';
        }
        submit.addEventListener('click', function() {
            var isValid = form.checkValidity();
            if (!isValid) {
                return false;
            }
            var buttonText = '';
            switch (language) {
                case 'in':
                    buttonText = 'Sedang mengirim, mohon menunggu...';
                    break;
                case 'th':
                    buttonText = 'โปรดรอสักครู่ กำลังส่ง...';
                    break;
                default:
                    buttonText = 'Sending, please wait...';
                    break;
            }
            submit.textContent = buttonText;
            submit.value = buttonText;
            submit.disabled = true;
            form.submit();
        });
    };
    var isDomElement = function(object) {
        return object instanceof Element
    }
    function getTimeRemaining(e) {
        var n = Date.parse(e) - Date.parse(new Date),
            t = Math.floor(n / 1e3 % 60),
            i = Math.floor(n / 1e3 / 60 % 60);
        return {
            total: n,
            hours: Math.floor(n / 36e5 % 24),
            minutes: i,
            seconds: t
        }
    }
    function initializeClock(e, n) {
        var t = document.getElementById(e),
            i = t.querySelector(".hours"),
            a = t.querySelector(".min"),
            r = t.querySelector(".sec");
        function o() {
            var e = getTimeRemaining(n);
            i.innerHTML = ("0" + e.hours).slice(-2), a.innerHTML = ("0" + e.minutes).slice(-2), r.innerHTML = ("0" + e.seconds).slice(-2), e.total <= 0 && clearInterval(l)
        }
        o();
        var l = setInterval(o, 1e3)
    }
    var deadline = new Date(Date.parse(new Date) + 9e5);
    document.addEventListener("DOMContentLoaded", function() {
        initializeClock("timer", deadline), initializeClock("timer2", deadline)
    })
})();