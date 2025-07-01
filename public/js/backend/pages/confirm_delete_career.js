function eliminaCarrera(e, careerID) {
    e.preventDefault();
    console.log(careerID);
    Swal.fire({
        title: "Atención",
        text: "¿Realmente deseas eliminar la Carrera?",
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
    }).then(willDelete => {
        if (willDelete.isConfirmed) {
            $("#formCareerDelete" + careerID).submit();
        }
    });
}
