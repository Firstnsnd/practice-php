<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-27
 * Time: 下午1:45
 */
/**
 * 简单工厂模式
 */
class Cat
{
    function __construct()
    {
        echo "I am Cat class <br>";
    }
}

class Dog
{
    function __construct()
    {
        echo "I am Dog class <br>";
    }
}

class Factory
{
    public static function CreateAniaml($name)
    {
        if ($name=='cat')
        {
            return new Cat();
        }elseif($name=='dog')
        {
            return new Dog();
        }
    }
}
$cat =  Factory::CreateAniaml('cat');
$dog = Factory::CreateAniaml('dog');