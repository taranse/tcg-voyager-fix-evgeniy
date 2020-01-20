<div class="wrapper">
    <div class="header">
        <input type="text" placeholder="Введите" class="todo_input">
        <span class="addBtn" onclick="newElement()">Добавить</span>
    </div>

    <input type="hidden" name="{{ $row->field }}" data-name="{{ $row->display_name }}">
</div>
