@if(isset($dataTypeContent->{$row->field}))
@if(json_decode($dataTypeContent->{$row->field}) !== null)
@foreach(json_decode($dataTypeContent->{$row->field}) as $file)
<div data-field-name="{{ $row->field }}">
  <video width="100%" controls
    src="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link_h264) ?: '' }}"></video>
  <br>
  <a class="fileType" target="_blank"
    href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}"
    data-file-name="{{ $file->original_name }}" data-id="{{ $dataTypeContent->id }}">
    {{ $file->original_name ?: '' }}
  </a>
  <a href="#" class="voyager-x remove-multi-file"></a>
  <br>
  @php
  $name2 = (array)$file;
  @endphp
  @if (isset($name2['original_name_h264']))
  <a class="fileType" target="_blank"
    href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link_h264) ?: '' }}"
    data-file-name="{{ $file->original_name_h264 }}" data-id="{{ $dataTypeContent->id }}">
    {{ $file->original_name_h264 ?: '' }}
  </a>
  @endif
</div>
@endforeach
@else
<div data-field-name="{{ $row->field }}">
  <a class="fileType" target="_blank"
    href="{{ Storage::disk(config('voyager.storage.disk'))->url($dataTypeContent->{$row->field}) }}"
    data-file-name="{{ $dataTypeContent->{$row->field} }}" data-id="{{ $dataTypeContent->id }}">>
    Download
  </a>
  <a href="#" class="voyager-x remove-single-file"></a>
</div>
@endif
@endif
<input @if($row->required == 1 && !isset($dataTypeContent->{$row->field})) required @endif
type="file"
name="{{ $row->field }}">