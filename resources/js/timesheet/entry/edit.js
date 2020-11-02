global.moment = require('moment');
export default class TimesheetEntryEdit {

    constructor() {

        console.log("loaded")

        this.onLoad()
    }

    onLoad() {
        require('tempusdominus-bootstrap-4')
        let start_time = $('#start_time').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',

            icons: {
                time: 'far fa-clock',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-check',
                clear: 'fa fa-trash',
                close: 'fa fa-times'
            }
        });
        let end_time = $('#end_time').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',

            icons: {
                time: 'far fa-clock',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-check',
                clear: 'fa fa-trash',
                close: 'fa fa-times'
            }
        });
    }



}
