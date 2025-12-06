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
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>


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
            window.datatableInstance = datatable;

            const headerRow = table.querySelector("thead tr");
            if (headerRow) {
                headerRow.style.backgroundColor = "#1cbb8c";
            }

            const sorters = table.querySelectorAll(".datatable-sorter");
            sorters.forEach(el => {
                el.style.color = "#222e3c";
            });

            const searchInput = document.querySelector('.datatable-input');
            if (searchInput) {
                searchInput.setAttribute("title", "Buscar por cualquier campo");
                setTimeout(() => searchInput.focus(), 500);
            }

            document.addEventListener('keydown', (e) => {
                const currentTime = new Date().getTime();
                searchInput.focus();
            });
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        // Limpia texto desde un TD/TH (DOM), conservando caracteres especiales
        function getNodeText(node) {
            if (!node) return "";
            // Prioriza textContent para caracteres especiales correctos
            return node.textContent ? node.textContent.trim() : "";
        }

        // Obtiene las filas actualmente visibles en la tabla (post-filtro)
        function getVisibleRows(tableEl) {
            // Simple-DataTables oculta filas con display:none y/o clase "hidden"
            const allRows = Array.from(tableEl.querySelectorAll("tbody tr"));
            return allRows.filter(tr => {
                const style = window.getComputedStyle(tr);
                const isHiddenClass = tr.classList.contains("hidden");
                const isDisplayNone = style.display === "none";
                const isVisibilityHidden = style.visibility === "hidden";
                return !(isHiddenClass || isDisplayNone || isVisibilityHidden);
            });
        }

        // Lee encabezados visibles, excluyendo la última columna (Acciones)
        function getHeaders(tableEl) {
            const thList = Array.from(tableEl.querySelectorAll("thead th"));
            return thList.slice(0, Math.max(0, thList.length - 1))
                .map(th => getNodeText(th));
        }

        // Lee celdas visibles (TD) de una fila, excluyendo la última columna
        function getRowDataFromDom(trEl) {
            const tds = Array.from(trEl.querySelectorAll("td"));
            const usefulTds = tds.slice(0, Math.max(0, tds.length - 1)); // excluye Acciones
            return usefulTds.map(td => getNodeText(td));
        }

        const exportBtn = document.getElementById("btnExport");
        if (!exportBtn) return;

        exportBtn.addEventListener("click", function () {
            const datatable = window.datatableInstance;
            if (!datatable) {
                alert("No existe la instancia de la tabla.");
                return;
            }

            const table = document.querySelector("#datatable");
            if (!table) {
                alert("No se encontró la tabla.");
                return;
            }

            // 1) Encabezados
            const headers = getHeaders(table);
            const excelData = [headers];

            // 2) Filas visibles tras el filtro
            const visibleRows = getVisibleRows(table);
            if (visibleRows.length === 0) {
                alert("No hay datos para exportar.");
                return;
            }

            visibleRows.forEach(tr => {
                const row = getRowDataFromDom(tr);
                excelData.push(row);
            });

            // 3) Exportar a Excel
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.aoa_to_sheet(excelData);

            // Ajuste opcional de ancho de columnas
            const colWidths = excelData[0].map((h, i) => ({
                wch: Math.max(...excelData.map(r => (r[i] ? r[i].length : 0))) + 2
            }));
            ws['!cols'] = colWidths;

            XLSX.utils.book_append_sheet(wb, ws, "Datos");
            XLSX.writeFile(wb, "reporte.xlsx");
        });
    });
</script>

</body>

</html>