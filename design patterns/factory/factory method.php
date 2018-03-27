<?php
/**
 * Created by PhpStorm.
 * User: vaniot
 * Date: 18-3-27
 * Time: 下午2:20
 */
/**
 * 工厂方法模式：创建型模式，定义一个抽象的核心工厂类，定义创建产品对象的接口，
 * 创建具体产品类实现接口，产品类实例的工作延迟到工厂子类去完成，
 * 添加产品只需增加实现接口的类和对应的工厂类
 */
interface  Animal
{
    public function run();
    public function say();
}
class  Cat implements  Animal
{
    public function run()
    {
        echo "I ran slowly <br>";
    }
    public function say()
    {
        echo "I am Cat class <br>";
    }
}

class Dog implements Animal
{
    public function run(){
        echo "I am running fast <br>";
    }
    public function  say()
    {
        // TODO: Implement say() method.
        echo "I am Dog class <br>";
    }
}

abstract class Factory
{
    abstract static function createAnimal();
}

class CatFactory extends  Factory
{
    public static function createAnimal()
    {
        return new Cat();
    }
}
class DogFactory extends  Factory
{
    public static function createAnimal()
    {
        return new Dog();
    }
}

$cat = CatFactory::createAnimal();
$cat->say();
$cat->run();

$dog =DogFactory::createAnimal();
$dog->say();
$dog->run();