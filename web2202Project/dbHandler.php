<?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbName = "shoppingdb";

    $handler = mysqli_connect($servername,$username,$password);
    
    global $handlerDB;
    $handlerDB = mysqli_connect($servername,$username,$password,$dbName);

    if(!$handler){
        die("Connection failed: ".mysqli_connect_error());
        echo "<br>";
    }else{
        //echo "Connected successfully";
        //echo "<br>";
    }
//Create Database
    global $createDB;
    $createDB = mysqli_query($handler,'create database if not exists shoppingdb');

    if($createDB){
        //echo 'Database successfully created/accessed!';
        //echo "<br>";
    }else{
        echo "Error creating database: ".mysqli_error($handler);
        echo "<br>";
    }

    $createUserTable = "create table if not exists userList(
        id int unsigned auto_increment primary key,
        username varchar(99) not null,
        email varchar(99) not null,
        pwd varchar(999),
        user_type varchar(99) not null
    )";
//Create User Table
    global $makeUserTable;
    $makeUserTable = mysqli_query($handlerDB,$createUserTable);

    if($makeUserTable){
        //echo "User Table successfully created/accessed!";
        //echo "<br>";
    }else{
        echo "Error creating table: ".mysqli_error($handlerDB);
    }
//Create Product Table    
    $createProductTable="create table if not exists productList(
        id int auto_increment primary key,
    	name varchar(999) not null,
        code varchar(999) not null,
    	price decimal(6,2) not null,
    	stock int not null,
    	image longtext
    )";
    
    global $makeProductTable;
    $makeProductTable = mysqli_query($handlerDB, $createProductTable);
    
    if($makeProductTable){
        //echo "Product Table successfully created/accessed!";
        //echo "<br>";
    }else{
        echo "Error creating table: ".mysqli_error($handlerDB);
    }
    // Create Order History Table
    $createOrderHistoryTable="create table if not exists orderHistory(
    	id int auto_increment primary key,
    	orderid varchar(999) not null,
    	username varchar(999) not null,
    	orderDate datetime,
        address varchar(999),
    	code varchar(999) not null,
    	price decimal(6,2) not null,
    	quantity varchar(999) not null,
        total decimal(8,2) not null
    )";
    
    global $makeOrderHistoryTable;
    $makeOrderHistoryTable = mysqli_query($handlerDB, $createOrderHistoryTable);
    
    if($makeOrderHistoryTable){
        //echo "Order History Table successfully created/accessed!";
        //echo "<br>";
    }else{
        echo "Error creating table: ".mysqli_error($handlerDB);
    }
    
    // Create Customer Table
    $createCustomerTable="create table if not exists customer(
	    id int auto_increment primary key,
    	username varchar(999) not null,
    	fname varchar(99),
    	lname varchar(99),
    	add1 varchar(999),
    	add2 varchar(999),
    	add3 varchar(999),
        zipcode varchar(10),
    	city varchar(999),
        state varchar(999),
    	country varchar(100)
    )";
    global $makeCustomerTable;
    $makeCustomerTable = mysqli_query($handlerDB, $createCustomerTable);
    
    if($makeCustomerTable){
        //echo "Customer Table successfully created/accessed!";
        //echo "<br>";
    }else{
        echo "Error creating table: ".mysqli_error($handlerDB);
    }
    
?>