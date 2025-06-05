function eliminaUsuario(e, userID) {
    e.preventDefault();
    console.log(userID);
    swal({
        title: "Atencion!!!",
        text: "¿Realmente deseas eliminar el Usuario?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $('#formUserDelete' + userID).submit();
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