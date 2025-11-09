</div> <!-- .card -->
</div> <!-- .col-12 -->
</div> <!-- .row -->
</div> <!-- .container-fluid -->
</main>
</div> <!-- /.wrapper -->

<!-- Scripts base -->
<script src="<?= base_url('public/static/js/app.js') ?>"></script>


<!-- ✅ jQuery primero -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- ✅ Luego Toastr -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };
</script>

<?php if (session()->getFlashdata()): ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            <?php foreach (['success', 'error', 'warning', 'info'] as $type): ?>
                <?php if (session()->getFlashdata($type)): ?>
                    toastr["<?= $type ?>"]("<?= esc(session()->getFlashdata($type)) ?>");
                <?php endif; ?>
            <?php endforeach; ?>
        });
    </script>
<?php endif; ?>

<!-- Simple-DataTables -->
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3" type="text/javascript"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.querySelector("#datatable");
        if (table) {
            const datatable = new simpleDatatables.DataTable(table, {
                searchable: true,
                fixedHeight: true,
                perPageSelect: [5, 10, 25, 50, 100],
                labels: {
                    placeholder: "Buscar...",
                    perPage: "Registros por página",
                    noRows: "No se encontraron registros",
                    info: "Mostrando {start} a {end} de {rows}",
                    loading: "Cargando datos...",
                    infoFiltered: " — filtrado de {rows} registros totales",
                    next: "Siguiente →",
                    previous: "← Anterior",
                    first: "Primero",
                    last: "Último",
                    pageTitle: "Página {page}",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    noResults: "❌ No se encontraron coincidencias para tu búsqueda",
                }
            });

            const headerRow = table.querySelector("thead tr");
            if (headerRow) {
                headerRow.style.backgroundColor = "#1cbb8c";
            }

            const sorters = table.querySelectorAll(".datatable-sorter");
            sorters.forEach(el => {
                el.style.color = "#222e3c";
            });
        }
    });
</script>

</body>

</html>