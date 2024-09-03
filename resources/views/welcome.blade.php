<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Horas Trabajadas</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body class="container my-5">
    <h1 class="text-center mb-4">Control de Horas Trabajadas</h1>

    <div class="text-center">
        <button id="startButton" class="btn btn-success btn-lg mb-3">Iniciar Jornada</button>
        <button id="endButton" class="btn btn-danger btn-lg mb-3" disabled>Finalizar Jornada</button>
    </div>

    <div class="form-group">
        <textarea id="description" class="form-control" placeholder="Describe lo que hiciste..." disabled></textarea>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        let currentSessionId = null;

        document.getElementById('startButton').addEventListener('click', () => {
            fetch('/start', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Importante para la seguridad de Laravel
                },
            })
            .then(response => response.json())
            .then(data => {
                currentSessionId = data.id;
                document.getElementById('startButton').disabled = true;
                document.getElementById('endButton').disabled = false;
                document.getElementById('description').disabled = false;
                Swal.fire({
  title: "Good job!",
  text: 'Jornada iniciada a las: ' + new Date(data.start_time).toLocaleTimeString(),
  icon: "success"
});
            })
            .catch(error => console.error('Error:', error)); // Añadir manejo de errores
        });

        document.getElementById('endButton').addEventListener('click', () => {
            let description = document.getElementById('description').value;

            fetch('/end/' + currentSessionId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Importante para la seguridad de Laravel
                },
                body: JSON.stringify({ description })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('startButton').disabled = false;
                document.getElementById('endButton').disabled = true;
                document.getElementById('description').value = '';
                document.getElementById('description').disabled = true;
                Swal.fire({
  icon: "success",
  title: "Jornada Finalizada",
  text: "Jornada finalizada a las: ' + new Date(data.end_time).toLocaleTimeString() + '\nDescripción: ' + data.description",
 
});
            })
            .catch(error => console.error('Error:', error)); // Añadir manejo de errores
        });
    </script>
</body>
</html>
