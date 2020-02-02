<?php

namespace TCG\Voyager\FormFields;

class VideoHandler extends AbstractHandler
{
    protected $codename = 'video';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('voyager::formfields.video', [
            'row'             => $row,
            'options'         => $options,
            'dataType'        => $dataType,
            'dataTypeContent' => $dataTypeContent,
        ]);
    }
}
