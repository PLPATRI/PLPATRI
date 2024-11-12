<div class="d-flex justify-content-between align-items-center my-4">
    <h5>Definição de números de itens apresentados nas tabelas</h5>
    <div class="form-group d-flex">
        <input type="number" wire:model="quantidade" min="0" class="form-control mx-2" placeholder="10"
            wire:change="alterTabela">
    </div>
</div>
