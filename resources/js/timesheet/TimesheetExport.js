export default class TimesheetExport {

    constructor() {

        this.exportToCSVBtn = document.querySelector('#csv_export_btn')
        this.startDate = document.querySelector('#start_date')
        this.endDate = document.querySelector('#end_date')
        this.employeeId = document.querySelector('#employee_id_field')

        this.onload()
        this.events()
    }

    onload() {


    }

    events() {

        this.exportToCSVBtn.addEventListener('click', e => this.exportToCSVBtn_Click(e))
    }


    exportToCSVBtn_Click(e) {
        e.preventDefault()
        axios.get(`/timesheet-list/${this.employeeId.value}/export?start_date=${this.startDate.value}&end_date=${this.endDate.value}`).then(res => {
            require("downloadjs")( res.data, "Timesheet.csv", "text/csv" );
        }).catch(err => {
            console.log(err)
        })
    }


}
