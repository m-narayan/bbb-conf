<div id="content">
<div id="leftside">
<div class="menue" onmouseover="this.className">

<?php if($_SESSION['user_type'] == "admin") { ?>
<div class="leftmenu"><div class="tt"> <a href="server.php" id="repRfq">Add Server</a> </div></div>
<?php } ?>
<div class="leftmenu"><div class="tt"> <a href="create_meeting.php" id="repRfq">Create Conference</a> </div></div>

<div class="leftmenu"><div class="tt"> <a href="join_requests.php" id="repRfq">Directory</a> </div></div>

<div class="leftmenu"><div class="tt"> <a href="enrolled_conference.php" id="repRfq">Enrolled Conference</a> </div></div>

</div>
</div>

