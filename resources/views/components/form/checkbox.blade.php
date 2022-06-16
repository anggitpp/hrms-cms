<div class="form-group">
    <label class="d-block mb-1">{{ $label }} {!! $required ? "<span style='color: red'> *</span>" : "" !!}</label>
    @foreach($datas as $key => $values)
    <div class="custom-control custom-checkbox custom-control-inline">
        <input type="checkbox"
               class="custom-control-input"
               @if($event)
               onclick="{{ $event }}"
               @endif
               value="{{ $key }}"
               name="{{ $name."[$key]." }}"
               id="{{ $name."[$key]." }}">
        <label class="custom-control-label" for="{{ $name."[$key]." }}">{{ $values }}</label>
    </div>
    @endforeach
</div>
