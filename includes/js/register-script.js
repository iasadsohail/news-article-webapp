const submitBtn = document.getElementById('submit-btn');
const nameInput = document.getElementById('name');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const rePasswordInput = document.getElementById('re-password');

submitBtn.addEventListener('click', function (e) {

    if (submitBtn.style.cursor == 'progress') return;

    e.preventDefault();

    //validate
    var emailVal = emailInput.value;
    var passwordVal = passwordInput.value;

    if (emailInput.value != '' && nameInput.value != '' && passwordInput.value != '' && rePasswordInput.value != '') {
        //other email validations
        if (passwordInput.value === rePasswordInput.value) {
            //other password validations

            submitBtn.style.cursor = 'progress';

            var reqData = "registerFlag=1&name="+nameInput.value+"&email=" + emailInput.value + "&password=" + passwordInput.value;

            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    submitBtn.style.cursor = 'pointer';
                    switch (this.responseText) {
                        case 'success':
                            alert('Thank You For the Registration!');
                            window.location.assign('../');
                            break;
                        case 'failure':
                            alert('Something Went Wrong. Try Again Later');
                            break;
                        case 'already_exists':
                            alert('Invalid Credentials');
                            break;
                        default:
                            console.log(this.response);
                            // window.location.assign('../500.php');
                            break;
                    }
                }
            };

            xhttp.open("POST", "../includes/php/classes/RegisterReqHandler.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(reqData);

        }
    }

});