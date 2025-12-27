<form method="POST" action="{{ route('account.update', $account->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
     <div class="modal-body">
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="name" class = "form-label">Name</label>
                <input type="name" name="name" id="name" class="form-control" placeholder="Enter Name" value="{{ $account->name }}" required>
            </div>
            <div class="mb-3 col-md-6">
                <label for="email" class = "form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" value="{{ $account->email }}" required>
            </div>
            <div class="mb-3 col-md-6">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" value="{{ old('password', $account->password) }}" class="form-control" placeholder="Enter Password" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fa fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
             <div class="mb-3 col-md-6">
                <label for="register_email" class="form-label">Register Email</label>
                <input type="email" name="register_email" id="register_email" class="form-control" placeholder="Enter Register Email" value="{{ $account->register_email }}" required>
            </div>
            <div class="mb-3 col-md-6">
                <label for="register_mobile_no" class="form-label">Register Mobile No</label>
                <input type="number" name="register_mobile_no" id="register_mobile_no" class="form-control" placeholder="Enter Register Mobile No" value="{{ $account->register_mobile_no }}" required maxlength="10" >
            </div>
            <div class="mb-3 col-md-6">
                <label for="authenticator_code" class="form-label">Authenticator Code</label>
                <input type="number" name="authenticator_code" id="authenticator_code" class="form-control" placeholder="Enter Authenticator Code" value="{{ $account->authenticator_code }}" required >
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <textarea name="location" id="location" class="form-control">{{ $account->location }}</textarea>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="icon" class="form-label">Icon</label>
                    <div class="file-input-wrapper">
                        <input type="file" name="icon" id="icon" class="file-input" accept="image/*" onchange="previewImage(this, 'icon-preview')">
                        <label for="icon" class="file-input-label {{ $account->icon ? 'has-file' : '' }}">
                            <img id="icon-preview" class="file-preview" src="{{ $account->icon ? asset('storage/' . $account->icon) : '' }}" alt="Icon preview" style="{{ $account->icon ? 'display: block;' : 'display: none;' }}">
                            <i class="fas fa-cloud-upload-alt file-input-icon"></i>
                            <span class="file-input-text">Choose icon file or drag and drop</span>
                        </label>
                    </div>
                </div>
            </div>
             <div class="col-md-6">
                <div class="form-group">
                    <label for="banner" class="form-label">Banner</label>
                    <div class="file-input-wrapper">
                        <input type="file" name="banner" id="banner" class="file-input" accept="image/*" onchange="previewImage(this, 'banner-preview')">
                        <label for="banner" class="file-input-label {{ $account->banner ? 'has-file' : '' }}">
                            <img id="banner-preview" class="file-preview" src="{{ $account->banner ? asset('storage/' . $account->banner) : '' }}" alt="Banner preview" style="{{ $account->banner ? 'display: block;' : 'display: none;' }}">
                            <i class="fas fa-cloud-upload-alt file-input-icon"></i>
                            <span class="file-input-text">Choose banner file or drag and drop</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <button class="btn btn-primary" type="submit">{{__('Update')}}</button>
    </div>
</form>


<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
});
</script>