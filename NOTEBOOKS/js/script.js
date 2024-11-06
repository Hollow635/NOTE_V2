const pass = document.getElementById("password");
const icon = document.getElementById("toggle-password");

// Función para mostrar/ocultar la contraseña
icon.addEventListener("click", () => {
    if (pass.type === "password") {
        pass.type = "text";
        icon.classList.remove('bx-show-alt');
        icon.classList.add('bx-hide');
    } else {
        pass.type = "password";
        icon.classList.add('bx-show-alt');
        icon.classList.remove('bx-hide');
    }
});

// Mostrar la notificación de éxito o error al cargar la página
window.onload = function() {
    // Verificamos si el contenedor de la notificación de éxito existe
    const successNotification = document.getElementById('success-notification');
    const errorNotification = document.getElementById('error-notification');
    
    // Si la notificación de éxito existe, la mostramos
    if (successNotification) {
        successNotification.classList.add('show');
        setTimeout(function() {
            successNotification.classList.remove('show');
        }, 5000); // Ocultar después de 5 segundos
    }

    // Si la notificación de error existe, la mostramos
    if (errorNotification) {
        errorNotification.classList.add('show');
        setTimeout(function() {
            errorNotification.classList.remove('show');
        }, 5000); // Ocultar después de 5 segundos
    }
};

// Expresiones regulares para los requisitos de la contraseña
const lengthPattern = /.{8,}/; // Al menos 8 caracteres
const lowercasePattern = /[a-z]/; // Al menos una letra minúscula
const numberPattern = /\d/; // Al menos un número

// Obtener los elementos de los requisitos de la contraseña
const lengthRequirement = document.getElementById("length");
const lowercaseRequirement = document.getElementById("lowercase");
const numberRequirement = document.getElementById("number");

// Validar los requisitos de la contraseña en tiempo real
pass.addEventListener("input", function() {
    const password = pass.value;

    // Validar longitud
    if (lengthPattern.test(password)) {
        lengthRequirement.classList.remove("invalid");
        lengthRequirement.classList.add("valid");
    } else {
        lengthRequirement.classList.remove("valid");
        lengthRequirement.classList.add("invalid");
    }

    // Validar letra minúscula
    if (lowercasePattern.test(password)) {
        lowercaseRequirement.classList.remove("invalid");
        lowercaseRequirement.classList.add("valid");
    } else {
        lowercaseRequirement.classList.remove("valid");
        lowercaseRequirement.classList.add("invalid");
    }

    // Validar número
    if (numberPattern.test(password)) {
        numberRequirement.classList.remove("invalid");
        numberRequirement.classList.add("valid");
    } else {
        numberRequirement.classList.remove("valid");
        numberRequirement.classList.add("invalid");
    }
});
