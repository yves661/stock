<?php
session_start();
require_once __DIR__ . '/db.php';

function esc($s) {
    return htmlspecialchars($s, ENT_QUOTES);
}
?>