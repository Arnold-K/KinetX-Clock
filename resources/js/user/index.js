import OverridePassword from "../password/overridePassword"
import DeleteUser from "./deleteUser"


export default class UserIndex {

    constructor() {
        this.userListGroup = $('#user-list-group')

        this.events()
        this.onLoad()
    }


    events() {
        this.userListGroup.on('click', '[data-action="override-password"]', e => this.loadOverridePassword(e))
        this.userListGroup.on('click', '[data-action="delete-user"]', e => this.loadDeleteUser(e))
    }

    onLoad() {

    }

    loadOverridePassword(e) {
        this.overridePassword = new OverridePassword()
        let user_id = e.currentTarget.closest('li[data-id]').getAttribute('data-id')
        this.overridePassword.openOverridePasswordModal(e, user_id)
    }

    loadDeleteUser(e) {
        e.preventDefault()
        this.deleteUser = new DeleteUser()
        let user_id = e.currentTarget.closest('li[data-id]').getAttribute('data-id')
        this.deleteUser.deleteUser(e, user_id).then(res => {
            e.currentTarget.closest('li[data-id]').remove()
        })
    }

}
