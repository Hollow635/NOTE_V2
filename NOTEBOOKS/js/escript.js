// Función para obtener la hora local del dispositivo
function obtenerHoraLocal() {
    const fecha = new Date();
    const horas = fecha.getHours().toString().padStart(2, '0'); // Hora en formato 2 dígitos
    const minutos = fecha.getMinutes().toString().padStart(2, '0'); // Minutos en formato 2 dígitos
    const segundos = fecha.getSeconds().toString().padStart(2, '0'); // Segundos en formato 2 dígitos
    const horaLocal = `${horas}:${minutos}:${segundos}`; // Formato HH:MM:SS

    // Asigna la hora al campo oculto para ser usado más tarde en el formulario o el PDF
    document.getElementById('horaPrestamo').value = horaLocal;
}

// Llamamos a la función para obtener la hora cuando cargue la página
window.onload = obtenerHoraLocal;