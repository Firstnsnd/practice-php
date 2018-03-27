<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-27
 * Time: 下午3:28
 * 抽象工厂：对象创建型模式，提供一个创建一系列相关或互相依赖对象的接口，而无需指定它们具体的类
 *
 */
interface  TV
{
    public function open();
    public function watch();
}

class HaierTV implements TV
{
    public function open()
    {
        // TODO: Implement open() method.
        echo "Open Haier TV <br>";
    }

    public function watch()
    {
        // TODO: Implement watch() method.
        echo "I'm watching TV <br>";
    }
}

interface  PC
{
    public function work();
    public function paly();
}

class LenovoPC implements PC
{
    public function  work()
    {
        // TODO: Implement work() method.
        echo "I'm working on a Lenovo computer <br>";
    }
    public function  paly()
    {
        // TODO: Implement paly() method.
        echo "Lenovo compute  can be  used to play games <br>";
    }
}
abstract class Factory
{
    abstract  public static  function createPC();
    abstract  public static  function createTV();
}

//一个产品类产生多个产品
class ProductFactory extends  Factory
{
    public static function createTV()
    {
        return new HaierTV();
    }
    public  static function createPC()
    {
        return new LenovoPC();
    }

}

$newTV=ProductFactory::createTV();
$newTV->open();
$newTV->watch();

$newPC=ProductFactory::createPC();
$newPC->work();
$newPC->paly();