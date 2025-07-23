window.addEventListener('DOMContentLoaded', event => {
    // Tabla Orders
    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }

    // Tabla de Músicos
    const musiciansTable = document.getElementById('musiciansTable');
    if (musiciansTable) {
        new simpleDatatables.DataTable(musiciansTable);
    }

    // Tabla de Géneros Musicales
    const genresTable = document.getElementById('genresTable');
    if (genresTable) {
        new simpleDatatables.DataTable(genresTable);
    }

    // Tabla de Cientes
    const clientsTable = document.getElementById('clientsTable');
    if (clientsTable) {
        new simpleDatatables.DataTable(clientsTable);
    }
});
