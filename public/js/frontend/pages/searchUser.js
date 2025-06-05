document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("search");
    const table = document.getElementById("usersTable");
    const rows = table
        .getElementsByTagName("tbody")[0]
        .getElementsByTagName("tr");

    searchInput.addEventListener("input", function() {
        const searchTerm = searchInput.value.toLowerCase();

        for (let row of rows) {
            const nameCell = row.cells[0]; // primera columna (Nombre)
            const name = nameCell.textContent.toLowerCase();

            if (name.includes(searchTerm)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    });
});
// This script filters the user table based on the search input