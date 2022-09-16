<div>
    <!-- Modal -->
<div class="modal fade" id="modalResumen" tabindex="-1" aria-labelledby="modalResumenLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalResumenLabel">Resumen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input disabled type="text" class="form-control" id="nombre" wire:model='nombre' >
                </div>
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input disabled type="text" class="form-control" id="correo" wire:model='email'>
                </div>
                <div class="form-group">
                    <label for="celular">Celular</label>
                    <input disabled type="text" class="form-control" id="celular" wire:model='celular'>
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click='modificarPerfil' type="button" class="btn btn-secondary" data-dismiss="modal">Modificar Información</button>
                <button wire:click='comprar' type="button" class="btn btn-primary">Continuar</button>
            </div>
        </div>
    </div>
</div>
  
</div>
  