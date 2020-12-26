const submitBtn = document.getElementById('submit-btn');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');

submitBtn.addEventListener('click', function (e) {

    if (submitBtn.style.cursor == 'progress') return;

    e.preventDefault();

    //validate
    var emailVal = emailInput.value;
    var passwordVal = passwordInput.value;

    if (emailVal != '') {
        //other email validations
        if (passwordVal != '') {
            //other password validations

            submitBtn.style.cursor = 'progress';

            var reqData = "loginFlag=1&email=" + emailInput.value + "&password=" + passwordInput.value;

            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    submitBtn.style.cursor = 'pointer';
                    switch (this.responseText) {
                        case 'success':
                            window.location.assign('../');
                            break;
                        case 'no_user':
                            alert('No Such User Exists');
                            break;
                        case 'wrong_password':
                            alert('Invalid Credentials');
                            break;
                        default:
                            window.location.assign('../500.php');
                            break;
                    }
                }
            };

            xhttp.open("POST", "../includes/php/classes/LoginReqHandler.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(reqData);

        }
    }

});