function eliminaCarrera(e, careerID){
    e.preventDefault();
    console.log(careerID);
    swal({
        title: "Atencion!!!",
        text: "¿Realmente deseas eliminar la Carrera?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $('#formCareerDelete' + careerID).submit();
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
            //     route: urlDestroyCareer,
            //     type: 'DELETE',
            //     data: career,
            //     dataType: 'JSON',
            //     error: function(e) {
            //         swal("Error al eliminar la carrera", {
            //             title: e.statusText,
            //             icon: "warning",
            //         });
            //     },
            //     success: function(respuesta) {
            //         swal("Carrera eliminada correctamente", {
            //             icon: "success",
            //         });
            //         location.reload();
            //     }
            // });
        }
    });
}