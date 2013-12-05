<div id="content">
<div id="leftside">
<div class="menue" onmouseover="this.className">

<?php if($_SESSION['user_type'] == "admin") { ?>
    <div class="leftmenu"><div class="tt"> <a href="settings.php" id="repRfq">Settings</a> </div></div>
<?php } ?>
<?php if($_SESSION['user_type'] == "admin") { ?>
<div class="leftmenu"><div class="tt"> <a href="server.php" id="repRfq">BBB Server</a> </div></div>
<?php } ?>

<?php if($_SESSION['user_type'] == "admin") { ?>
    <div class="leftmenu"><div class="tt"> <a href="directory.php" id="repRfq">Directory</a> </div></div>
<?php } ?>

<?php if($_SESSION['user_type'] == "admin") { ?>
    <div class="leftmenu"><div class="tt"> <a href="change_password.php" id="repRfq">Change Password</a> </div></div>
<?php } ?>


<?php if($_SESSION['user_type'] == "supplier") { ?>
<div class="leftmenu"><div class="tt"> <a href="create_meeting.php" id="repRfq">Create Conference</a> </div></div>
<?php } ?>
<?php if($_SESSION['user_type'] != "admin") { ?>

<div class="leftmenu"><div class="tt"> <a href="invitations.php" id="repRfq">Invitations</a> </div></div>

<div class="leftmenu"><div class="tt"> <a href="join_requests.php" id="repRfq">Directory</a> </div></div>

<div class="leftmenu"><div class="tt"> <a href="enrolled_conference.php" id="repRfq">Enrolled Conference</a> </div></div>

<!--<div class="leftmenu"><div class="tt"> <a href="recordings.php" id="repRfq">Recordings</a> </div></div>-->
<?php } ?>
</div>
</div>

