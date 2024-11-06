function validateDivision() {
    var divisionInput = document.getElementById('division');
    var especialidadInput = document.getElementById('especialidad-wrapper');
    var divisionValue = divisionInput.value;

    // Expresión regular para verificar que solo se ingresen números y el símbolo '°' después del número
    if (!/^[\d]+°[\d]*°?$/.test(divisionValue)) {
        divisionInput.setCustomValidity("Por favor, ingrese un formato válido (ej: 6°2°).");
        divisionInput.reportValidity();
        return;
    }

    divisionInput.setCustomValidity(""); // Restablece el mensaje de error

    // Limpia el valor y obtiene el primer dígito
    var cleanDivisionValue = divisionValue.replace(/°/g, ''); 
    var firstDigit = parseInt(cleanDivisionValue.charAt(0));

    // Valida que el primer dígito esté entre 1 y 6
    if (isNaN(firstDigit) || firstDigit < 1 || firstDigit > 6) {
        divisionInput.setCustomValidity("El Año debe ser entre 1 y 6.");
    } else {
        divisionInput.setCustomValidity(""); // Restablece el mensaje de error
        if (firstDigit >= 3) {
            especialidadInput.style.display = 'block'; 
            document.getElementById('especial').required = true;
        } else {
            especialidadInput.style.display = 'none'; 
            document.getElementById('especial').required = false;
        }
    }
}