import Axios from "axios"
import Swal from "sweetalert2"

export default class Timesheet {

    constructor() {

        this.timeSheetsListGroup = document.querySelector('#timesheets')

        this.onLoad()
        this.events()
    }

    onLoad() {

    }

    events() {
        $('#timesheets').on('hidden.bs.collapse', (e) => this.hiddenTimesheet(e))
        $('#timesheets').on('shown.bs.collapse', (e) => this.shownTimesheet(e))

        $('#timesheets').on('click', '[data-action="delete-timesheet-entry"]', e => this.deleteEntry(e))
    }


    hiddenTimesheet(e) {
        let element = e.target.parentElement.querySelector('.card-header button i');
        element.classList.remove('fa-chevron-down');
        element.classList.add('fa-chevron-right');
    }
    shownTimesheet(e) {
        let element = e.target.parentElement.querySelector('.card-header button i');
        element.classList.remove('fa-chevron-right');
        element.classList.add('fa-chevron-down');
    }

    deleteEntry(e) {
        e.preventDefault()

        let entry_id = $(e.currentTarget).closest('div[data-entry]').data('entry')

        Swal.fire({
            icon: "warning",
            title: "Confirm remove!",
            text: "Are you sure you want to delete this Timesheet Entry?",
            confirmButtonText: "Yes",
            showCancelButton: true,
            cancelButtonText: "No"
        }).then(res => {
            if(res.isConfirmed) {
                axios.post(`/timesheet/${entry_id}`, {_method:"delete"}).then(res => {
                    $(e.currentTarget).closest('div.card').remove();
                    Swal.fire("Success!", res.data.mnessage, "success")
                }).catch(err => {
                    Swal.fire("Error!", "There was an error with the server", "error")
                })
            }
        })
    }

}
