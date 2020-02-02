<textarea @if($row->required == 1) required @endif class="form-control" name="{{ $row->field }}" 
  @if(isset($options->maxlength)) maxlength="{{ $options->maxlength }}" @endif
  rows="{{ $options->display->rows ?? 5 }}">{{ old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? '') }}</textarea>
