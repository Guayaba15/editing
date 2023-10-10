// Espera a que el documento esté cargado completamente
document.addEventListener("DOMContentLoaded", function () {
  // Agrega un evento de clic a los elementos con clase "deleteUser"
  const deleteButtons = document.querySelectorAll(".deleteUser");
  
  deleteButtons.forEach(button => {
    button.addEventListener("click", function (event) {
      event.preventDefault(); // Evita que el enlace siga el enlace original
      
      const userId = this.getAttribute("data-userid"); // Obtiene el ID del usuario
      
      // Muestra una alerta SweetAlert para confirmar la eliminación
      Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          // Realiza una solicitud AJAX para eliminar el usuario
          fetch(`eliminar_participante.php?id=${userId}`)
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                // Si se eliminó exitosamente, muestra la alerta SweetAlert
                Swal.fire({
                  icon: 'success',
                  title: 'Registro eliminado',
                  text: 'El registro ha sido eliminado exitosamente.',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Aceptar'
                }).then(() => {
                  // Recarga la página después de eliminar el usuario
                  location.reload();
                });
              } else {
                // Si hubo un error, muestra una alerta de error
                Swal.fire({
                  icon: 'error',
                  title: 'Error al eliminar',
                  text: 'Hubo un error al intentar eliminar el usuario.',
                  confirmButtonColor: '#3085d6',
                  confirmButtonText: 'Aceptar'
                });
              }
            })
            .catch(error => {
              console.error('Error al eliminar:', error);
            });
        }
      });
    });
  });
});
