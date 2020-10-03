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

}