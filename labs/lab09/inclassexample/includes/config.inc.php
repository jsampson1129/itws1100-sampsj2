<?php

// Database configuration
// This file sets up database connection parameters based on the environment
// For production, update these values or use environment variables

// Localhost development settings
if ($_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == 'localhost:8080') {
   $GLOBALS['HOSTNAME'] = 'localhost';
   $GLOBALS['DB_NAME']  = 'iit';
   $GLOBALS['DB_HOST']  = 'localhost';
   $GLOBALS['DB_USERNAME'] = 'root';
   $GLOBALS['DB_PASSWORD'] = 'root';
} else {
   // Production/Azure server settings
   // NOTE: Update these credentials for your production environment
   // For security, consider using environment variables instead
   $GLOBALS['HOSTNAME'] = 'localhost';
   $GLOBALS['DB_NAME']  = 'iit';
   $GLOBALS['DB_HOST']  = 'localhost';
   $GLOBALS['DB_USERNAME'] = 'sampsj2';
   $GLOBALS['DB_PASSWORD'] = 'heartGrzyM7'; // CHANGE THIS IN PRODUCTION
}

// Uncomment and configure for Google Cloud SQL if needed
// $GLOBALS['HOSTNAME'] = 'YOUR_GOOGLE_CLOUD_IP';
// $GLOBALS['DB_NAME']  = 'iit';
// $GLOBALS['DB_HOST']  = 'YOUR_GOOGLE_CLOUD_IP';
// $GLOBALS['DB_USERNAME'] = 'root';
// $GLOBALS['DB_PASSWORD'] = 'YOUR_PASSWORD';

