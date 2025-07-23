<?php

return array (
  'title' => 'Doctor Appointments',
  'description' => 'Appointment management for doctors',
  'actions' => 
  array (
    'delete' => 
    array (
      'label' => 'Delete',
      'tooltip' => 'Delete this appointment',
      'confirmation' => 'Are you sure you want to delete this appointment?',
      'success' => 'Appointment deleted successfully',
      'error' => 'Error deleting appointment',
    ),
    'accept' => 
    array (
      'label' => 'Accept',
      'tooltip' => 'Accept this appointment',
      'confirmation' => 'Are you sure you want to accept this appointment?',
      'success' => 'Appointment accepted successfully',
      'error' => 'Error accepting appointment',
    ),
    'confirm' => 
    array (
      'label' => 'Confirm',
      'tooltip' => 'Confirm this appointment',
      'confirmation' => 'Are you sure you want to confirm this appointment?',
      'success' => 'Appointment confirmed successfully',
      'error' => 'Error confirming appointment',
    ),
    'reject' => 
    array (
      'label' => 'Reject',
      'tooltip' => 'Reject this appointment',
      'confirmation' => 'Are you sure you want to reject this appointment?',
      'success' => 'Appointment rejected successfully',
      'error' => 'Error rejecting appointment',
    ),
    'reschedule' => 
    array (
      'label' => 'Reschedule',
      'tooltip' => 'Reschedule this appointment',
      'confirmation' => 'Are you sure you want to reschedule this appointment?',
      'success' => 'Appointment rescheduled successfully',
      'error' => 'Error rescheduling appointment',
    ),
    'complete' => 
    array (
      'label' => 'Complete',
      'tooltip' => 'Complete this appointment',
      'confirmation' => 'Are you sure you want to complete this appointment?',
      'success' => 'Appointment completed successfully',
      'error' => 'Error completing appointment',
    ),
    'cancel' => 
    array (
      'label' => 'Cancel',
      'tooltip' => 'Cancel this appointment',
      'confirmation' => 'Are you sure you want to cancel this appointment?',
      'success' => 'Appointment cancelled successfully',
      'error' => 'Error cancelling appointment',
    ),
    'view_details' => 
    array (
      'label' => 'View Details',
      'tooltip' => 'View complete appointment details',
    ),
    'edit' => 
    array (
      'label' => 'Edit',
      'tooltip' => 'Edit this appointment',
      'success' => 'Appointment updated successfully',
      'error' => 'Error updating appointment',
    ),
    'generate_report' => 
    array (
      'label' => 'Generate Report',
      'tooltip' => 'Generate a report for this appointment',
      'modal_heading' => 'Report Generation',
      'modal_description' => 'Are you sure you want to generate a report for this appointment?',
      'modal_icon' => 'heroicon-o-document-text',
      'icon' => 'heroicon-o-document-text',
      'success' => 'Report generated successfully',
      'error' => 'Error generating report',
    ),
    'send_reminder' => 
    array (
      'label' => 'Send Reminder',
      'tooltip' => 'Send a reminder to the patient',
      'confirmation' => 'Are you sure you want to send a reminder to the patient?',
      'success' => 'Reminder sent successfully',
      'error' => 'Error sending reminder',
    ),
    'add_note' => 
    array (
      'label' => 'Add Note',
      'tooltip' => 'Add a note to the appointment',
      'modal_heading' => 'Add Note',
      'modal_description' => 'Enter a note for this appointment',
      'success' => 'Note added successfully',
      'error' => 'Error adding note',
    ),
    'info' => 
    array (
      'label' => 'info',
    ),
    'rejectedAction' => 
    array (
      'label' => 'rejectedAction',
    ),
  ),
  'messages' => 
  array (
    'appointment_accepted' => 'Appointment accepted successfully',
    'appointment_confirmed' => 'Appointment confirmed successfully',
    'appointment_rejected' => 'Appointment rejected successfully',
    'appointment_deleted' => 'Appointment deleted successfully',
    'appointment_rescheduled' => 'Appointment rescheduled successfully',
    'appointment_completed' => 'Appointment completed successfully',
    'appointment_cancelled' => 'Appointment cancelled successfully',
    'appointment_updated' => 'Appointment updated successfully',
    'error_occurred' => 'An error occurred',
    'no_appointments_found' => 'No appointments found',
    'appointment_not_found' => 'Appointment not found',
  ),
  'status' => 
  array (
    'pending' => 'Pending',
    'confirmed' => 'Confirmed',
    'rejected' => 'Rejected',
    'completed' => 'Completed',
    'cancelled' => 'Cancelled',
    'rescheduled' => 'Rescheduled',
    'in_progress' => 'In Progress',
  ),
  'states' => 
  array (
    'pending' => 
    array (
      'label' => 'Pending',
      'color' => 'warning',
      'bg_color' => '#FEF3C7',
      'icon' => 'heroicon-o-clock',
      'description' => 'Appointment waiting for confirmation',
    ),
    'confirmed' => 
    array (
      'label' => 'Confirmed',
      'color' => 'success',
      'bg_color' => '#D1FAE5',
      'icon' => 'heroicon-o-check-circle',
      'description' => 'Appointment confirmed by doctor',
    ),
    'rejected' => 
    array (
      'label' => 'Rejected',
      'color' => 'danger',
      'bg_color' => '#FEE2E2',
      'icon' => 'heroicon-o-x-circle',
      'description' => 'Appointment rejected by doctor',
    ),
    'completed' => 
    array (
      'label' => 'Completed',
      'color' => 'success',
      'bg_color' => '#ECFDF5',
      'icon' => 'heroicon-o-check-badge',
      'description' => 'Appointment completed successfully',
    ),
    'cancelled' => 
    array (
      'label' => 'Cancelled',
      'color' => 'gray',
      'bg_color' => '#F3F4F6',
      'icon' => 'heroicon-o-no-symbol',
      'description' => 'Appointment cancelled',
    ),
    'rescheduled' => 
    array (
      'label' => 'Rescheduled',
      'color' => 'info',
      'bg_color' => '#DBEAFE',
      'icon' => 'heroicon-o-arrow-path',
      'description' => 'Appointment rescheduled for new date',
    ),
    'in_progress' => 
    array (
      'label' => 'In Progress',
      'color' => 'primary',
      'bg_color' => '#E0E7FF',
      'icon' => 'heroicon-o-play-circle',
      'description' => 'Appointment currently in progress',
    ),
  ),
  'fields' => 
  array (
    'message' => 
    array (
      'label' => 'Message',
      'placeholder' => 'Enter a message for the patient',
      'helper_text' => 'The message will be sent to the patient',
      'description' => 'Custom message for the patient',
    ),
    'note' => 
    array (
      'label' => 'Note',
      'placeholder' => 'Enter a private note',
      'helper_text' => 'This note will be visible only to doctors',
      'description' => 'Private note for doctors',
    ),
    'reason' => 
    array (
      'label' => 'Reason',
      'placeholder' => 'Enter the reason for rejection/cancellation',
      'helper_text' => 'The reason will be communicated to the patient',
      'description' => 'Reason for rejection or cancellation',
    ),
    'new_date' => 
    array (
      'label' => 'New Date',
      'placeholder' => 'Select the new date',
      'helper_text' => 'Select the new date for the appointment',
      'description' => 'New date for the rescheduled appointment',
    ),
    'new_time' => 
    array (
      'label' => 'New Time',
      'placeholder' => 'Select the new time',
      'helper_text' => 'Select the new time for the appointment',
      'description' => 'New time for the rescheduled appointment',
    ),
    'invoice' => 
    array (
      'label' => 'Invoice',
      'placeholder' => 'Upload invoice',
      'helper_text' => 'Upload your invoice in PDF or image format',
      'description' => 'Billing document',
    ),
  ),
  'filters' => 
  array (
    'status' => 
    array (
      'label' => 'Status',
      'placeholder' => 'Filter by status',
    ),
    'date_range' => 
    array (
      'label' => 'Date Range',
      'placeholder' => 'Select date range',
    ),
    'patient' => 
    array (
      'label' => 'Patient',
      'placeholder' => 'Filter by patient',
    ),
  ),
);
