<?php

namespace App\Models;

/**
 * Class Register
 * @package App\Models
 *
 * @SWG\Definition(
 *      definition="Register",
 *      required={"email", "device_token", "device_type"},
 *      @SWG\Property(
 *          property="email",
 *          description="User Email",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="device_token",
 *          description="Device Token",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="device_type",
 *          description="User Device Type:ios,android,web",
 *          type="string"
 *      )
 * )
 */
class Register
{
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'email'                 => 'required|email',
        'device_token'          => 'sometimes|required',
        'device_type'           => 'required|string|in:ios,android,web',
        'password'              => 'min:6|required_with:password_confirmation|same:password_confirmation',
        'password_confirmation' => 'min:6'
    ];

    public static $apirules = [
        'email'                 => 'required|email|unique:users,email',
        'device_token'          => 'sometimes|required',
        'device_type'           => 'required|string|in:ios,android,web',
        'password'              => 'min:6|required_with:password_confirmation|same:password_confirmation',
        'password_confirmation' => 'min:6'
    ];
}