window.onload = function(e){ 
    var senha1 = document.getElementById('senha');
    var senha2 = document.getElementById('senha_confirmacao');
    
    var checkPasswordValidity = function() {
        if (senha1.value != senha2.value) {
            senha2.setCustomValidity('As senhas devem ser iguais.');
        } else {
            senha2.setCustomValidity('');
        }        
    };

    senha1.addEventListener('change', checkPasswordValidity, false);
    senha2.addEventListener('change', checkPasswordValidity, false);

    var email1 = document.getElementById('email');
    var email2 = document.getElementById('email_confirmacao');

    var checkEmailValidity = function() {
        if (email1.value != '' && email2.value != '' && email1.value != email2.value) {
            email2.setCustomValidity('Os e-mails devem ser iguais.');
        } else {
            email2.setCustomValidity('');
        }        
    };

    email1.addEventListener('change', checkEmailValidity, false);
    email2.addEventListener('change', checkEmailValidity, false);

    var form = document.getElementById('rede_cinema_cadastro');
    form.addEventListener('submit', function() {
        checkPasswordValidity();
        checkEmailValidity();
        if (!this.checkValidity()) {
            event.preventDefault();
            //Implement you own means of displaying error messages to the user here.
            senha1.focus();
        }
    }, false);
}