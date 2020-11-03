import Swal from "sweetalert2"

export default class {

    constructor() {
        this.paymentListGroup = $('#payment-list')

        this.onLoad()
    }

    onLoad() {
        this.paymentListGroup.on('click', '[data-action="delete-payment"]', e => this.deletePayment(e))
    }

    deletePayment(e) {
        let payment_id = $(e.currentTarget).closest('li.list-group-item').data('id')

        Swal.fire({
            icon: "warning",
            title: "Confirm deletion!",
            text: "Are you sure you want to delete this Payment?",
            confirmButtonText: "Yes",
            showCancelButton: true,
            cancelButtonText: "No"
        }).then(res => {
            if(res.isConfirmed) {
                axios.post(`/payment/${payment_id}`, {_method:"delete"}).then(res => {
                    $(e.currentTarget).closest('li.list-group-item').remove()
                    Swal.fire("Success!", res.data.message, "success")
                }).catch(err => {
                    Swal.fire("Error!", "There was an error with the server", "error")
                })
            }
        })
    }

}
