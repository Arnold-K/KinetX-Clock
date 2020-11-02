import Swal from "sweetalert2"
import PasswordValidator from "./passwordValidator"

export default class OverridePassword  {

    constructor() {
        this.confirmOverridePasswordBtn = document.querySelector('#confirm-override-password-btn')      // changes password
        this.overridePasswordModalSelector = '#override-password-modal'
        this.overridePasswordModal = document.querySelector(this.overridePasswordModalSelector)


        //Fields
        this.newPasswordField = document.querySelector('#new-password-field')
        this.confirmPasswordField = document.querySelector('#confirm-password-field')

        // Error Fields
        this.newPasswordFieldError = document.querySelector('#new-password-error')
        this.confirmPasswordFieldError = document.querySelector('#confirm-password-error')

        this.onLoad()
        this.events()
    }

    onLoad() {
        $('#new-password-field').on('input change paste keyup', e => this.clearNewPasswordFieldErrors(e))
        $('#confirm-password-field').on('input change paste keyup', e => this.clearConfirmPasswordFieldErrors(e))
    }

    events() {
        this.confirmOverridePasswordBtn.addEventListener('click', e => this.overridePassword(e))
    }


    clearNewPasswordFieldErrors(e) {
        if(this.newPasswordField.classList.contains('is-invalid')) this.newPasswordField.classList.remove('is-invalid')
        this.newPasswordFieldError.innerHTML = ""
    }

    clearConfirmPasswordFieldErrors(e) {
        if(this.confirmPasswordField.classList.contains('is-invalid')) this.confirmPasswordField.classList.remove('is-invalid')
        this.confirmPasswordFieldError.innerHTML = ""
    }

    openOverridePasswordModal(e, _user_id) {
        this.currentUserId = _user_id
        $(this.overridePasswordModalSelector).modal();
    }

    async overridePassword(e) {
        if(this.currentUserId < 0 ) return false

        this.passwordValidator = new PasswordValidator()

        let test_result = await this.passwordValidator.validate(this.newPasswordField.value).catch(err => {
            this.newPasswordField.classList.add('is-invalid')
            this.newPasswordFieldError.innerHTML = err
            return err
        })
        if(test_result) return false
        test_result = await this.passwordValidator.validate(this.confirmPasswordField.value).catch(err => {
            this.confirmPasswordField.classList.add('is-invalid')
            this.confirmPasswordFieldError.innerHTML = err
            return err
        })
        if(test_result) return false
        test_result = await this.passwordValidator.passwordsMatch(this.newPasswordField.value, this.confirmPasswordField.value).catch(err => {
            Swal.fire("Error!", "Passwords do not match!", "error")
            return err
        })
        if(test_result) return false

        axios.post(`/user/${this.currentUserId}/password`, {
            password: this.newPasswordField.value,
            _method: "put"
        }).then(res => {
            Swal.fire("Success!", res.data.message, "success")
        }).catch(err => {
            if(err.response.status == 404) {
                Swal.fire("Error!", "User cannot be found!", "error")
                return
            }
            Swal.fire("Error!", "You are not authorized to change the password for this user!", "error")
            $(this.overridePasswordModalSelector).modal('hide');
        })
        $(this.overridePasswordModalSelector).modal('hide');
        return true
    }

}
