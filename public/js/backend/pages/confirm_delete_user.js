function eliminaUsuario(e, userID) {
    e.preventDefault();
    console.log(userID);

    Swal.fire({
        title: "Atención",
        text: "¿Realmente deseas eliminar el Usuario?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: "btn btn-secondary"
        },
        buttonsStyling: false
    }).then(result => {
        if (result.isConfirmed) {
            $("#formUserDelete" + userID).submit();
        }
    });
}
