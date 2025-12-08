<?= $this->include('layout/header') ?>

<div class="card">
    <div class="card-header">
        <h3>Asignar Permisos al Rol: **<?= esc($rol['nombre_rol']) ?>**</h3>
        <p class="text-muted mb-0">Marque las casillas para otorgar o revocar capacidades a este rol. Los cambios se
            guardarán en la base de datos.</p>
    </div>

    <div class="card-body">
        <form action="<?= site_url('roles/update/' . $rol['id_rol']) ?>" method="post">
            <?= csrf_field() ?>

            <?php foreach ($permisos_agrupados as $modulo => $permisos): ?>
                <div class="mb-4 p-3 border rounded shadow-sm">
                    <h5 class="border-bottom pb-1 mb-3 text-primary">
                        <i class="bi bi-folder-open me-2"></i><?= esc($modulo) ?>
                    </h5>

                    <div class="row">
                        <?php foreach ($permisos as $permiso): ?>
                            <?php
                            $isChecked = in_array($permiso['clave'], $permisos_asignados);
                            ?>

                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permisos[]"
                                        value="<?= esc($permiso['clave']) ?>" id="permiso_<?= esc($permiso['id_permiso']) ?>"
                                        <?= $isChecked ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="permiso_<?= esc($permiso['id_permiso']) ?>">
                                        **<?= esc($permiso['nombre_permiso']) ?>**
                                    </label>
                                    <small class="text-muted d-block ms-4 text-break">Clave:
                                        `<?= esc($permiso['clave']) ?>`</small>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="d-flex justify-content-center gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-save me-1"></i> Guardar Permisos
                </button>
                <a href="<?= site_url('roles') ?>" class="btn btn-secondary btn-lg">
                    <i class="bi bi-arrow-left-circle me-1"></i> Volver a Roles
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->include('layout/footer') ?>