document.addEventListener("DOMContentLoaded", () => {
    //Script para expandir asosciaciones
    const botones = document.querySelectorAll(".btn-toggle-asociaciones");
    botones.forEach(btn => {
        btn.addEventListener("click", () => {
            const lista = btn.nextElementSibling;
            if (!lista) return;

            const visible = lista.style.display === "block";
            lista.style.display = visible ? "none" : "block";
            btn.textContent = visible
                ? "Ver Asociaciones"
                : "Ocultar Asociaciones";
        });
    });

    //Script para busqueda por nombre o universidad
    //Este script permite buscar usuarios en la tabla por nombre o area
    const searchInput = document.getElementById("search");
    const table = document.getElementById("programsTable");
    const rows = table
        .getElementsByTagName("tbody")[0]
        .getElementsByTagName("tr");

    searchInput.addEventListener("input", function() {
        const searchTerm = searchInput.value.toLowerCase();

        for (let row of rows) {
            const folioCell = row.cells[0];
            const nameCell = row.cells[1]; // primera columna (Nombre)
            const universityCell = row.cells[2]; // segunda columna (Area)
            const name = nameCell.textContent.toLowerCase();
            const area = universityCell.textContent.toLowerCase();
            const folio = folioCell.textContent.toLowerCase();

            if (name.includes(searchTerm) || area.includes(searchTerm) ||folio.includes(searchTerm) ) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    });
});
