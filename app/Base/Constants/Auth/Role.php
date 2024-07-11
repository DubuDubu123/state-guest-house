<?php

namespace App\Base\Constants\Auth;

class Role
{
    const USER = 'user';
    const SUPER_ADMIN = 'super-user';
    const MESS_MANAGER = 'mess-manager'; 
    /**
     * Get all the admin roles.
     *
     * @return array
     */
    public static function adminRoles()
    {
        return [
            self::SUPER_ADMIN,
            self::MESS_MANAGER,
            // self::USER, 
        ];
    }
    /**
     * Get all the admin roles.
     *
     * @return array
     */
    public static function exceptSuperAdminRoles()
    {
        return [
            self::SUPER_ADMIN,
            self::MESS_MANAGER,
            self::USER, 
        ];
    }

    /**
     * Get all the web panel roles.
     *
     * @return array
     */
    public static function webPanelLoginRoles()
    {
        return [
            self::SUPER_ADMIN,
            self::MESS_MANAGER,
            self::USER, 
        ];
    }
    /**
    * Get all the web panel roles.
    *
    * @return array
    */
    public static function webShowableRoles()
    {
        return [
            self::MESS_MANAGER,
            self::USER,
            self::SUPER_ADMIN, 
        ];
    }

    /**
     * Get all the Merchant and Admin roles
     * @return array
     */
    public static function masterDataAccessRoles()
    {
        return [
            self::MESS_MANAGER,
            self::USER,
            self::SUPER_ADMIN, 
        ];
    }

    /**
     * Get all the user and Admin roles
     * @return array
     */
    public static function userAndAdminRoles()
    {
        return [
            self::MESS_MANAGER,
            self::USER, 
        ];
    }

    /**
     * Get all the user and driver roles
     * @return array
     */
    public static function mobileAppRoles()
    {
        return [
            self::SUPER_ADMIN,
            self::MESS_MANAGER,
            self::USER, 
        ];
    }
}
