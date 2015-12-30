<?php

/**
*
*   MyHonors 2.0 Configuration
*
*   Provided below are the configuration properties and values for the 
*   MyHonors 2.0 Backend API. Before placing this codebase on a 
*   production or test server/environment and be expected to run, this 
*   configuration file must be fully filled/specified first.
*
*/

return array(
    
    // Absolute path to directory to store file uploads.
    // This entire folder must be publicly accessible.
    'UPLOAD_BASE_PATH' => __DIR__ . '/file_uploads',
    
    // JSON Web Token Configuration
    'JWT' => array(
        
        // Secret key used for hashing/decoding authentication tokens
        'SECRET' => '',
    
        // Duration (in seconds) to persist authentication token
        'DURATION' => ''
    
    )
    
);