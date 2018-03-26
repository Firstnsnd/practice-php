<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-26
 * Time: 下午3:35
 */
namespace home\model;

use core\Model;
/**
 *     用户模型
 */
class UserModel extends Model
{
    function __construct()
    {
        parent::__construct('user');
    }
}