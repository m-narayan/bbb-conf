<div id="content">
<div class="mainContainerCntr">
<div id="leftside">
<div class="LeftMenuCntr" style="position:relative;" >
<?php if($_SESSION['user_type'] == "admin") { ?>
    <div class="menuMainBtm Active1" title="SETTINGS" id="north7">
        <a href="../../view/webinars/settings.php" id="repRfq"> <div id="Cntr2"><div>
                <div class="webinar1"> <img src="../../images/settings.png" border="0" > </div>
                </div> </div></a>
    </div>
<?php } ?>
<?php if($_SESSION['user_type'] == "admin") { ?>
    <div class="menuMainBtm" title="BBB SERVER" id="north8">
        <a href="../../view/webinars/server.php" id="repRfq"> <div id="Cntr2"><div>
                <div class="webinar1"> <img src="../../images/server.png" border="0" > </div>
                </div></div></a>
    </div>
<?php } ?>

<?php if($_SESSION['user_type'] == "admin") { ?>
    <div class="menuMainBtm" title="DIRECTORY" id="north9">
        <a href="../../view/webinars/directory.php" id="repRfq"> <div id="Cntr2"><div>
                <div class="webinar1"> <img src="../../images/webinar1.png" border="0" > </div>
                    </div></div></a>
    </div>
<?php } ?>

<?php if($_SESSION['user_type'] == "admin") { ?>
    <div class="menuMainBtm" title="CHANGE PASSWORD" id="north10">
        <a href="../../view/webinars/change_password.php" id="repRfq"> <div id="Cntr2"><div>
                <div class="webinar1"> <img src="../../images/password.png" border="0" > </div>
                    </div> </div></a>
    </div>
<?php } ?>


<?php if($_SESSION['user_type'] == "supplier") { ?>
    <div class="menuMainBtm Active1" title="CREATE CONFERENCE" id="north7">
        <a href="../../view/webinars/create_meeting.php" id="repRfq"> <div id="Cntr2"><div>
                <div class="webinar1"> <img src="../../images/webinar2.png" border="0" > </div>
                    </div></div></a>
    </div>
<?php } ?>
<?php if($_SESSION['user_type'] != "admin") { ?>
    <div class="menuMainBtm" title="INVITATIONS" id="north8">
        <a href="../../view/webinars/invitations.php" id="repRfq"> <div id="Cntr2"><div>
                <div class="webinar1"> <img src="../../images/webinar3.png" border="0" > </div>

                    </div></div></a>
    </div>
    <div class="menuMainBtm" title="DIRECTORY" id="north9">
        <a href="../../view/webinars/join_requests.php" id="repRfq"> <div id="Cntr2"><div>
                <div class="webinar1"> <img src="../../images/webinar1.png" border="0" > </div>

                    </div> </div></a>
    </div>
    <div class="menuMainBtm" title="ENROLLED CONFERENCES" id="north10">
        <a href="../../view/webinars/enrolled_conference.php" id="repRfq"> <div id="Cntr2"><div>
                <div class="webinar1"> <img src="../../images/webinar4.png" border="0" > </div>

                    </div></div></a>
    </div>

<?php } ?>
</div>
</div>



