<?php

namespace App\Base\Constants\Auth;

class Permission
{
/* Dashboard and Settings*/
    const ACCESS_DASHBOARD = 'access-dashboard';
    const SETTINGS = 'view-settings';
    const ADD_ROOM = 'add-Room-booking';
    const ADD_PARTY = 'add-party';
    const ADD_SPORT = 'add-sports';
    const ROOM_AVAILABILITY = 'room-availability-settings';
    const ROOM_BOOKING_MANAGEMENT = 'room-booking-management';
    const PARTY_BOOKING_MANAGEMENT = 'party-booking-management';
    const LAWN_BOOKING_MANAGEMENT = 'lawn-booking-management';
    const CREATE_ROLES = 'create-roles';
    const ASSIGN_PERMISSIONS = 'assign-permissions';
    const GET_ALL_PERMISSIONS = 'get-all-permissions';
    const VIEW_TRANSLATIONS = 'view-translations';
    const VIEW_DISTRICT = 'view-district';
  /* Master Data */
    const MASTER = 'master-data';
/* Service-Location */
    const SERVICE_LOCATION = 'service_location';
    const ADD_SERVICE_LOCATION = 'Add_Service_Location';
    const EDIT_SERVICE_LOCATION = 'Edit_Service_Location';
    const DELETE_SERVICE_LOCATION = 'Delete_Service_Location';
    const TOGGLE_SERVICE_LOCATION = 'Toggle_Service_Location'; 
/* Manage Owner */ 
/* Admin  */
   const ADMIN = 'admin';
   const CREATE_ADMIN = 'add-admin';
   const EDIT_ADMIN = 'edit-admin';
   const DELETE_ADMIN = 'delete-admin';
   const TOGGLE_ADMIN = 'toggle-admin-status';  
/* Requests */
   const VIEW_REQUEST = 'view-requests';
   const RIDES = 'view-rides';
   const SCHEDULED_RIDES = 'scheduled-rides';
   const CANCELLATION_RIDES = 'cancellation-rides';
/* Vehicle Types */
   const VIEW_TYPES = 'view-vehicle-types';
   const ADD_TYPES = 'add-vehicle-types';
   const EDIT_TYPES = 'edit-vehicle-types';
   const DELETE_TYPES = 'delete-vehicle-types';
   const TOGGLE_TYPES = 'toggle-vehicle-types';
/* Zone */
    const MAP_MENU = 'map-menu';
    const VIEW_ZONE = 'view-zone';
    const VIEW_ZONE_MAP = 'view-zone-map';
    const ADD_ZONE = 'add-zone';
    const EDIT_ZONE = 'edit-zone';
    const DELETE_ZONE = 'delete-zone';
    const TOGGLE_ZONE = 'toggle-zone';
    const SURGE_ZONE = 'surge-zone';


   const LOCATIONS = 'locations';
   const OTHERS = 'others';

    // Ariport Slugs
    const LIST_AIRPORTS = 'list-airports';
    const ADD_AIRPORTS = 'Add-Airports';
    const EDIT_AIRPORTS = 'Edit-airports';
    const DELETE_AIRPORTS = 'Delete-Airports';
    const MAP_VIEW_AIRPORTS = 'Map-view-Airports';
    const TOGGLE_AIRPORTS = 'Toggle-Airports';
/* Vehicle Fare */
    const VEHICLE_FARE = 'vehicle-fare';
    const ADD_PRICE = 'add-price';
    const EDIT_PRICE= 'edit-price';
    const DELETE_PRICE = 'delete-price';
    const TOGGLE_PRICE = 'toggle-price';
    const DEFAULT_VEHICLE_TYPE = 'default-vehicle-type';
    const ASSIGN_RENTAL_PACKAGE = 'assign-rental-package';
    const RENTAL_PACKAGE = 'rental-package';
    const ADD_RENTAL_PACKAGE = 'add-rental-package';
    const EDIT_RENTAL_PACKAGE = 'edit-rental-package';
    const DELETE_RENTAL_PACKAGE = 'delete-rental-package';
    const TOGGLE_RENTAL_PACKAGE = 'toggle-rental-package';
/* Drivers */
    const DRIVERS_AND_USERS='drivers-and-users';
    const DRIVERS_MENU = 'drivers-menu';
    const REGISTERED_DRIVERS = 'registered-drivers';  
    const VIEW_APPROVED_DRIVERS = 'view-approved-drivers';       
    const VIEW_DRIVERS = 'view-drivers';
    const VIEW_PPROVAL_PENDING_DRIVERS = 'view-approval-pending-drivers';
    const VIEW_DRIVER_RATINGS = 'view-driver-ratings';
    CONST VIEW_DRIVER_WITHDRAWAL_REQUESTS = 'view-driver-withdrawal-requests';
    const VIEW_NEGATIVE_BALANCE_DRIVERS = 'view-negative-balance-drivers';
    const EDIT_DRIVERS = 'edit-drivers';
    const TOGGLE_DRIVERS = 'toggle-drivers';
    const VIEW_REQUEST_LIST = 'view-request-list';
    const DRIVER_PAYMENT_HISTORY = 'driver-payment-history';
    const VIEW_DRIVER_PROFILE = 'view-driver-profile';
    const ADD_DRIVERS = 'add-drivers';
    const UPDATE_DRIVERS = 'update-drivers';
    const DELETE_DRIVERS = 'delete-drivers';
    const GET_INVOICE='get-invoice';
    const LIST_INVOICE='list-invoice';
    const DRIVER_SUBSCRIPTION='driver-subscriptions';
    const DRIVER_DETAILS='driver-details';    
  /* Driver Document & Withdrawal Request &negative balance & rating */
    const VIEW_DRIVER_RATING = 'view-driver-rating';
    const DRIVER_WITHDRAWAL_REQUEST_VIEW = 'driver-withdrwal-request-view';
    const NEGATIVE_BALACE_DRIVER_VIEW = 'neagtive-driver-view';
/* Fleet Drivers */
    const FLEET_DRIVERS_MENU = 'fleet-drivers-menu';
    const VIEW_APPROVED_FLEET_DRIVERS = 'view-approved-fleet-drivers';
    const FLEET_DRIVERS_WAITING_FOR_APPROVAL = 'fleet-drivers-waiting-for-approval';
    const EDIT_FLEET_DRIVERS ='edit-fleet-drivers';
    const TOGGLE_FLEET_DRIVERS = 'toggle-fleet-drivers';
    const DELETE_FLEET_DRIVERS = 'delete-fleet-drivers';
    const ADD_FLEET_DRIVERS = 'add-fleet-drivers';
    const VIEW_FLEET_DRIVER_REQUEST_LIST = 'view-fleet-driver-request-list';
    const FLEET_DRIVER_PAYMENT_HISTORY = 'fleet-driver-payment-history';
    const VIEW_FLEET_DRIVER_PROFILE = 'view-fleet-driver-profile';
    const UPDATE_FLEET_DRIVERS = 'update-fleet-drivers';
/* Users */
    const USER_MENU = 'user-menu';
    const VIEW_USERS = 'view-users';
    const DELETE_USER = 'delete-user';
    const EDIT_USER = 'edit-user';
    const ADD_USER = 'add-user';
    const TOGGLE_USER = 'toggle-user';
    const VIEW_USER_REQUEST_LIST = 'view-user-request-list';
    const USER_PAYMENT_HISTORY = 'user-payment-history';
/* SOS */
    const VIEW_SOS = 'view-sos';
    const DELETE_SOS = 'delete-sos';
    const EDIT_SOS = 'edit-sos';
    const ADD_SOS = 'add-sos';
    const TOGGLE_SOS = 'toggle-sos';

 //* Promo code */
    const MANAGE_PROMO = 'manage-promo';
    const ADD_PROMO = 'add-promo';
    const EDIT_PROMO = 'edit-promo';
    const TOGGLE_PROMO = 'toggle-promo';
    const DELETE_PROMO = 'delete-promo';
//Notifications
    const NOTIFICATIONS = 'notifications';
    const VIEW_NOTIFICATIONS = 'view-notifications';
    const SEND_PUSH ='send_push';
    const DELETE_NOTIFICATIONS = 'delete-notifications';
 //FAQ
    const MANAGE_FAQ = 'manage-faq';
    const VIEW_FAQ = 'view-faq';
    const DELETE_FAQ = 'delete-faq';
    const EDIT_FAQ = 'edit-faq';
    const ADD_FAQ = 'add-faq';
    const TOGGLE_FAQ = 'toggle-faq';
 //cancelation
    const CANCELLATION_REASON = 'cancellation-reason';
    const VIEW_CANCELLATION = 'view-cancellation';
    const DELETE_CANCELLATION = 'delete-cancellation';
    const EDIT_CANCELLATION = 'edit-cancellation';
    const ADD_CANCELLATION = 'add-cancellation';
    const TOGGLE_CANCELLATION = 'toggle-cancellation';//Complaint
    const COMPLAINTS = 'complaints';
    const USER_COMPLAINT = 'user-complaint';
    const DRIVER_COMPLAINT = 'driver-complaint';
    const OWNER_COMPLAINT = 'owner-complaint';
    const OWNER_REPORT = 'owner-report';
/*complaint titile */
    const COMPLAINT_TITLE = 'complaint-title';
    const ADD_COMPLAINT_TITLE = 'add-complaint-title';
    const EDIT_COMPLAINT_TITLE = 'edit-complaint-title';
    const TOGGLE_COMPLAINT_TITLE = 'toggle-complaint-title';
    const DELETE_COMPLAINT_TITLE = 'delete-complaint-title';
/*Reports*/
    const REPORTS = 'reports';
    const USER_REPORT = 'user-report';
    const DRIVER_REPORT = 'driver-report';
    const FINANCE_REPORT = 'finance-report';
    const DRIVER_DUTIES_REPORT = 'driver-duties-report';

    const USER_COMPLAINTS = 'user-complaint';
    const DRIVER_COMPLAINTS = 'driver-complaint';

/*geo-fencing*/
    const MANAGE_MAP = 'manage-map';
    const HEAT_MAP = 'heat-map';
    const MAP_VIEW = 'map-view';
/*cms*/
    const CMS = 'cms';


    const DISPATCH_REQUEST = 'dispatch-request';

    // const VERIFY_PURCHASECODE = 'verify_purchasecode';

    const EMPLOYEES_MENU = 'employee_menu';
}
