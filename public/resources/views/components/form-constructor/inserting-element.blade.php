@if ($parents)
<input type="hidden" name="element-parent_table" id="parentTable">
<input type="hidden" name="element-parent_id" id="parentId">
@else
<input type="hidden" name="elementId" id="elementId">
@endif
<p class="mb-2"><b>Вставка элемента</b></p>
<div class="row">
    <div class="col-6">
        <x-form.input form-floating="true" name="element-column" value="12" type="number" label="Размер колонки элемента"></x-form.input>
        <span class="text-muted">*Количество столбцов, занимаемых элементом в 12-колоночной сетке</span>
    </div>
    <div class="col-6">
        <x-form.input form-floating="true" name="element-name" label="Имя элемента во вставке"></x-form.input>
        <span class="text-muted">*Имя латиницей для использования в сценариях (необязательно)</span>
    </div>
</div>