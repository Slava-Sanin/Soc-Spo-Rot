<?php
// Start the session
session_start();
$_SESSION['error'] = '';

?>

<!DOCTYPE html>
<html lang="en">
<!--*******************************************************************-->
<head>

	<title>Soc-Spo-Rot</title>
	<meta name="description" content="logical game, logical games, logical games for web, soc-spo-rot, socsporot, socoban, sokoban, spot, spots, rotm, rotms">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>-->
	<script src="Scripts/JQuery/1.12.2/jquery.min.js"></script>

	<!--	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">-->
	<link rel="stylesheet" href="Scripts/UI/1.11.4/themes/smoothness/jquery-ui.css">

	<!--	<script src="http://code.jquery.com/jquery-1.10.2.js"></script>-->

	<!--	<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
	<script src="Scripts/UI/1.11.4/jquery-ui.js"></script>

	<!--	<link rel="stylesheet" href="http://code.jquery.com/resources/demos/style.css">-->

	<link rel="stylesheet" type="text/css" href="CSS/header.css">
	<link rel="stylesheet" type="text/css" href="CSS/socsporot.css">
	<link rel="stylesheet" type="text/css" href="CSS/login.css">
    <link rel="icon" href="/G4W/images/spot.png" type="image/gif" sizes="16x16">  <!-- favicon -->
	
</head>
<!--*******************************************************************-->
<body>
	
	<div class="wraper">
<!---->
		<div class="header">
<!--			<p><img src="G4W/images/spot.png"><span> Soc-Spo-Rot.com - Logical Games for WEB </span> </p>-->
			<?php include 'logo.php' ?>
		</div>
<!---->
<?php
	$edit_link = '#';
    $edit_target = '';

	if ( !isset($_SESSION['username_and_password_is']) OR ( isset($_SESSION['username_and_password_is']) AND ($_SESSION["username_and_password_is"] == false) ) )	require 'login.php';
	else { $edit_link = 'Support/edit_profile.php'; $edit_target = 'target="_blank"'; }
?>
<!---->
		<div class="menu">
			<a href="#">File</a>
			<a id="IDM_Edit" href="<?= $edit_link ?>" <?= $edit_target ?> >Edit<span class="tooltiptext">Edit Profile</span></a>
			<a href="#">Options</a>
			<a id="IDM_Exit" href="logout.php">Exit<span class="tooltiptext">Log off</span></a>
			<a id="IDM_Help" href="https://www.youtube.com/watch?v=YQYePZamCs0" target="_blank">Help<span class="tooltiptext">See video on YouTube about the game</span></a>
		</div>
<!---->
		<hr>
<!---->
		<div class="toolbar">

<?php
	if (isset($_SESSION['username_and_password_is']))
	{
		if ($_SESSION["username_and_password_is"] == true) {
			echo '<button id="btn-socoban"><span class="tooltiptext">Play Socoban</span></button>
				  <button id="btn-spot"><span class="tooltiptext">Play Spot</span></button>
				  <button id="btn-rotms"><span class="tooltiptext">Play Rotms</span></button>';
            echo
                  '
                  <style>
                     #tabs {visibility: hidden;}
                     #tabs-1, #tabs-2, #tabs-3  { visibility: hidden;}
                     li[aria-controls="tabs-1"] { visibility: hidden;}
                     li[aria-controls="tabs-2"] { visibility: hidden;}
                     li[aria-controls="tabs-3"] { visibility: hidden;}
                  </style> 
                  ';
		}
	}
?>

<!-- <div class="separator1"></div> -->
            <button id="btn-sound" class="sound"><span class="tooltiptext">Sound On/Off</span></button>
			<button id="btn-save"></button>
			<button id="btn-new"><span class="tooltiptext">New game</span></button>
			<button id="btn-finish" onclick="window.open('','_self').close();return false;"></button>
			<button id="btn-undo"><span class="tooltiptext">Undo</span></button>

<!--	Player and Computer colors in game Spot			-->
			<div class="Spot_toolbar">

				<div class="ramka left">
					<p>Player</p>
					<div class="Spot_color left"></div>
				</div>

				<button id="Spot_toolbar_button"></button>

				<div class="ramka right">
					<p>Computer</p>
					<div class="Spot_color right"></div>
				</div>

			</div>
<!--	end	Player and Computer colors in game Spot		-->


<!--    Virtual buttons (arrows) for sokoban     -->
            <div class="virtual_buttons">
                <table>
                    <tbody>
                        <tr>
                            <th></th>
                            <th id="virtual_up" onclick="p1.movetop(72);"></th>
                            <th></th>
                        </tr>

                        <tr>
                            <th id="virtual_left" onclick="p1.movetop(75);"></th>
                            <th id="virtual_move" onmousemove="moveVirtualButtons(event);">+</th>
                            <th id="virtual_right" onclick="p1.movetop(77);"></th>
                        </tr>

                        <tr>
                            <th></th>
                            <th id="virtual_down" onclick="p1.movetop(80);"></th>
                            <th></th>
                        </tr>
                    </tbody>
                </table>
            </div>
<!--    End Virtual buttons (arrows) for sokoban     -->

		</div>
		
		<div class="main-window">
<!---->
			<div id="tabs">
				<ul>
					<li><a href="#tabs-1">Socoban</a></li>
					<li><a href="#tabs-2">Spot</a></li>
					<li><a href="#tabs-3">Rotms</a></li>
				</ul>
<!---->
				<div id="tabs-1">

					<div class="board">
						<?php
							include 'socoban_content.php';
						?>
					</div>

					<div class="scroll">
						<button type="button" class="up"></button>
						<div class="tracking"></div>
						<div class="lev-position"></div>
						<button type="button" class="down"></button>
					</div>

				</div>
<!---->
				<div id="tabs-2">

					<div class="board">
						<?php
							include 'spot_content.php';
						?>
					</div>

				</div>
<!---->
				<div id="tabs-3">

					<div class="board">
						<?php
							include 'rotms_content.php';
						?>
					</div>

					<div class="scroll">
						<button type="button" class="up"></button>
						<div class="tracking"></div>
						<div class="lev-position"></div>
						<button type="button" class="down"></button>
					</div>

				</div>
<!---->
			</div>
		</div>

<!---->
		<div class="status"><span style="padding-left: 4px"></span> Try to play!!! </div>
<!---->
	</div>

	<div id="Spot_color_dialog">
		<div class="wraper2">
			<div class="header">
				<p>Spot's options</p><button style="float: right">X</button>
            </div>
                <div class="div2">
                	<div class="div3">

					<div class="div15">
						<div class="div4">
							<div class="div5">
                				<div class="div6">
									<img src="G4W/images/men.png" alt="men" height="60" width="60">
								</div>

								<div class="div9">
									<div class="div7"></div>
									<div class="div8"></div>
								</div>

								<div class="div6" style="float: right">
									<img src="G4W/images/computer.jpg" alt="computer" height="60" width="60">
								</div>
							</div>

							<div class="wraper3">
								<div class="div10">
									<form name="Player" onchange="Change_Player_color();">
										<input type="radio" name="color" value="2" checked><br>
										<input type="radio" name="color" value="3"><br>
										<input type="radio" name="color" value="4"><br>
										<input type="radio" name="color" value="5"><br>
										<input type="radio" name="color" value="6">
									</form>
								</div>
								<div class="div11">
				<!--				images of spots					-->
								</div>
								<div class="div12">
									<form name="Computer" onchange="Change_Computer_color();">
										<input type="radio" name="color" value="2"><br>
										<input type="radio" name="color" value="3" checked><br>
										<input type="radio" name="color" value="4"><br>
										<input type="radio" name="color" value="5"><br>
										<input type="radio" name="color" value="6">
									</form>
								</div>
							</div>
							<div id="Player_is" class="div14">First</div>
							<div class="div13">
								<div class="div8"></div>
								<div class="div7"></div>
								<button id="first-or-second" type="button">&lt;&gt;</button>
							</div>
							<div id="Computer_is" class="div14">Second</div>
						</div>
					</div>

					</div>
				</div>


		</div>
	</div>

    <div class="footer" style="text-align: center; font-size: 10pt;">
        <p style="margin-top: 6px"> © Viacheslav Sanin - 2017 - socsporot@gmail.com </p>
    </div>

</body>

<!--***********************************************************************-->
<script type="text/javascript">

<?php include 'code/constants.h'; ?>
<?php include 'code/dialogs.h'; ?>
<?php require 'code/socoban.h'; ?>
<?php require 'code/spot.h'; ?>
<?php require 'code/rotms.h'; ?>
<?php require 'code/globals.h'; ?>
<?php require 'code/functions.cpp'; ?>
<?php //require 'code/filesfunc.h' ?>
<?php //require 'code/fire.h' ?>

	$(document).ready(function(){

		timer = setInterval(InitStatus, 100);

		$("#btn-socoban").click(function(){
			$(this).hide();
            //p1 = new Socoban();

            $("#tabs").css("visibility","visible");
            $("#tabs-1").css("visibility","visible");
            $('li[aria-controls="tabs-1"]').css("visibility","visible");

             //$("#tabs").css("visibility: visible");
//            $("#tabs").show();
//            $("li[aria-controls='tabs-1']").show();
//            $("#tabs-1").show();

			//p1 = new Socoban();
			gamecode = 1;
            p1.change_level();
            p1.init();
			$("#ui-id-1").click();
		//	$("#tabs-1 div.board").focus();
			$(".status").html('<div id="status_socoban"> <div class="time"> Time of game: </div><div class="level"> Level: </div><div class="moves"> Moves maked: </div></div>');
			loaded++;
			p1.is_loaded = 1;
		});

		$("#btn-spot").click(function(){
			$(this).hide();
			//p2 = new Spot();

            $("#tabs").css("visibility","visible");
            $("#tabs-2").css("visibility","visible");
            $('li[aria-controls="tabs-2"]').css("visibility","visible");

            gamecode = 2;
			p2.is_loaded = 1;
			p2.init();
			$("#ui-id-2").click();
			//	$("#tabs-1 div.board").focus();
//			$(".status").html('<div id="status_spot"> <div class="time"> Time of game: </div><div class="player"> Player(1): </div><div class="player"> Computer(2): </div></div>');
			loaded++;
		});

		$("#btn-rotms").click(function(){
			$(this).hide();
			//p3 = new Rotms();

            $("#tabs").css("visibility","visible");
            $("#tabs-3").css("visibility","visible");
            $('li[aria-controls="tabs-3"]').css("visibility","visible");

            gamecode = 3;
			p3.change_level();
			p3.init();
			$("#ui-id-3").click();
		//	$("#tabs-3 div.board").focus();
			$(".status").html('<div id="status_rotms"> <div class="time"> Time of game: </div><div class="level"> Level: </div><div class="moves"> Moves: </div><div class="score"> Score: </div></div>');
			loaded++;
			p3.is_loaded = 1;
		});

		$("div#tabs-2 div.board div").click(function(){
			if (!p2.is_loaded) return;
			let elem = $(this);
			let x = (elem[0].offsetTop - 80 - (elem[0].offsetTop % 40) ) / 40;
			let y = (elem[0].offsetLeft - 7) / 40;
			//console.log(elem[0].offsetTop,"x=",x);
			//console.log(elem[0].offsetLeft,"y=",y);
			p2.player_move(x, y);
			//p2.pushbutton(x, y);
		});

		$("div#tabs-2 div.board div").mouseover(function(){
			if (!p2.is_loaded) return;
			let elem = $(this);
			let x = (elem[0].offsetTop - 80 - (elem[0].offsetTop % 40) ) / 40;
			let y = (elem[0].offsetLeft - 7) / 40;
			//console.log(elem[0].offsetTop,"x=",x);
			//console.log(elem[0].offsetLeft,"y=",y);
			if (p2.data_level[x*Bsp+y] == PlayerDlg.color) elem.css("cursor","pointer");
            else elem.css("cursor","unset");
            //p2.player_move(x, y);
			//p2.pushbutton(x, y);
		});

		$("div#tabs-3 div.board div").click(function(){
			if (!p3.is_loaded) return;
			let elem = $(this);
			let x = (elem[0].offsetTop - 50 - (elem[0].offsetTop % 25) ) / 25;
			let y = (elem[0].offsetLeft - 5) / 25;
			p3.pushbutton(x, y);
		});

		$("#btn-sound").click(function(){
			Sound_On_Off();
			return false;
		});

//		//$("li[aria-labelledby='ui-id-1']").click(function(){
//		$("#ui-id-1").click(function(){
//			gamecode = 1;
//			console.log("gamecode = 1");
//		//	$("#tabs-1 div.board").focus();
//			return false;
//		});
//	//	li.ui-state-default:nth-child(2)
//		$("#ui-id-2").click(function(){
//			gamecode = 2;
//			console.log("gamecode = 2");
//	//		$("#tabs-2 div.board").focus();
//			return false;
//		});
//
//		//$("li[aria-labelledby='ui-id-3']").click(function(){
//		$("#ui-id-3").click(function(){
//			gamecode = 3;
//			console.log("gamecode = 3");
//			alert("yo-ho!!!");
//		//	$("#tabs-3 div.board").focus();
//			return false;
//		});

		$(".up").click(function(){
			if (!loaded) return;
			switch (gamecode)
			{
				case 1:
					if (p1.level == 1) break;
					p1.level--;
					$("#tabs-1 .scroll .lev-position").css("height", 15 * p1.level + 4);
					p1.change_level();
					PlayMySound("changepage.wav");
					p1.init();
					InitStatus();
					break;
				case 3:
					if (p3.level == 1) break;
					p3.level--;
					$("#tabs-3 .scroll .lev-position").css("height", 15 * p3.level + 4);
					p3.change_level();
					PlayMySound("changepage.wav");
					p3.init();
					InitStatus();
					break;
				default:
			}
			return false;
		});

		$(".down").click(function(){
			if (!loaded) return;
			gamecode = $( "#tabs" ).tabs( "option", "active" ) + 1;

			switch (gamecode)
			{
				case 1:
					if (!p1.is_loaded) break;
				    if (p1.level == 20) break;
					p1.level++;
					$("#tabs-1 .scroll .lev-position").css("height", 15 * p1.level + 4);
					p1.change_level();
					PlayMySound("changepage.wav");
					p1.init();
					InitStatus();
					break;
				case 3:
                    if (!p3.is_loaded) break;
					if (p3.level == 20) break;
					p3.level++;
					$("#tabs-3 .scroll .lev-position").css("height", 15 * p3.level + 4);
					p3.change_level();
					PlayMySound("changepage.wav");
					p3.init();
					InitStatus();
					break;
				default:
			}
			return false;
		});

		$("#btn-new").click(function(){
			if (!loaded) return;
			switch (gamecode)
			{
				case 1:
                    if (!p1.is_loaded) break;
				    p1.init();
					InitStatus();
					break;
				case 2:
                    if (!p2.is_loaded) break;
					p2.init();
					InitStatus();
					break;
				case 3:
                    if (!p3.is_loaded) break;
					p3.init();
					InitStatus();
					break;
				default:
			}
			return false;
		});

		$("#Spot_toolbar_button").click(function(){
			$("#Spot_color_dialog").toggle();
			if (!p2.is_loaded) return;
			p2.redraw();
			//return false;
		});

		$("#virtual_move").click(function(){
            if (virtual_buttons_moving == 0)
                {
                   virtual_buttons_moving = 1;
                   $("#virtual_move").removeClass().addClass("virtual_move_on");
                }
            else
                {
                    virtual_buttons_moving = 0;
                    $("#virtual_move").removeClass().addClass("virtual_move_off");
                }
            //return false;
		});

		document.onclick = function (event) {
			moveVirtualButtons(event);
            if (event.target.id == "virtual_move") return;
            else
            {
                virtual_buttons_moving = 0;
                $("#virtual_move").removeClass().addClass("virtual_move_off");
            }
		}

		$("#first-or-second").click(function(){
			let temp = $("#Player_is").text();
			$("#Player_is").text( $("#Computer_is").text() );
			$("#Computer_is").text(temp);
			temp = PlayerDlg.is;
			PlayerDlg.is = ComputerDlg.is;
			ComputerDlg.is = temp;
			console.log(temp);
			return false;
		});

		$(".wraper2 .header button").click(function(){
			$("#Spot_color_dialog").css("display","none");
			//p2.Player.color = PlayerDlg.color;
			//p2.Computer.color = ComputerDlg.color;
			if (!p2.is_loaded) return;
			p2.redraw();
			return false;
		});

		$("#tabs").tabs();

//		$(".main-window").css("display","block");

        $("#btn-undo").click(function(){
			if (!loaded) return;
			// Move back.
            switch (gamecode)
            {
                case 1: // in Socoban.
                    if (!p1.is_loaded) break;
                    if (p1.moves == 0) return;
                    if (p1.level_is_completed == false) p1.Undo();
                    break;
                case 2: // in Spot.

                    break;
                case 3: // in Rotms.
                    if (!p3.is_loaded) break;
					if (p3.moves == 0) return;
					if (p3.level_is_completed == false) p3.Undo();
                    break;
            }
        //EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_GRAYED);
            //$(this).prop('disabled',true);
            this.disabled = true;
         });

//		$( "#tabs-1 .board" )
		$(document).keydown(function(e) {
			if (!loaded) return;
			if (gamecode != 1) return;
            if (!p1.is_loaded) return;
			e = e || window.event;
			switch(e.which || e.keyCode) {
				case 37: // left
					p1.movetop(75);
					break;

				case 38: // up
					p1.movetop(72);
					break;

				case 39: // right
					p1.movetop(77);
					break;

				case 40: // down
					p1.movetop(80);
					break;

				default: return; // exit this handler for other keys
			}
			e.preventDefault(); // prevent the default action (scroll / move caret) alert( "Handler for .keypress() called." );
			//InitStatus();
		});

//		$("#IDM_Exit").click()(function(){
////			Session["username_and_password_is"] = null;
////			$_SESSION["username_and_password_is"] = false;
//			window.location = "logout.php";
//			//EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_GRAYED);
//			//$(this).prop('disabled',true);
//		});

	});


</script>
</html>