<div class="form-group">
    <div class="row">
        <div class="col-md-3">
            <label for="first-name-vertical">{{ $label }}</label>
            <input type="text"
                   {{ $attributes->merge(['class' => 'form-control '.$class]) }}
                   name="{{ $name }}"
                   value="{{ empty($value) ? empty(old($name)) ? '' : old($name) : $value }}"
                    {{ $numeric ? 'onkeyup=setNumber(this);' : '' }}
            />
        </div>
        <div class="col-md-3">
            <label for="first-name-vertical">{{ $label2 }}</label>
            <input type="text"
                {{ $attributes->merge(['class' => 'form-control '.$class2]) }}
                name="{{ $name2 }}"
               value="{{ empty($value2) ? empty(old($name2)) ? '' : old($name2) : $value2 }}"
                {{ $numeric ? 'onkeyup=setNumber(this);' : '' }}
            />
        </div>
    </div>
</div>
