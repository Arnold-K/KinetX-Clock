@section('override_password')
<div id="override-password-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Change User Password') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="override-password-form">
                    <div class="form-group">
                        <label for="">{{ __('New Password') }}</label>
                        <input id="new-password-field" name="new_password" class="form-control" type="password" placeholder="{{ __('New Password') }}">
                        <small class="text-danger" id="new-password-error"></small>
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('Confirm Password') }}</label>
                        <input id="confirm-password-field" name="confirm_password" class="form-control" type="password" placeholder="{{ __('Confirm Password') }}">
                        <small class="text-danger" id="confirm-password-error"></small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="confirm-override-password-btn" type="button" class="btn btn-primary">Confirm</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
