function jsonCheckUsername(json) {
    if (!json.exists) {
        document.querySelector('#err_user').textContent = "Invalid username (16 characters max.)"; 
        document.querySelector('#err_user').classList.add('hidden');
        finalCheck.user = true;
    } else {
        document.querySelector('#err_user').textContent = "This username is already taken";
        document.querySelector('#err_user').classList.remove('hidden');
        finalCheck.user = false;
    }
}

function jsonCheckEmail(json) {
    if (!json.exists) {
        document.querySelector('#err_email').textContent = "Invalid email address"; 
        document.querySelector('#err_email').classList.add('hidden');
        finalCheck.email = true;
    } else {
        document.querySelector('#err_email').textContent = "This email is already taken";
        document.querySelector('#err_email').classList.remove('hidden');
        finalCheck.email = false;
    }
}

function fetchResponse(response) {
    return (response.ok ? response.json() : null);
}

function checkUsername(event) {
    const user = document.querySelector('input[name="username"]');

    if (!/^[a-zA-Z0-9_]{1,16}$/.test(user.value)) {
        document.querySelector('#err_user').classList.remove("hidden");
        finalCheck.user = false;
    } else {
        fetch("check_username.php?q=" + encodeURIComponent(user.value)).then(fetchResponse).then(jsonCheckUsername);
    }
}

function checkEmail(event) {
    const addr = document.querySelector('input[type="email"]');

    if (!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(addr.value).toLowerCase())) {
        document.querySelector('#err_email').classList.remove("hidden");
        finalCheck.email = false;
    } else {
        fetch("check_email.php?q=" + encodeURIComponent(String(addr.value).toLowerCase())).then(fetchResponse).then(jsonCheckEmail);
    }
}

function checkPassword(event) {
    const pass = document.querySelector('input[name="password"]');
    if (stat.password = pass.value.length >= 8) {
        document.querySelector('#err_pass').classList.add('hidden');
        finalCheck.pass = true;
    } else {
        document.querySelector('#err_pass').classList.remove('hidden');
        finalCheck.pass = false;
    }
}


const stat = { 'up': true };
let finalCheck = {
    email: false,
    user: false,
    pass: false,
    
};

function finalSubmitCheck(event) {
    let fCheck = 0;
    for (const f in finalCheck) {
        if (finalCheck[f] == false) fCheck++;
    }

    if (fCheck) {
        event.preventDefault();
        console.log("AMUGUS");
        
    }
}

document.querySelector('input[name="email"]').addEventListener('blur', checkEmail);
document.querySelector('input[name="username"]').addEventListener('blur', checkUsername);
document.querySelector('input[name="password"]').addEventListener('blur', checkPassword);
document.forms['signup_form'].addEventListener('submit', finalSubmitCheck);