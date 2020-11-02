import { reject } from 'lodash'
import Swal from 'sweetalert2'

export default class DeleteUser {
    async deleteUser(e, _user_id) {
        e.preventDefault()

        return await new Promise( async (resolve, reject) => {
            await Swal.fire({
                title: 'Are you sure you want to delete this user?',
                showCancelButton: true,
                confirmButtonText: `Delete User`,
                denyButtonText: `Cancel`,
            }).then( async (result) => {
                if (result.isConfirmed) {
                    await axios.post(`/user/${_user_id}`, {_method: "delete"}).then(res => {
                        Swal.fire('Success!', 'User has Been Deleted!', 'success')
                        resolve()
                    }).catch(err => {
                        Swal.fire('Error!', 'You cannot delete this user!', 'error')
                        reject()
                    })
                }
            })
        });
    }

}
