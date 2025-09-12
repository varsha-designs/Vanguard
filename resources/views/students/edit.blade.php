@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Edit Student</h1>

    <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- 1. Personal Details -->
        <div class="card mb-4">
            <div class="card-header">Personal Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $student->full_name) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $student->email) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $student->whatsapp_number) }}" class="form-control" maxlength="10" minlength="10">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" value="{{ old('dob', $student->dob) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3" required>{{ old('address', $student->address) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Education Details -->
        <div class="card mb-4">
            <div class="card-header">Education Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">College / University</label>
                        <input type="text" name="college" value="{{ old('college', $student->college) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Degree / Branch</label>
                        <input type="text" name="degree" value="{{ old('degree', $student->degree) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Year of Passing</label>
                        <input type="text" name="year_of_passing" value="{{ old('year_of_passing', $student->year_of_passing) }}" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Professional Details -->
        <div class="card mb-4">
            <div class="card-header">Professional Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Company</label>
                        <input type="text" name="company" value="{{ old('company', $student->company) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <input type="text" name="role" value="{{ old('role', $student->role) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Years of Experience</label>
                        <input type="text" name="experience" value="{{ old('experience', $student->experience) }}" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

                <!-- Preview Section -->
        <div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Uploaded Files Preview</span>
        <button type="button" class="btn btn-success btn-sm" id="addDocumentBtn">Add File</button>
    </div>
    <div class="card-body" id="filesPreview">
        @if(isset($student) && $student->documents->count())
            @foreach($student->documents as $document)
                <div class="flex items-center justify-between mb-2 p-2 border rounded">
                    <span>{{ $document->file_name }}</span>
                    <div class="space-x-2 mb-2">
                        <a href="{{ Storage::url($document->upload_file) }}" target="_blank" class="btn btn-primary btn-sm">View</a>

                        <form action="{{ route('student.documents.destroy', $document->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this file?');">
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
<div id="uploadedFilesContainer"></div>

<!-- Modal for Adding File -->
<div class="modal fade" id="addFileRowModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Upload File</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <label>Upload File</label>
        <input type="file" id="modalUploadFile" class="form-control">
        <label class="mt-2">File Name</label>
        <select id="modalFileNameSelect" class="form-control">
            <option value="">Select File Type</option>
            <option value="id">ID</option>
            <option value="aadhar">Aadhaar</option>
            <option value="add">➕ Add New</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" id="saveModalFileBtn" class="btn btn-primary">OK</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Adding New File Type -->
<div class="modal fade" id="addFileModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New File Type</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="text" id="newFileType" class="form-control" placeholder="Enter file type">
      </div>
      <div class="modal-footer">
        <button type="button" id="saveFileTypeBtn" class="btn btn-primary">OK</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

<!-- JS Scripts (place before </body>) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function () {
    const $filesPreview = $('#filesPreview');
    const $uploadedFilesContainer = $('#uploadedFilesContainer');

    // 1️⃣ Open modal to add file
    $('#addDocumentBtn').on('click', function() {
        $('#addFileRowModal').modal('show');
    });

    // 2️⃣ Save file to preview + hidden inputs
    $('#saveModalFileBtn').on('click', function() {
        const file = $('#modalUploadFile')[0].files[0];
        const fileType = $('#modalFileNameSelect').val();
        const fileTypeText = $('#modalFileNameSelect option:selected').text();

        if (!file || !fileType) {
            alert("Please select file and type.");
            return;
        }

        // Remove placeholder
        $filesPreview.find('p.text-muted').remove();

        // Preview
        $filesPreview.append('<div class="mb-2">File: ' + file.name + ', Type: ' + fileTypeText + '</div>');

        // Hidden inputs for form submission
        const index = $uploadedFilesContainer.children().length;
        $uploadedFilesContainer.append(`
            <input type="hidden" name="file_name[${index}]" value="${fileType}">
            <input type="file" name="upload_file[${index}]" style="display:none;">
        `);

        // Assign file to hidden input using DataTransfer
        const dt = new DataTransfer();
        dt.items.add(file);
        $uploadedFilesContainer.find('input[type=file]').last()[0].files = dt.files;

        // Clear modal inputs
        $('#modalUploadFile').val('');
        $('#modalFileNameSelect').val('');

        // ✅ Close modal
        $('#addFileRowModal').modal('hide');
    });

    // 3️⃣ Add new file type
    $('#saveFileTypeBtn').on('click', function() {
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
    $('#modalFileNameSelect').on('change', function() {
        if ($(this).val() === 'add') {
            $(this).val('');
            $('#addFileModal').modal('show');
        }
    });
});
</script>


        <!-- Submit Button -->
        <div class="mb-5">
            <button type="submit" class="btn btn-primary">Update Student</button>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
