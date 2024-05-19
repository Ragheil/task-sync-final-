<?php

require 'authentication.php'; // admin authentication check 

// auth check
$user_id = $_SESSION['admin_id'];
$user_name = $_SESSION['name'];
$security_key = $_SESSION['security_key'];
if ($user_id == NULL || $security_key == NULL) {
    header('Location: index.php');
    exit();
}

$page_name = "About Us";
include("include/sidebar.php");

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="row">
    <div class="col-md-12">
        <div class="well well-custom">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="well">
                        <h3 class="text-center bg-primary" style="padding: 7px;">About Us</h3><br>

                        <div class="row">
                            <div class="col-md-12">
                                <p>Welcome, this is our group <strong>NIGGERSAURUS.</strong>We are a team of dedicated individuals committed to achieving excellence in our respective fields. Below is a brief introduction to each of our group members:</p>
                                
                                <h4>Group Members:</h4>
                                <ul>
                                    <li><strong>Ragheil Atacador:</strong> Power Ranger Red </li>
                                    <li><strong>Creslen karla Barcelo:</strong> Power Ranger Blue</li>
                                    <li><strong>Divina Joy Boncales:</strong> Power Ranger Yellow</li>
                                    <li><strong>Dagiel Rimando:</strong> Power Ranger Black</li>
                                    <li><strong>Ricardo tagam:</strong> Power Ranger Pink</li>
                                </ul>

                                <p>Our group is passionate about collaboration and innovation. We believe in the power of NIGGAS and strive to push the boundaries of what we can achieve together.</p>

                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <a href="index.php" class="btn btn-success-custom btn-xs">Return</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
include("include/footer.php");
?>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
