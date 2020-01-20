<?php

namespace TCG\Voyager\FormFields;

class TodoListHandler extends AbstractHandler
{
    protected $codename = 'todo_list';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.todo_list', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}
