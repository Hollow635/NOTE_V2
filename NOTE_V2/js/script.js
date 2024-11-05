const pass = document.getElementById("password");
const icon = document.getElementById("toggle-password");

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