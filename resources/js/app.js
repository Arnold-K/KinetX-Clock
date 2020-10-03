require('./bootstrap');
import Timesheet from './timesheet/Timesheet'


if(document.querySelector('#timesheets')) new Timesheet()