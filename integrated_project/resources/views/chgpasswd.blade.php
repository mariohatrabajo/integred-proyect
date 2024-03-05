@extends('layout.app')

@section('title', 'Seneca')

@section('content')
<div class="pc-container">
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Change Password</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="tab-content">
                    <div class="tab-pane show active" id="profile-4" role="tabpanel" aria-labelledby="profile-tab-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Old Password</label>
                                            <input type="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">New Password</label>
                                            <input type="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <h5>New password must contain:</h5>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><i class="ti ti-circle-check text-success f-16 me-2"></i> At least 8
                                                characters</li>
                                            <li class="list-group-item"><i class="ti ti-circle-check text-success f-16 me-2"></i> At least 1
                                                lower letter (a-z)</li>
                                            <li class="list-group-item"><i class="ti ti-circle-check text-success f-16 me-2"></i> At least 1
                                                uppercase letter(A-Z)</li>
                                            <li class="list-group-item"><i class="ti ti-circle-check text-success f-16 me-2"></i> At least 1
                                                number (0-9)</li>
                                            <li class="list-group-item"><i class="ti ti-circle-check text-success f-16 me-2"></i> At least 1
                                                special characters</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end btn-page">
                                <div class="btn btn-outline-secondary">Cancel</div>
                                <div class="btn btn-primary">Update Profile</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
        <div class="row">
            <div class="col my-1">
                <p class="m-0">Able Pro &#9829; crafted by Team <a href="https://themeforest.net/user/phoenixcoded" target="_blank">Phoenixcoded</a></p>
            </div>
            <div class="col-auto my-1">
                <ul class="list-inline footer-link mb-0">
                    <li class="list-inline-item"><a href="../index.html">Home</a></li>
                    <li class="list-inline-item"><a href="https://codedthemes.gitbook.io/able-pro-bootstrap/" target="_blank">Documentation</a></li>
                    <li class="list-inline-item"><a href="https://phoenixcoded.authordesk.app/" target="_blank">Support</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

@endsection