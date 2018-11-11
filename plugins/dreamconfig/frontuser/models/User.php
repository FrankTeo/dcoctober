<?php namespace DreamConfig\FrontUser\Models;

use Model;
use October\Rain\Auth\Models\User as UserBase;

/**
 * Model
 */
class User extends UserBase
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'dreamconfig_frontuser_users';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'password'
    ];
}
