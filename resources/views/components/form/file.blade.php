<div class="form-group">
    <label for="customFile1">{{ $label }} {!! $required ? "<span style='color: red'> *</span>" : "" !!}</label>
    <div class="custom-file">
        <div id="fileExist_{{ $name }}" class="d-flex" style="{{ $value ? '' : 'display: none !important' }}">
            <a href="{{ asset('storage'.$value) }}" download>{!! $value ? getIcon($value, 'fa-3x') : '' !!}</a>
            &nbsp;&nbsp;
            <div class="btn btn-primary mr-75 mb-0 waves-effect waves-float waves-light btnRemove" id="btnFile_{{ $name  }}">Remove</div>
        </div>
        <div id="fileEmpty_{{ $name }}" style="{{ $value ? 'display: none' : '' }}">
            <input type="file" {!! $imageOnly ? "accept='image/*'" : "" !!} class="custom-file-input" id="{{ $name }}" name="{{ $name }}">
            <label class="custom-file-label" for="{{ $name }}">Choose your file</label>
        </div>
    </div>
    <input type="hidden" id="exist_{{ $name }}" name="exist_{{ $name }}" value="{{ $value }}"/>
</div>
