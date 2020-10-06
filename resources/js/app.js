require('./bootstrap');
import Timesheet from './timesheet/Timesheet'
import TimesheetExport from './timesheet/TimesheetExport';


if(document.querySelector('#timesheets')) new Timesheet()
if(document.querySelector('#csv_export_btn')) new TimesheetExport()
