

window.onload = function() {
    fetch('obtener_registros.php')
        .then(response => response.json())
        .then(data => {
            if (data.mensaje) {
                alert(data.mensaje);
                return;
            }
            const tbody = document.querySelector('#registros tbody');
            data.forEach(registro => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${registro.primerNombre}</td>
                    <td>${registro.segundoNombre}</td>
                    <td>${registro.primerApellido}</td>
                    <td>${registro.segundoApellido}</td>
                    <td>${registro.tipoDocumento}</td>
                    <td>${registro.numeroDocumento}</td>
                    <td>${registro.fechaNacimiento}</td>
                    <td>${registro.edad}</td>
                    <td>${registro.lugarNacimiento}</td>
                    <td>${registro.genero}</td>
                    <td>${registro.tipoSanguineo}</td>
                    <td>${registro.direccion}</td>
                    <td>${registro.estrato}</td>
                    <td>${registro.correoElectronico}</td>
                    <td>${registro.telefono}</td>
                    <td>${registro.centroMusical}</td>
                    <td>${registro.instrumentoMusical}</td>
                    <td>${registro.semestre}</td>
                    <td>${registro.ano}</td>
                    <td>${registro.fecha}</td>
                `;
                tbody.appendChild(tr);
            });
        })
        .catch(error => console.error('Error:', error));
};

document.getElementById('exampleForm').addEventListener('submit', function(event) {
    event.preventDefault();
    // Aquí puedes agregar la lógica para manejar el envío del formulario
    alert('Formulario enviado');
});


