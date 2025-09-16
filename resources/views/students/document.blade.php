@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Manage Uploaded Files</h1>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Uploaded Files Preview</span>
            <button type="button" class="btn btn-success btn-sm" id="addDocumentBtn">Add File</button>
        </div>
        <div class="card-body" id="filesPreview">
            @if(isset($student) && $student->documents->count())
                @foreach($student->documents as $document)
                    <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                        <span>{{ $document->file_name }}</span>
                        <div>
                            <a href="{{ Storage::url($document->upload_file) }}" target="_blank" class="btn btn-primary btn-sm">View</a>

                            <form action="{{ route('students.documents.destroy', $document->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-muted">No files added yet.</p>
            @endif
        </div>
    </div>

    <!-- Hidden container for form submission -->
    <form id="documentForm" method="POST" action="{{ route('students.documents.store', $student->id) }}" enctype="multipart/form-data">
        @csrf
        <div id="uploadedFilesContainer"></div>
        <button type="submit" class="btn btn-primary">Save Uploaded Files</button>
    </form>

</div>

<!-- Modal for Adding File -->
<div class="modal fade" id="addFileRowModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Upload File</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label>Upload File</label>
        <input type="file" id="modalUploadFile" class="form-control">
        <label class="mt-2">File Name</label>
        <select id="modalFileNameSelect" class="form-select">
            <option value="">Select File Type</option>
            <option value="id">ID</option>
            <option value="aadhar">Aadhaar</option>
            <option value="add">➕ Add New</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" id="saveModalFileBtn" class="btn btn-primary">OK</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Adding New File Type -->
<div class="modal fade" id="addFileModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New File Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" id="newFileType" class="form-control" placeholder="Enter file type">
      </div>
      <div class="modal-footer">
        <button type="button" id="saveFileTypeBtn" class="btn btn-primary">OK</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    const $filesPreview = $('#filesPreview');
    const $uploadedFilesContainer = $('#uploadedFilesContainer');

    // Open modal to add file
    $('#addDocumentBtn').click(function() {
        $('#addFileRowModal').modal('show');
    });

    // Save file to preview + hidden inputs
    $('#saveModalFileBtn').click(function() {
        const file = $('#modalUploadFile')[0].files[0];
        const fileType = $('#modalFileNameSelect').val();
        const fileTypeText = $('#modalFileNameSelect option:selected').text();

        if (!file || !fileType) { alert("Please select file and type."); return; }

        $filesPreview.find('p.text-muted').remove();
        $filesPreview.append('<div class="mb-2">File: ' + file.name + ', Type: ' + fileTypeText + '</div>');

        const index = $uploadedFilesContainer.find('input[type=file]').length;
        const $hiddenFileInput = $('<input type="file" name="upload_file['+index+']" style="display:none;">');
        const $hiddenFileName = $('<input type="hidden" name="file_name['+index+']" value="'+fileType+'">');

        const dt = new DataTransfer();
        dt.items.add(file);
        $hiddenFileInput[0].files = dt.files;

        $uploadedFilesContainer.append($hiddenFileName).append($hiddenFileInput);

        $('#modalUploadFile').val('');
        $('#modalFileNameSelect').val('');
        $('#addFileRowModal').modal('hide');
    });

    // Add new file type
    $('#saveFileTypeBtn').click(function() {
        const newType = $('#newFileType').val().trim();
        if (!newType) return;
        const value = newType.toLowerCase().replace(/\s+/g,'_');
        const option = $('<option>').val(value).text(newType);
        option.insertBefore($('#modalFileNameSelect option[value="add"]'));
        $('#modalFileNameSelect').val(value);
        $('#newFileType').val('');
        $('#addFileModal').modal('hide');
    });

    // Open "Add New Type" modal
    $('#modalFileNameSelect').change(function() {
        if ($(this).val() === 'add') {
            $(this).val('');
            $('#addFileModal').modal('show');
        }
    });

    // Make sure hidden files are included when form submits
    $('#documentForm').submit(function() {
        $uploadedFilesContainer.find('input[type=file]').each(function(){
            if(this.files.length > 0){
                // File is already included in the form submission
            } else {
                // Remove empty file inputs to avoid issues
                $(this).remove();
            }
        });
    });
});
</script>
@endsection
