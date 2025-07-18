<div class="form-group">
    <label class="d-block font-weight-bold mb-2">{{ $field['label'] }}</label>

    <div class="upload-container border rounded p-3">
        <!-- Current file display -->
        @if(isset($entry) && $entry->exists && $entry->relationLoaded('person') && $entry->person->{$field['name']})
        <div class="uploaded-file">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="text-success">
                    <i class="la la-check-circle"></i> Uploaded
                </span>
                <a href="javascript:void(0)"
                   class="text-danger clear-upload"
                   data-field="{{ $field['name'] }}">
                    <i class="la la-trash"></i> Clear
                </a>
            </div>
            <img src="{{ asset('storage/' . $entry->person->{$field['name']}) }}"
                 class="img-fluid rounded border"
                 style="max-height: 150px;">
        </div>
        @endif

        <!-- Upload area -->
        <div class="upload-area text-center py-3 @if(isset($entry) && $entry->person->{$field['name']}) d-none @endif">
            <label for="{{ $field['name'] }}" class="btn btn-light border">
                <i class="la la-upload"></i> Choose File
            </label>
            <div class="small text-muted mt-2">
                @if(isset($entry) && $entry->exists && $entry->relationLoaded('person') && $entry->person->{$field['name']})
                    {{ basename($entry->person->{$field['name']}) }}
                @else
                    No file selected
                @endif
            </div>
        </div>

        <input type="file"
               name="{{ $field['name'] }}"
               id="{{ $field['name'] }}"
               class="d-none"
               accept="image/*">
    </div>
</div>

@push('crud_fields_scripts')
<script>
    // Handle file selection
    document.getElementById('{{ $field['name'] }}').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const container = this.closest('.upload-container');
        const uploadArea = container.querySelector('.upload-area');
        const uploadedFile = container.querySelector('.uploaded-file');

        if (file) {
            // Show file name
            uploadArea.querySelector('.text-muted').textContent = file.name;

            // If image, show preview
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (!uploadedFile) {
                        const newUploadedDiv = document.createElement('div');
                        newUploadedDiv.className = 'uploaded-file';
                        newUploadedDiv.innerHTML = `
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-success">
                                    <i class="la la-check-circle"></i> Uploaded
                                </span>
                                <a href="javascript:void(0)"
                                   class="text-danger clear-upload"
                                   data-field="{{ $field['name'] }}">
                                    <i class="la la-trash"></i> Clear
                                </a>
                            </div>
                            <img src="${e.target.result}"
                                 class="img-fluid rounded border"
                                 style="max-height: 150px;">
                        `;
                        container.insertBefore(newUploadedDiv, uploadArea);
                    } else {
                        uploadedFile.querySelector('img').src = e.target.result;
                    }
                    uploadArea.classList.add('d-none');
                    container.querySelector('.uploaded-file').classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        }
    });

    // Handle clear button
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('clear-upload')) {
            const fieldName = e.target.dataset.field;
            const container = e.target.closest('.upload-container');
            const input = container.querySelector('input[type="file"]');

            // Reset file input
            input.value = '';

            // Add clear flag
            let clearInput = container.querySelector(`input[name="clear_${fieldName}"]`);
            if (!clearInput) {
                clearInput = document.createElement('input');
                clearInput.type = 'hidden';
                clearInput.name = `clear_${fieldName}`;
                clearInput.value = '1';
                container.appendChild(clearInput);
            }

            // Toggle visibility
            container.querySelector('.upload-area').classList.remove('d-none');
            container.querySelector('.uploaded-file').classList.add('d-none');
            container.querySelector('.upload-area .text-muted').textContent = 'No file selected';
        }
    });
</script>
@endpush
