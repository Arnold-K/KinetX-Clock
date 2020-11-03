require('./bootstrap');
import OverridePassword from './password/overridePassword';
import Payment from './payment/Payment';
import TimesheetEntryEdit from './timesheet/entry/edit';
import Timesheet from './timesheet/Timesheet'
import TimesheetExport from './timesheet/TimesheetExport';
import UserIndex from './user';
import DeleteUser from './user/deleteUser';


if(document.querySelector('#delete-user'))          new DeleteUser()
if(document.querySelector('#payment-list'))         new Payment()
if(document.querySelector('#timesheets'))           new Timesheet()
if(document.querySelector('#csv_export_btn'))       new TimesheetExport()


if( document.querySelector('#override-password-btn') && document.querySelector('#override-password-modal') ) new OverridePassword()
if(document.querySelector('#user-list-group'))      new UserIndex()
if(document.querySelector('#start_time') && document.querySelector('#end_time')) new TimesheetEntryEdit()
