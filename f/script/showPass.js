function show() {
    var password = document.getElementById("password");
    var cPassword = document.getElementById("cPassword");
    var oPassword = document.getElementById("oPassword");

    if (password.type == "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }

    if (cPassword.type == "password") {
        cPassword.type = "text";
    } else {
        cPassword.type = "password";
    }

    if (oPassword.type == "password") {
        oPassword.type = "text";
    } else {
        oPassword.type = "password";
    }
}