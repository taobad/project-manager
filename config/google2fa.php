<?php

return [

    /*
     * Auth container binding
     */

    'enabled' => true,

    /*
     * Lifetime in minutes.
     * In case you need your users to be asked for a new one time passwords from time to time.
     */

    'lifetime' => 10080, // 0 = eternal

    /*
     * Renew lifetime at every new request.
     */

    'keep_alive' => true,

    /*
     * Auth container binding
     */

    'auth' => 'auth',

    /*
     * 2FA verified session var
     */

    'session_var' => 'workice_2fa',

    /*
     * One Time Password request input name
     */
    'otp_input' => 'one_time_password',

    /*
     * One Time Password Window
     */
    'window' => 1,

    /*
     * Forbid user to reuse One Time Passwords.
     */
    'forbid_old_passwords' => false,

    /*
     * User's table column for google2fa secret
     */
    'otp_secret_column' => 'google2fa_secret',

    /*
     * One Time Password View
     */
    'view' => 'google2fa.index',

    /*
     * One Time Password error message
     */
    'error_messages' => [
        'wrong_otp' => "Invalid 2FA token, please try again",
    ],

    /*
     * Throw exceptions or just fire events?
     */
    'throw_exceptions' => true,

];
