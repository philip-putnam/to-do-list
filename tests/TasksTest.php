<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Tasks.php';
    require_once 'src/Category.php';

    $server = 'mysql:host=localhost:8889;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class TasksTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Tasks::deleteAll();
            Category::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_Category = new Category($name, $id);
            $test_Category->save();

            $description = "Wash the dog";
            $category_id = $test_Category->getId();
            $test_task = new Tasks($description, $id, $category_id);
            $test_task->save();

            //Act
            $result = $test_task->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getCategoryId()
        {

            //Arrange
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $test_task = new Tasks($description, $id, $category_id);
            $test_task->save();

            //Act
            $result = $test_task->getCategoryId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $test_task = new Tasks($description, $id, $category_id);

            $test_task->save();

            $result = Tasks::getAll();
            $this->assertEquals($test_task, $result[0]);

        }

        function test_getAll()
        {
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $test_task = new Tasks($description, $id, $category_id);
            $test_task->save();

            $description2 = "Water the lawn";
            $test_task2 = new Tasks($description2, $id, $category_id);
            $test_task2->save();

            $result = Tasks::getAll();

            $this->assertEquals([$test_task, $test_task2], $result);

        }

        function test_deleteAll()
        {
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $category_id = $test_category->getId();

            $description = "Wash the dog";
            $test_task = new Tasks($description, $id, $category_id);
            $test_task->save();

            $description2 = "Water the lawn";
            $test_task2 = new Tasks($description2, $id, $category_id);
            $test_task2->save();

            Tasks::deleteAll();

            $result = Tasks::getAll();
            $this->assertEquals([], $result);

        }


        function test_find()
        {
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $category_id = $test_category->getId();

            $description = "Wash the dog";
            $test_task = new Tasks($description, $id, $category_id);
            $test_task->save();

            $description2 = "Water the lawn";
            $test_task2 = new Tasks($description2, $id, $category_id);
            $test_task2->save();

            $result = Tasks::find($test_task->getId());

            $this->assertEquals($test_task, $result);
        }

    }


?>
