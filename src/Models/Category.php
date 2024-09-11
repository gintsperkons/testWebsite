<?php

namespace App\Models;

use PDO;
use PDOException;
use Exception;

class Category extends SearchableModel {
    protected static $table = 'categories';
}