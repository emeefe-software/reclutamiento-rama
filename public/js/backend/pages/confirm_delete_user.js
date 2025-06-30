function eliminaUsuario(e, userID) {
    e.preventDefault();
    console.log(userID);
    Swal.fire({
        title: "Atención",
        text: "¿Realmente deseas eliminar el Usuario?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33", // Rojo para confirmar
        cancelButtonColor: "#3085d6", // Azul para cancelar
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        customClass: {
            confirmButton: "btn btn-danger", // Le metemos clase Bootstrap si usas Bootstrap
            cancelButton: "btn btn-secondary"
        },
        buttonsStyling: false
    }).then(willDelete => {
        if (willDelete) {
            $("#formUserDelete" + userID).submit();
            // axios.delete('careers/destroy', {
            //     params : career,
            // })
            // .then(response => {
            //     swal("Carrera eliminada correctamente", {
            //         icon: "success",
            //     });
            // })
            // .catch(e => {
            //     swal("Error al eliminar la carrera", {
            //         text : e,
            //         icon: "warning",
            //     });
            // });
            // $.ajax({
            //     route: urlDestroyUser,
            //     type: 'DELETE',
            //     data: user,
            //     dataType: 'JSON',
            //     error: function(e) {
            //         swal("Error al eliminar el Usuario", {
            //             title: e.statusText,
            //             icon: "warning",
            //         });
            //     },
            //     success: function(respuesta) {
            //         swal("Usuario eliminado correctamente", {
            //             icon: "success",
            //         });
            //         location.reload();
            //     }
            // });
        }
    });
}
