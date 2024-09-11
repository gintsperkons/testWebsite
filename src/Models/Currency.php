<?php

namespace App\Models;

use PDO;
use PDOException;
use Exception;

class Currency extends SearchableModel {
    protected static $table = 'currency';
}