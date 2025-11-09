</div> <!-- .card -->
</div> <!-- .col-12 -->
</div> <!-- .row -->
</div> <!-- .container-fluid -->
</main>
</div> <!-- /.wrapper -->

<!-- Scripts base -->
<script src="<?= base_url('public/static/js/app.js') ?>"></script>

<style>
    .toast-container {
        margin-top: 50px !important;
        z-index: 1080 !important;
    }

    .toast {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        border-radius: 0.5rem;
        font-size: 0.95rem;
        padding: 0.5rem 1rem;
        opacity: 0.95;
    }
</style>

<?php if (session()->getFlashdata()): ?>
    <div aria-live="polite" aria-atomic="true" class="position-relative">
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <?php
            $toastTypes = [
                'success' => 'bg-success text-white',
                'error' => 'bg-danger text-white',
                'warning' => 'bg-warning text-dark',
                'info' => 'bg-info text-dark',
            ];

            foreach ($toastTypes as $type => $class):
                if (session()->getFlashdata($type)):
                    ?>
                    <div class="toast align-items-center <?= $class ?> border-0 mb-2" role="alert" aria-live="assertive"
                        aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                <?= esc(session()->getFlashdata($type)) ?>
                            </div>

                        </div>
                    </div>
                    <?php
                endif;
            endforeach;
            ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.map(function (toastEl) {
                const toast = new bootstrap.Toast(toastEl, {
                    delay: 4000
                });
                toast.show();
            });
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