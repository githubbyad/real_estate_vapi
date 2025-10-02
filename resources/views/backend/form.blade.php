<x-backend.layout title="{{ $data['title'] }}" icon="{{ $data['icon'] }}">    
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">

            {{-- page title --}}
            <h6 class="fw-semibold">{{ $data['subtitle'] }}</h6>

            {{-- form here (see SettingController "edit") --}}
            <div class="card p-4">
                {{-- form start --}}                
            <form action="{{ $data['form_action'] }}" method="{{ $data['form_method'] }}">
                @csrf
                @if (in_array($data['form_method'], ['PUT', 'PATCH', 'DELETE']))
                    @method($data['form_method'])
                @endif
                <div class="input-group">
                    @foreach ($data['form_fields'] as $field)

                    {{-- input field --}}
                    @if($field['type'] == 'input')
                    <x-form.input 
                        type="{{ $field['type'] ?? 'text' }}"
                        name="{{ $field['name'] }}"
                        label="{{ $field['label'] ?? '' }}"
                        :value="old($field['name'], $field['value'] ?? '')"
                        :required="$field['required'] ?? false"                        
                    />
                    @endif

                    {{-- checkbox field --}}
                    @if($field['type'] == 'checkbox')
                    <x-form.checkbox 
                        name="{{ $field['name'] }}"
                        label="{{ $field['label'] ?? '' }}"
                        :value="old($field['name'], $field['value'] ?? '')"
                        :required="$field['required'] ?? false"                        
                    />
                    @endif

                    {{-- password field --}}
                    @if($field['type'] == 'password')
                    <x-form.password 
                        name="{{ $field['name'] }}"
                        label="{{ $field['label'] ?? '' }}"
                        :required="$field['required'] ?? false"                        
                    />
                    @endif

                    {{-- textarea field --}}
                    @if($field['type'] == 'textarea')
                    <x-form.textarea 
                        name="{{ $field['name'] }}"
                        label="{{ $field['label'] ?? '' }}"
                        :value="old($field['name'], $field['value'] ?? '')"
                        :required="$field['required'] ?? false"                        
                    />
                    @endif

                    {{-- select field --}}
                    @if($field['type'] == 'select')
                    <x-form.select 
                        id="{{ $field['id'] ?? $field['name'] }}"
                        name="{{ $field['name'] }}"
                        label="{{ $field['label'] ?? '' }}"
                        :options="$field['options'] ?? []"
                        :value="old($field['name'], $field['value'] ?? '')"
                        :required="$field['required'] ?? false"                        
                    />
                    @endif

                    {{-- radio field --}}
                    @if($field['type'] == 'radio')
                    <x-form.radio 
                        id="{{ $field['id'] ?? $field['name'] . '_' . $field['value'] }}"
                        name="{{ $field['name'] }}"
                        label="{{ $field['label'] ?? '' }}"
                        value="{{ $field['value'] ?? '' }}"
                        :checked="old($field['name'], $field['checked'] ?? false)"
                        :required="$field['required'] ?? false"                        
                    />
                    @endif

                    {{-- add more field types as needed --}}                    
                    @endforeach

                    {{-- submit button --}}
                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <x-form.button type="submit" class="btn btn-theme px-4" label="{{ $data['form_button_text'] ?? 'Submit' }}" />
                        {{-- cancel button --}}                        
                        <x-form.cancel-button href="{{ $data['cancel']['url'] ?? url()->previous() }}" class="btn btn-secondary px-4 ms-2">
                            {{ $data['cancel']['text'] ?? 'Cancel' }}
                        </x-form.cancel-button>
                    </div>
                </div>
            </form>
            {{-- form end --}}
            </div>
        </div>
    </div>
</x-backend.layout>