<!-- Student View Modal Template - Enhanced -->
<div class="modal fade" id="studentViewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-graduate"></i>
                    Complete Student Profile
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Navigation Tabs -->
                <ul class="nav nav-tabs mb-0" id="studentViewTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab">
                            <i class="fas fa-user"></i> Personal & Course
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="parent-tab" data-bs-toggle="tab" data-bs-target="#parent" type="button" role="tab">
                            <i class="fas fa-users"></i> Parent Details
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="enrollment-tab" data-bs-toggle="tab" data-bs-target="#enrollment" type="button" role="tab">
                            <i class="fas fa-graduation-cap"></i> Enrollment History
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="terms-tab" data-bs-toggle="tab" data-bs-target="#terms" type="button" role="tab">
                            <i class="fas fa-file-contract"></i> Terms & Conditions
                        </button>
                    </li>
                </ul>                <!-- Tab Content -->
                <div class="tab-content" id="studentViewTabContent">
                    <!-- Personal & Course Details Tab -->
                    <div class="tab-pane fade show active" id="personal" role="tabpanel">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-user-circle me-2"></i>
                                    Student Profile Overview
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Student Name Header -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="d-flex align-items-center p-3 bg-light rounded">
                                            <div class="avatar-circle me-3">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <h3 class="mb-1 text-primary">
                                                    <span id="view_fullname" class="fw-bold">Loading...</span>
                                                </h3>
                                                <p class="mb-0 text-muted">
                                                    <span id="view_gender_dob">Gender, Date of Birth</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row g-4">
                                    <!-- Personal Information -->
                                    <div class="col-md-6">
                                        <div class="card h-100 border border-info">
                                            <div class="card-header bg-info text-white py-2">
                                                <h6 class="card-title mb-0">
                                                    <i class="fas fa-id-card me-2"></i>Personal Information
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="info-item mb-3">
                                                    <label class="form-label fw-bold text-secondary">First Name:</label>
                                                    <p class="form-control-plaintext text-dark fw-medium" id="view_fname">N/A</p>
                                                </div>
                                                <div class="info-item mb-3">
                                                    <label class="form-label fw-bold text-secondary">Surname:</label>
                                                    <p class="form-control-plaintext text-dark fw-medium" id="view_surname">N/A</p>
                                                </div>
                                                <div class="info-item mb-3">
                                                    <label class="form-label fw-bold text-secondary">Date of Birth:</label>
                                                    <p class="form-control-plaintext text-dark fw-medium" id="view_dob">N/A</p>
                                                </div>
                                                <div class="info-item mb-3">
                                                    <label class="form-label fw-bold text-secondary">Gender:</label>
                                                    <p class="form-control-plaintext text-dark fw-medium" id="view_gender">N/A</p>
                                                </div>
                                                
                                                <!-- Login Credentials Section -->
                                                <div class="border rounded p-3 bg-light">
                                                    <h6 class="text-primary mb-3">
                                                        <i class="fas fa-key me-2"></i>Login Credentials
                                                    </h6>
                                                    <div class="info-item mb-2">
                                                        <label class="form-label fw-bold text-secondary">Email:</label>
                                                        <p class="form-control-plaintext text-dark fw-medium" id="view_email">N/A</p>
                                                    </div>
                                                    <div class="info-item mb-0">
                                                        <label class="form-label fw-bold text-secondary">Password:</label>
                                                        <p class="form-control-plaintext text-dark font-monospace" id="view_password">N/A</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    <!-- Course Information -->
                                    <div class="col-md-6">
                                        <div class="card h-100 border border-success">
                                            <div class="card-header bg-success text-white py-2">
                                                <h6 class="card-title mb-0">
                                                    <i class="fas fa-graduation-cap me-2"></i>Course Information
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="info-item mb-3">
                                                    <label class="form-label fw-bold text-secondary">Class:</label>
                                                    <span class="badge bg-primary fs-6 px-3 py-2" id="view_class">Not Assigned</span>
                                                </div>
                                                <div class="info-item mb-3">
                                                    <label class="form-label fw-bold text-secondary">Module:</label>
                                                    <span class="badge bg-secondary fs-6 px-3 py-2" id="view_module">No Module</span>
                                                </div>
                                                <div class="info-item mb-3">
                                                    <label class="form-label fw-bold text-secondary">Course Price:</label>
                                                    <p class="form-control-plaintext text-dark fw-bold fs-5">
                                                        £<span id="view_price">0.00</span>
                                                    </p>
                                                </div>
                                                <div class="info-item mb-3">
                                                    <label class="form-label fw-bold text-secondary">Status:</label>
                                                    <span class="badge bg-success fs-6 px-3 py-2" id="view_status">Inactive</span>
                                                </div>
                                                <div class="info-item mb-0">
                                                    <label class="form-label fw-bold text-secondary">Registration Date:</label>
                                                    <p class="form-control-plaintext text-dark fw-medium" id="view_registered">N/A</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    <!-- Parent's Details Tab -->
                    <div class="tab-pane fade" id="parent" role="tabpanel">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-users me-2"></i>Parent / Guardian Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="card border border-warning">
                                            <div class="card-header bg-warning text-dark py-2">
                                                <h6 class="card-title mb-0">
                                                    <i class="fas fa-user-tie me-2"></i>Personal Details
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="info-item mb-3">
                                                    <label class="form-label fw-bold text-secondary">First Name:</label>
                                                    <p class="form-control-plaintext text-dark fw-medium" id="view_parent_fname">N/A</p>
                                                </div>
                                                <div class="info-item mb-3">
                                                    <label class="form-label fw-bold text-secondary">Surname:</label>
                                                    <p class="form-control-plaintext text-dark fw-medium" id="view_parent_surname">N/A</p>
                                                </div>
                                                <div class="info-item mb-0">
                                                    <label class="form-label fw-bold text-secondary">Address:</label>
                                                    <p class="form-control-plaintext text-dark fw-medium" id="view_address">N/A</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border border-info">
                                            <div class="card-header bg-info text-white py-2">
                                                <h6 class="card-title mb-0">
                                                    <i class="fas fa-phone me-2"></i>Contact Information
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="info-item mb-3">
                                                    <label class="form-label fw-bold text-secondary">Email Address:</label>
                                                    <p class="form-control-plaintext text-dark fw-medium" id="view_parent_email">N/A</p>
                                                </div>
                                                <div class="info-item mb-0">
                                                    <label class="form-label fw-bold text-secondary">Phone Number:</label>
                                                    <p class="form-control-plaintext text-dark fw-medium" id="view_phone">N/A</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    <!-- Enrollment Details Tab -->
                    <div class="tab-pane fade" id="enrollment" role="tabpanel">
                        <div class="card shadow-sm border-0">
        <div class="card-header bg-blue text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-graduation-cap me-2"></i>Enrollment History & Course Details
            </h5>
        </div>
        <div class="card-body">
            <div id="enrollment_details" style="min-height:80px;">
                <!-- Enrollment details will be populated here -->
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading enrollment data...</p>
                </div>
            </div>
        </div>
    </div>
                    </div>                    <!-- Terms & Conditions Tab -->
                    <div class="tab-pane fade" id="terms" role="tabpanel">
                        <div class="card shadow-sm">
                            <div class="card-header bg-warning text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-file-contract me-2"></i>Terms and Conditions & Data Protection
                                </h5>
                            </div>
                            <div class="card-body">                                <div class="p-3 border rounded mb-3 no-auto-hide">
                                    <h6 class="text-primary mb-2">
                                        <i class="fas fa-info-circle me-2"></i>Recording Consent & Image Usage Rights
                                    </h6>
                                    <p class="mb-2">
                                        "I consent to occasional classes being recorded for staff training purposes only. I accept that I will have the right to decline or permit use of any footage of my child, when asked, (for use on Success at 11 plus English website or social media), prior to use."
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong class="text-dark">Student's Response:</strong>
                                        <span id="view_terms_accepted" class="badge fs-6 px-3 py-2 no-auto-hide">Loading...</span>
                                    </div>
                                </div>
                                
                                <!-- <div class="p-3 border rounded bg-light no-auto-hide">
                                    <h6 class="text-secondary mb-2">
                                        <i class="fas fa-shield-alt me-2"></i>Data Protection Notice
                                    </h6>
                                    <p class="mb-0 small">
                                        All personal data is processed in accordance with GDPR regulations and our Privacy Policy. Student information is kept secure and used only for educational purposes.
                                    </p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
