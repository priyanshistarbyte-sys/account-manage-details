<form method="POST"  action="{{  route('account.store') }}" enctype="multipart/form-data">
    @csrf
     <div class="modal-body">
        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="name" class = "form-label">Name</label>
                <input type="name" name="name" id="name" class="form-control" placeholder="Enter Name" required>
            </div>
            <div class="mb-3 col-md-6">
                <label for="email" class = "form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" required>
            </div>
            <div class="mb-3 col-md-6">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
            </div>
             <div class="mb-3 col-md-6">
                <label for="register_email" class="form-label">Register Email</label>
                <input type="email" name="register_email" id="register_email" class="form-control" placeholder="Enter Register Email" required>
            </div>
            <div class="mb-3 col-md-6">
                <label for="register_mobile_no" class="form-label">Register Mobile No</label>
                <input type="number" name="register_mobile_no" id="register_mobile_no" class="form-control" placeholder="Enter Register Mobile No" required maxlength="10" >
            </div>
            <div class="mb-3 col-md-6">
                <label for="authenticator_code" class="form-label">Authenticator Code</label>
                <input type="number" name="authenticator_code" id="authenticator_code" class="form-control" placeholder="Enter Authenticator Code" required >
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <textarea name="location" id="location" class="form-control"></textarea>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="icon" class="form-label">Icon</label>
                    <div class="file-input-wrapper">
                        <input type="file" name="icon" id="icon" class="file-input" accept="image/*" onchange="previewImage(this, 'icon-preview')">
                        <label for="icon" class="file-input-label">
                            <img id="icon-preview" class="file-preview" alt="Icon preview">
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
                        <label for="banner" class="file-input-label">
                            <img id="banner-preview" class="file-preview" alt="Banner preview">
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
        <button class="btn btn-primary" type="submit">{{__('Submit')}}</button>
    </div>
  </form>