//////////////////////////////////////////////////////////////////////////
// Loading level-file from server
//////////////////////////////////////////////////////////////////////////
function loadDoc(filename) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        level_in_text_format = xhttp.responseText;
    }
  };
  xhttp.open("GET", filename, false);
  xhttp.send();
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Status bar initialization.
//////////////////////////////////////////////////////////////////////////
function InitStatus()
{
    var str1;
    var str2;
    var str3;
    var str4;
    var sec;

//    if (MF_CHECKED == GetMenuState(GetMenu(hwnd), IDM_Status_Off, MF_BYCOMMAND)) return;
//    GetClientRect(hwnd, &WinDim);

    gamecode = $("#tabs").tabs("option", "active") + 1;

    if (gamecode == 2) $(".Spot_toolbar").css("display","block");
    else $(".Spot_toolbar").css("display","none");

    if (!loaded) return;

    if (gamecode == 1) $(".virtual_buttons").css("display","block");
        else $(".virtual_buttons").css("display","none");

    switch (gamecode)
    {
        case 0: // Empty Status bar.
            if (prev_game != 0)
            {
//                DestroyWindow(hStatusWnd);
//                hStatusWnd = CreateWindow(STATUSCLASSNAME, "", WS_CHILD |
//                WS_VISIBLE, 0, 0, 0, 0, hwnd, NULL, hInst, NULL);
            }
            $(".status").text("Try to play!!!");
            prev_game = gamecode;
            return;

        case 1: // Socoban status.
            if (prev_game != 1)
            {
//                for (var i=1; i<=3; i++) parts[i-1]=(WinDim.right) / 3*i;
//                SendMessage(hStatusWnd, SB_SETPARTS, 3, parts);
            }
            if (!p1.is_loaded) { $(".status").text("Try to play!!!"); break; }
            sec = p1.retime();
            str1 = "Time of game: " + parseInt(sec/3600) + ":" + parseInt(sec/60%60) + ":" + parseInt(sec%60);
            str2 = "Level: " + p1.level;
            str3 = "Moves maked: " + p1.moves;
//            $("#status_socoban .time").text(str1);
//            $("#status_socoban .level").text(str2);
//            $("#status_socoban .moves").text(str3);
            $(".status").html('<div id="status_socoban"> <div class="time">' + str1 +'</div><div class="level">' + str2 + '</div><div class="moves">' + str3 + '</div></div>');
            break;

        case 2: // Spot status.
           // if (p2.check_end()) break;
            if (!p2.is_loaded) { $(".status").text("Try to play!!!"); break; }
            //if (p2.level_is_completed) break;
            sec = p2.retime();
            p2.check_spots_number();
            str1 = "Time of game: " + parseInt(sec/3600) + ":" + parseInt(sec/60%60) + ":" + parseInt(sec%60);
            //str2 = "Player(" + p2.Player.is + "): " + p2.Player.spots;
            let me_is;  // x > y ? y : x;
            me_is = p2.Player.is == 1 ? "First" : "Second";
            str2 = "Player(" + me_is + "): " + p2.Player.spots;
            //str3 = "Computer(" + p2.Computer.is + "): " + p2.Computer.spots;
            me_is = p2.Computer.is == 1 ? "First" : "Second";
            str3 = "Computer(" + me_is + "): " + p2.Computer.spots;

            $(".status").html('<div id="status_spot"><div class="time">' + str1 +'</div><div class="player" style="color:' + GetColor(PlayerDlg.color) + '">' + str2 + '</div><div class="player" style="color:' + GetColor(ComputerDlg.color) + '">' + str3 + '</div></div>');

            break;

        case 3: // Rotms status.
            if (prev_game != 3)
            {
//                for (var i=1; i<=4; i++) parts[i-1]=(WinDim.right) / 4*i;
//                SendMessage(hStatusWnd, SB_SETPARTS, 4, parts);
            }
            if (!p3.is_loaded) { $(".status").text("Try to play!!!"); break; }
            sec = p3.retime();
            str1 = "Time of game: " + parseInt(sec/3600) + ":" + parseInt(sec/60%60) + ":" + parseInt(sec%60);
            str2 = "Level: " + p3.level;
            str3 = "Moves: " + p3.moves;
            str4 = "Score: " + p3.score;
            $(".status").html('<div id="status_rotms"> <div class="time">' + str1 +'</div><div class="level">' + str2 + '</div><div class="moves">' + str3 + '</div><div class="score">' + str4 + '</div></div>');
//            SendMessage(hStatusWnd, SB_SETTEXT, 3, str4);
//            $("#status_rotms .time").text(str1);
//            $("#status_rotms .level").text(str2);
//            $("#status_rotms .moves").text(str3);
//            $("#status_rotms .score").text(str4);
            break;
    }

//    SendMessage(hStatusWnd, SB_SETTEXT, 0, str1);
//    SendMessage(hStatusWnd, SB_SETTEXT, 1, str2);
//    SendMessage(hStatusWnd, SB_SETTEXT, 2, str3);
    prev_game = gamecode;
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Select all elements that is arrows and relate with function 'SomeArrow()'
//////////////////////////////////////////////////////////////////////////
function SomeArrow()
{
    let elem = $(this);
    let x = (elem[0].offsetTop - 53) / 25; console.log(x);
    let y = (elem[0].offsetLeft - 5) / 25; console.log(y);
    p3.pushbutton(x, y);
}
//////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////
//                  Sound on/off
//////////////////////////////////////////////////////////////////////////
function Sound_On_Off()
{
    if (glob_sound)
    {
        glob_sound = 0;
        //$("#btn-sound").css({"background": "url('../G4W/images/no_sound.png') 2px no-repeat"});
        $("#btn-sound").addClass("no-sound");
        return;
    }
    else {
            glob_sound = 1;
            //$("#btn-sound").css({"background": "url('../G4W/images/BIGTOOL22.png') -158px 2px no-repeat", "background-clip": "content-box"});
            $("#btn-sound").removeClass("no-sound");
         }
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Playing needed sound in current time.
//////////////////////////////////////////////////////////////////////////
function PlayMySound(soundname)
{
    if (glob_sound)
    {
        //if (soundname == "load.wav") // Wait for end of music.
        //PlaySound(path, NULL, SND_FILENAME|SND_SYNC|SND_NOSTOP|SND_NOWAIT);
        //else
        //PlaySound(path, NULL, SND_FILENAME|SND_ASYNC|SND_NOWAIT);
        var myAudio = new Audio("G4W/sound/" + soundname);
        myAudio.play();
    }
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
//                  Changing Player color in Spot game
//////////////////////////////////////////////////////////////////////////
function Change_Player_color()
{
    //console.log(document.forms["Player"].color.value);

    PlayerDlg.color = document.forms["Player"].color.value;
    if (PlayerDlg.color == ComputerDlg.color)
    {
        ComputerDlg.color++;
        if (ComputerDlg.color > 6) ComputerDlg.color = 2;
        document.forms["Computer"].elements[ComputerDlg.color-2]["checked"] = true;

        //console.log(document.forms["Computer"].elements[ComputerDlg.color-2]);
    }
  //  $(".Spot_color.left").css("background", "url('../G4W/images/Spot/spots.png') -80px -120px no-repeat black");
    $(".Spot_color.left").css("background", "url('G4W/images/Spot/spots.png') -80px -" + 40*PlayerDlg.color + "px no-repeat black");
    $(".Spot_color.right").css("background", "url('G4W/images/Spot/spots.png') -80px -" + 40*ComputerDlg.color + "px no-repeat black");
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
//                  Changing Computer color in Spot game
//////////////////////////////////////////////////////////////////////////
function Change_Computer_color()
{
    //console.log(document.forms["Computer"].color.value);

    ComputerDlg.color = document.forms["Computer"].color.value;
    if (ComputerDlg.color == PlayerDlg.color)
    {
        PlayerDlg.color++;
        if (PlayerDlg.color > 6) PlayerDlg.color = 2;
        document.forms["Player"].elements[PlayerDlg.color-2]["checked"] = true;

        //console.log(document.forms["Player"].elements[PlayerDlg.color-2]);
    }
    $(".Spot_color.left").css("background", "url('G4W/images/Spot/spots.png') -80px -" + 40*PlayerDlg.color + "px no-repeat black");
    $(".Spot_color.right").css("background", "url('G4W/images/Spot/spots.png') -80px -" + 40*ComputerDlg.color + "px no-repeat black");
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
//                      Delay in milliseconds
//////////////////////////////////////////////////////////////////////////
function Sleep(milliseconds)
{
  var start = new Date().getTime();
  do
  {
    if ((new Date().getTime() - start) > milliseconds) return;
  }
  while(1);
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
//                      Get color of player or computer
//////////////////////////////////////////////////////////////////////////
function GetColor(color)
{
    switch (color) {
        case 2:  return "red";
        case 3:  return "blue";
        case 4:  return "cadetblue";
        case 5:  return "yellow";
        case 6:  return "green";
        case 7:  return "yellow";
    }
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
//                      Moving the Virtual Buttons of Sokoban
//////////////////////////////////////////////////////////////////////////
function moveVirtualButtons(e)
{
    //e.preventDefault();
    let x = e.clientX - 137/2;
    let y = e.clientY - 137/2;
    if (virtual_buttons_moving) $("div.virtual_buttons").css("left", x).css("top", y).css("position","absolute");
}
//////////////////////////////////////////////////////////////////////////