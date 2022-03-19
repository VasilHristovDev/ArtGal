@php
    $field['wrapper'] = $field['wrapper'] ?? ($field['wrapperAttributes'] ?? []);
    $field['wrapper']['data-init-function'] = $field['wrapper']['data-init-function'] ?? 'bpFieldInitUploadMultipleElement';
    $field['wrapper']['data-field-name'] = $field['wrapper']['data-field-name'] ?? $field['name'];
@endphp


@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
@include('crud::fields.inc.translatable_icon')


@if (isset($field['value']))
    @php
        if (is_string($field['value'])) {
            $values = json_decode($field['value'], true) ?? [];
        } else {
            $values = $field['value'];
        }
    @endphp
    @if (count($values))
        <div class="well well-sm existing-file row align-items-center justify-content-start">
            @foreach ($values as $key => $file_path)
                <div class="file-preview m-2 col-12 col-sm-3">
                    @if (isset($field['temporary']))
                        <a target="_blank"
                           href="{{ isset($field['disk']) ? asset(\Storage::disk($field['disk'])->temporaryUrl($file_path['url'], Carbon\Carbon::now()->addMinutes($field['temporary']))) : asset($file_path['url']) }}">{{ $file_path['url'] }}</a>
                    @else
                        <a target="_blank"
                           href="{{ isset($field['disk']) ? asset(\Storage::disk($field['disk'])->url($file_path['url'])) : asset($file_path['url']) }}">
                            <img src="{{ isset($field['disk']) ? asset(\Storage::disk($field['disk'])->url($file_path['url'])) : asset($file_path['url']) }}"
                                 alt="$file_path['url']" style="max-width: 100px; max-height: 100px">

                        </a>
                    @endif
                    <a href="#" class="btn btn-light btn-sm align-top file-clear-button" title="Clear file"
                       data-filename="{{ $file_path['url'] }}"><i class="la la-remove"></i></a>
                    <div class="clearfix"></div>
                </div>
            @endforeach
        </div>
    @endif
@endif

<input name="{{ $field['name'] }}[]" type="hidden" value="">
<div class="backstrap-file mt-2">
    <div class="preview-images">
        <div class="row my-2"></div>
    </div>
    <input type="file" name="{{ $field['name'] }}[]" value="@if (old(square_brackets_to_dots($field['name']))) old(square_brackets_to_dots($field['name'])) @elseif (isset($field['default'])) $field['default'] @endif"
           @include('crud::fields.inc.attributes', ['default_class'=> isset($field['value']) &&
       $field['value']!=null?'file_input backstrap-file-input':'file_input backstrap-file-input'])
           multiple
    >
    <label class="backstrap-file-label" for="customFile"></label>
</div>

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('crud::fields.inc.wrapper_end')

@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    @push('crud_fields_scripts')

        <script>
            function bpFieldInitUploadMultipleElement(element) {
                var fieldName = element.attr('data-field-name');
                var clearFileButton = element.find(".file-clear-button");
                var fileInput = element.find("input[type=file]");
                var inputLabel = element.find("label.backstrap-file-label");
                const previewParent = element.find(".preview-images .row");
                clearFileButton.click(function(e) {
                    e.preventDefault();
                    var container = $(this).parent().parent();
                    var parent = $(this).parent();
                    // remove the filename and button
                    parent.remove();
                    // if the file container is empty, remove it
                    if ($.trim(container.html()) == '') {
                        container.remove();
                    }
                    $("<input type='hidden' name='clear_" + fieldName + "[]' value='" + $(this).data('filename') + "'>")
                        .insertAfter(fileInput);
                });

                fileInput.change(function() {
                    previewParent.empty();
                    let previewImages = fileInput.get(0).files;
                    previewImages.forEach(function(previewImage, index) {
                        let image = new Image();
                        image.src = URL.createObjectURL(previewImage);
                        let imageTemplate =
                            `<div class="col-md-2" style="text-align: center;"><img src="${image.src}" style="max-width: 100%; max-height: 55px; vertical-align: unset;"></div>`;
                        previewParent.append(imageTemplate);


                    });
                    inputLabel.html("Files selected.");
                    // remove the hidden input, so that the setXAttribute method is no longer triggered
                    $(this).next("input[type=hidden]:not([name='clear_" + fieldName + "[]'])").remove();
                });
            }
        </script>
    @endpush
@endif
