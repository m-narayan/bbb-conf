<?php
class Authorization {
    public function checkAccessRight() {
        if(!isset($_SESSION['email']) || $_SESSION['email'] == "") { return 0; }
        else { return 1; }
    }
}

?>