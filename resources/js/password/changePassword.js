

export default class ChangePassword {

    constructor() {

        this.changePasswordBtn = document.querySelector('#change-password-btn')
        this.changePasswordModalSelector = '#change-password-modal'
        this.changePasswordModal = document.querySelector(this.changePasswordModalSelector)

        this.onLoad()
        this.events()
    }

    onLoad() {

    }

    events() {
        this.changePasswordBtn.addEventListener('click', e => this.openChangePasswordModal(e))
    }


    openChangePasswordModal(e) {
        $(this.changePasswordModalSelector).modal();
    }

}
