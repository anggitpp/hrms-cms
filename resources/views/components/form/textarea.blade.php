<div class="form-group">
    <label class="form-label">{{ $label }} {!! $required ? "<span style='color: red'> *</span>" : "" !!}</label>
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->merge(['class' => 'form-control '.$class]) }}>{{ empty($value) ? empty(old($name)) ? '' : old($name) : $value }}</textarea>
</div>
