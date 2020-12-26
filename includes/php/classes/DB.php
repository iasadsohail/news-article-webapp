<?php

class DB {
    private static $host = "localhost";
    private static $user = "root";
    private static $password = "";
    private static $dbname = "news_article_db";

    public function __construct() { }

    public static function connect() {
        $conn = mysqli_connect(DB::$host, DB::$user, DB::$password, DB::$dbname);
        return $conn;
    }
};

