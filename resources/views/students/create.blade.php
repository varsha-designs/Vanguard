@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">New Student</h1>

    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 1. Personal Details -->
        <div class="card mb-4">
            <div class="card-header">Personal Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" class="form-control" maxlength="10"
           minlength="10"  title="Please enter a valid 10-digit WhatsApp number">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" required>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3" required></textarea>
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
                        <input type="text" name="college" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Degree / Branch</label>
                        <input type="text" name="degree" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Year of Passing</label>
                        <input type="text" name="year_of_passing" class="form-control" required>
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
                        <input type="text" name="company" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <input type="text" name="role" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Years of Experience</label>
                        <input type="text" name="experience" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Documentation -->

      <!-- 4. Documents -->
<div class="card mb-4">
    <div class="card-header">Documents</div>
    <div class="card-body">
        <div class="form-row">
            <!-- Upload file -->
            <div class="form-group col-md-6">
                <label>Upload File</label>
                <!-- ✅ Make sure the name matches controller's $request->file('upload_file') -->
                <input type="file" name="upload_file" class="form-control" required>
            </div>

            <!-- File name dropdown -->
            <div class="form-group col-md-6">
                <label>File Name</label>
                <select name="file_name" id="fileNameSelect" class="form-control" required>
                    <option value="">Select File Type</option>
                    <option value="id">ID</option>
                    <option value="aadhar">Aadhaar</option>
                    <option value="add">➕ Add New</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 4 Modal -->
<div class="modal fade" id="addFileModal" tabindex="-1" role="dialog" aria-labelledby="addFileModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFileModalLabel">Add New File Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label>File Type Name</label>
        <input type="text" id="newFileType" class="form-control" placeholder="Enter file type">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" id="saveFileTypeBtn" class="btn btn-primary">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- jQuery + Bootstrap 4 JS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function () {
    const $select = $('#fileNameSelect');
    const $modal = $('#addFileModal');
    const $saveBtn = $('#saveFileTypeBtn');
    const $newFileTypeInput = $('#newFileType');

    // Open modal when "Add New" selected
    $select.on('change', function() {
        if ($(this).val() === 'add') {
            $(this).val(''); // reset dropdown selection
            $modal.modal('show'); // show modal
        }
    });

    // Save new file type dynamically
    $saveBtn.on('click', function() {
        const newType = $newFileTypeInput.val().trim();
        if (!newType) return;

        // ✅ Create new option and insert before "Add New"
        const $option = $('<option>')
            .val(newType.toLowerCase().replace(/\s+/g,'_'))
            .text(newType);
        $option.insertBefore($select.find('option[value="add"]'));

        // ✅ Select the newly added option
        $select.val($option.val());

        // ✅ Clear input and hide modal
        $newFileTypeInput.val('');
        $modal.modal('hide');
    });
});
</script>


        <!-- Submit Button -->
        <div class="mb-5">
            <button type="submit" class="btn btn-primary">Create Student</button>
        </div>
    </form>
</div>
@endsection
