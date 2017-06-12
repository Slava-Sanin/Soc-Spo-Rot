// For finding the best place to put spot.
var PLACE = {
    x : 0,
    y : 0,
    num : -1,
    next : 0
};

// Structure For Player and Computer data.
var st_Player = {
    spots : 0,
    color : 0,
    is : 0 //first or second moving
};

var PlayerDlg = Object.create(st_Player);
    PlayerDlg.color = 2;
    PlayerDlg.is = 1;

var ComputerDlg = Object.create(st_Player);
    ComputerDlg.color = 3;
    ComputerDlg.is = 2;

function Spot() {
    this.data_level = []; //[Asp][Bsp];
    this.data_lev_gr = []; //[Asp][Bsp];
    this.data_undo = []; //[Asp][Bsp];
    this.starttime;
    this.curtime;
    this.htime;
    this.moves;
    this.background = "";
    this.filename;
    this.curX;
    this.curY;
    this.Player = Object.create(st_Player);
    this.Computer = Object.create(st_Player);
    this.who_is_now;
    this.error;
    this.first_step = true;
    this.first_X;
    this.first_Y;
    this.kakoe_iz_odinakovux_vubrat = 0;
    this.first_time = true;
    this.best = Object.create(PLACE);
    this.ready;
//////////////////////////////////////////////////////////////////////////
// Constructor bilds a window, background and fills a map of level.
//////////////////////////////////////////////////////////////////////////
//Spot.prototype.constructor = function()
//{
//    this.background = "";
//    this.change_background(path2);

    this.table_was_changed = 0; // Background changed "table"/pictures.
    this.level = 1;
    this.Player.color = 2;      // Color of player by default.
    this.Computer.color = 3;    // Color of computer by default.
    this.level_is_completed = false;
    this.is_loaded = 0;
    this.change_level();      // Create filename by level number.
//    if (this.init() == -1) return; // If problem whith file loading.
}
/////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Starts a game.
// Loads level, initializes timer, bilds background,
// member current position.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.init = function()
{
 //   var handle;
    this.error=0;
//    if ((handle = open(filename, O_RDONLY | O_TEXT, S_IREAD)) == -1)
//    {
//        this.error=-1;
//        alert(hwnd, "Can't open file!", "ERROR!!!", MB_OK | MB_ICONERROR);
//        return -1;
//    }
//    if (read(handle, &data_level, Asp*Bsp) == -1)
//    {
//        close(handle);
//        this.error=-1;
//        alert(hwnd, "Can't read file!", "ERROR!!!", MB_OK | MB_ICONERROR);
//        return -1;
//    }
//    close(handle);
    this.level_is_completed = false;
    loadDoc(this.filename);
    this.Level_to_Array();

    this.starttime = new Date(); // Init. timer.
    this.moves = 0;
    this.Player.is = PlayerDlg.is;        // First or second?
    this.Computer.is = ComputerDlg.is;    // First or second?
    this.check_spots_number();            // Init. spots number.
    InitStatus();                    // Init. status line.
//    this.bild_ground();                   // Bild map of spots un board.
    this.member_last_move();              // Save last moving.
    this.redraw();                        // Draw all.
    if (this.Computer.is == 1) this.computer_move();
    return 0;
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Starts current game from the begining.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.NewGame = function()
{
    if (this.moves)
    {
        PlayMySound("changepage.wav");
        this.init();
        if (this.ComputerDlg.is == 1)
        {
           // Sleep(700);
            this.computer_move();
            this.check_spots_number();
            InitStatus();
        }
    }
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Do moving back.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.Undo = function()
{
//    if (GetMenuState(GetMenu(hwnd), IDM_Undo, MF_BYCOMMAND) == MF_GRAYED) return;

    for(var x=0; x<Asp; x++)
    {
        for(var y=0; y<Bsp; y++)
        {
            this.data_level[x*Bsp+y] = this.data_undo[x*Bsp+y];
            if (this.data_level[x*Bsp+y] == '2') {this.curX = x; this.curY = y;}
            this.putthis(2, x, y, this.data_level[x*Bsp+y]);
        }
    }
    this.moves--;
    this.check_spots_number();
    InitStatus();
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Save last moving.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.member_last_move = function()
{
    for(var x=0; x<Asp; x++)
        for(var y=0; y<Bsp; y++)
            this.data_undo[x*Bsp+y] = this.data_level[x*Bsp+y];
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Draws a board in the memory.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.bild_ground = function()
{
    // Bilds the ground array
    for(var x=0; x<Asp; x++)
        for(var y=0; y<Bsp; y++)
        {
            switch (this.data_level[x*Bsp+y])
            {
                case ' ':
                case '1': this.data_lev_gr[x*Bsp+y] = this.data_level[x*Bsp+y]; break;
                case '2':
                case '3': this.curX = x; this.curY = y;
            }
            this.putthis(2, x, y, this.data_level[x*Bsp+y]);
        }
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Changes level.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.change_level = function()
{
    this.filename = "G4W/spot/lev" + this.level + ".spo";
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Saves current game un the disk.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.SaveGame = function(spofilename)
{
    var handle;
    var length = Asp*Bsp;
    var filename;

    if (Save_as_Flag) filename = spofilename;
    else filename = "G4W/save/" + socfilename;

    if ((handle = open(filename, O_WRONLY | O_CREAT | O_TRUNC, S_IREAD | S_IWRITE)) == -1)
    {
        alert(hwnd, "Can't create file!","ERROR!!!", MB_OK | MB_ICONERROR);
        return -1;
    }

    if (write(handle, this.data_level, Asp*Bsp) != length)
    {
        alert(hwnd, "Can't write file!", "ERROR!!!", MB_OK | MB_ICONERROR);
        close(handle);
        return -1;
    }

    close(handle);
    return 0;
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Loads a game from the disk.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.LoadGame = function(spofilename)
{
    this.filename = socfilename;
    return this.init();
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Moves the spots un the board by mouse pressing.
//////////////////////////////////////////////////////////////////////////
//Spot.prototype.movetop = function(key)
//{
//    switch (key)
//    {
//        case 75: // Left.
//            if (data_level[curX][curY-1]==' ' || data_level[curX][curY-1]=='3')
//            {
//                member_last_move();
//                EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
//                PlayMySound("move1.wav");
//                putthis(1, curX, curY-1, '2');
//                putthis(1, curX, curY, data_lev_gr[curX][curY]);
//                curY--;
//                moves++;
//                check_end();
//                break;
//            }
//            if ((data_level[curX][curY-1]=='4' || data_level[curX][curY-1]=='5')
//            && (data_level[curX][curY-2]==' ' || data_level[curX][curY-2]=='3'))
//            {
//                member_last_move();
//                EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
//                PlayMySound("move_push.wav");
//                if (data_level[curX][curY-2] == ' ')
//                    putthis(1, curX, curY-2, '4');
//                else
//                    putthis(1, curX, curY-2, '5');
//                putthis(1, curX, curY-1, '2');
//                putthis(1, curX, curY, data_lev_gr[curX][curY]);
//                curY--;
//                moves++;
//                check_end();
//                break;
//            }
//            break;
//        case 77: // Right.
//            if (data_level[curX][curY+1]==' ' || data_level[curX][curY+1]=='3')
//            {
//                member_last_move();
//                EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
//                PlayMySound("move1.wav");
//                putthis(1, curX, curY+1, '2');
//                putthis(1, curX, curY, data_lev_gr[curX][curY]);
//                curY++;
//                moves++;
//                check_end();
//                break;
//            }
//            if ((data_level[curX][curY+1]=='4' || data_level[curX][curY+1]=='5')
//            && (data_level[curX][curY+2]==' ' || data_level[curX][curY+2]=='3'))
//            {
//                member_last_move();
//                EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
//                PlayMySound("move_push.wav");
//                if (data_level[curX][curY+2] == ' ')
//                    putthis(1, curX, curY+2, '4');
//                else
//                    putthis(1, curX, curY+2, '5');
//                putthis(1, curX, curY+1, '2');
//                putthis(1, curX, curY, data_lev_gr[curX][curY]);
//                curY++;
//                moves++;
//                check_end();
//                break;
//            }
//            break;
//        case 72: // Up.
//            if (data_level[curX-1][curY]==' ' || data_level[curX-1][curY]=='3')
//            {
//                member_last_move();
//                EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
//                PlayMySound("move1.wav");
//                putthis(1, curX-1, curY, '2');
//                putthis(1, curX, curY, data_lev_gr[curX][curY]);
//                curX--;
//                moves++;
//                check_end();
//                break;
//            }
//            if ((data_level[curX-1][curY]=='4' || data_level[curX-1][curY]=='5')
//            && (data_level[curX-2][curY]==' ' || data_level[curX-2][curY]=='3'))
//            {
//                member_last_move();
//                EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
//                PlayMySound("move_push.wav");
//                if (data_level[curX-2][curY] == ' ')
//                    putthis(1, curX-2, curY, '4');
//                else
//                    putthis(1, curX-2, curY, '5');
//                putthis(1, curX-1, curY, '2');
//                putthis(1, curX, curY, data_lev_gr[curX][curY]);
//                curX--;
//                moves++;
//                check_end();
//                break;
//            }
//            break;
//        case 80: // Down.
//            if (data_level[curX+1][curY]==' ' || data_level[curX+1][curY]=='3')
//            {
//                member_last_move();
//                EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
//                PlayMySound("move1.wav");
//                putthis(1, curX+1, curY, '2');
//                putthis(1, curX, curY, data_lev_gr[curX][curY]);
//                curX++;
//                moves++;
//                check_end();
//                break;
//            }
//            if ((data_level[curX+1][curY]=='4' || data_level[curX+1][curY]=='5')
//            && (data_level[curX+2][curY]==' ' || data_level[curX+2][curY]=='3'))
//            {
//                member_last_move();
//                EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
//                PlayMySound("move_push.wav");
//                if (data_level[curX+2][curY] == ' ')
//                    putthis(1, curX+2, curY, '4');
//                else
//                    putthis(1, curX+2, curY, '5');
//                putthis(1, curX+1, curY, '2');
//                putthis(1, curX, curY, data_lev_gr[curX][curY]);
//                curX++;
//                moves++;
//                check_end();
//                break;
//            }
//    }
//}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Refreshing of board by drawing current position of the game.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.redraw = function()
{
    if (!p2.is_loaded) return;
    // Drawing a map of current level.
    for(var x=0; x<Asp; x++)
    {
        for(var y=0; y<Bsp; y++)
        {
            this.putthis(1, x, y, this.data_level[x*Bsp+y]);

        }
    }
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Quick refreshing of board by drawing current position of the game.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.fast_redraw = function()
{

}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Draws needed sprite in window.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.putthis = function(where, x, y, kode)
{
    var kode_x, kode_y;
    var str;

    this.data_level[x*Bsp+y] = kode;

    switch (kode)
    {
        case '0': // Stown(border).
              str = "#tabs-2 div.board div:nth-child(" + (x*Bsp+y+1) + ")";
              //var kode = this.data_level[x*Bsp+y];
              $(str).removeClass().addClass("div-spo-"+kode);

            break;
        case ' ': // Empty place.
            kode = 'Z';
            if (table==2)
            {
                  str = "#tabs-2 div.board div:nth-child(" + (x*Bsp+y+1) + ")";
                  //var kode = this.data_level[x*Bsp+y];
                  $(str).removeClass().addClass("div-spo-"+kode);
            }
            else
            {
                  str = "#tabs-2 div.board div:nth-child(" + (x*Bsp+y+1) + ")";
                  //var kode = this.data_level[x*Bsp+y];
                  $(str).removeClass().addClass("div-spo-"+kode);
            }
            break;
        default:  // Player's or computer's spot.
//            kode-=48;
            if (kode==2) kode = PlayerDlg.color;
            else kode = ComputerDlg.color;

              str = "#tabs-2 div.board div:nth-child(" + (x*Bsp+y+1) + ")";
              //var kode = this.data_level[x*Bsp+y];
              $(str).removeClass().addClass("div-spo-"+kode);

            break;
    }
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Time of current game.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.retime = function()
{
    if (p2.level_is_completed) return this.htime/1000;

    this.curtime = new Date();
    this.htime = this.curtime - this.starttime;
    return this.htime/1000;
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Checks if the game is complete.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.check_end = function()
{

    if ((p2.Player.spots != 0) && (p2.Computer.spots != 0) && (!p2.level_is_completed))
    {
        if ((p2.who_is_now == 1) && (!p2.player_cant_move)) return 0;

        for(var x=1; x<(Asp-1); x++)
            for(var y=1; y<(Bsp-1); y++)
            {
                if (p2.data_level[x*Bsp+y] == ' ') return 0;
            }
    }

    p2.level_is_completed = true;
    console.log("Level is completed!");
 //    Sleep(4000);
    setTimeout(function (){
    var result;
    // Checking for a winner.
    if (p2.Player.spots == p2.Computer.spots) result = "Teko!!!";
    else if (p2.Player.spots < p2.Computer.spots) result = "Computer won!!!";
         else if (p2.Player.spots > p2.Computer.spots)
                  {
                      PlayMySound("winer1.wav");
                      result = "You are winner!!!";
                  }

    alert(result + "\n\n Party complete.");
    //{
        if (p2.level == 20) alert("Level complete. \n\n No more levels!");
        else
        {
//            SetScrollPos(hScroll, SB_CTL, level, 1);
//            UpdateWindow(hScroll);
        }
    //}
//    p2.NewGame(); // Start new party.

    }, 500);
    return 1;
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Changing level by scrolling bar.
//////////////////////////////////////////////////////////////////////////
//Spot.prototype.My_Scrolling = function(wParam, lParam)
//{
//    var prevlevel = this.level;
//    switch (LOWORD(wParam))
//    {
//        case SB_LINEUP:
//            if (this.level == 1)	return;
//            else this.level--;
//            break;
//        case SB_LINEDOWN:
//            if (this.level == 20) return;
//            else this.level++;
//            break;
//        case SB_THUMBTRACK:
//            this.level = HIWORD(wParam);
//            break;
//        case SB_PAGEUP:
//            this.level-=1;
//            if (this.level<1) this.level=1;
//            break;
//        case SB_PAGEDOWN:
//            this.level+=1;
//            if (this.level>20) this.level=20;
//            break;
//        default:
//            return;
//    }
//    if (prevlevel == this.level) return;
////    SetScrollRange((HWND)lParam, SB_CTL, 1, 20, TRUE);
////    SetScrollPos((HWND)lParam, SB_CTL, level, 1);
//    PlayMySound("move.wav");
//    this.init();
//}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Change current background.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.change_background = function(str)
{
    //makeBackGround(hwnd1, this, str);
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Player moves and computer begins to think.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.player_move = function(x, y)
{
    var kode_x, kode_y;
    this.who_is_now = 1; // chey hod
//    static BOOL first_step = TRUE;
//    static first_X, first_Y;

    if (this.first_step || this.table_was_changed)
    {
        this.first_X = x;
        this.first_Y = y;
        if (this.data_level[x*Bsp+y] != this.Player.color) return;
        PlayMySound("poper.wav");

     var str = "#tabs-2 div.board div:nth-child(" + (x*Bsp+y+1) + ")";
     var kode = this.data_level[x*Bsp+y];
     $(str).removeClass().addClass("div-spo-"+PlayerDlg.color+"big");

        this.first_step = false;
        this.table_was_changed = 0;
        return;
    }
    else
    {
        if ((x == this.first_X) && (y == this.first_Y)) // Same place. Drop down the spot.
        {
            this.putthis(1, x, y, this.Player.color);
            //-------gibuy for fast_draw-------
            this.putthis(2, x, y, this.Player.color);
            //---------------------------------
            this.first_step = true;
            return;
        }
        else
        {
            if (p2.check_the_place(x, y, p2.first_X, p2.first_Y)) // If place is empty.
            {
                p2.member_last_move();
                //EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);

                if (Math.abs(p2.first_X-x)==2 || Math.abs(p2.first_Y-y)==2) // If spot jumps.
                {
                    p2.putthis(1, p2.first_X, p2.first_Y, ' ');
                    //-------gibuy for fast_draw-------
                    p2.putthis(2, p2.first_X, p2.first_Y, ' ');
                    //---------------------------------
                }
                else // Draw new spot.
                {
                    p2.putthis(1, p2.first_X, p2.first_Y, p2.Player.color);
                    //-------gibuy for fast_draw-------
                    p2.putthis(2, p2.first_X, p2.first_Y, p2.Player.color);
                    //---------------------------------
                }
                    str = "#tabs-2 div.board div:nth-child(" + (x*Bsp+y+1) + ")";
                    kode = p2.data_level[x*Bsp+y];
                    $(str).removeClass().addClass("div-spo-"+PlayerDlg.color+"big");

                setTimeout(function (){
                        p2.putthis(1, x, y, p2.Player.color);
                        //-------gibuy for fast_draw-------
                        p2.putthis(2, x, y, p2.Player.color);
                        //---------------------------------

                        PlayMySound("move1.wav");
                        p2.fill_around(x, y, p2.Computer.color); // Paint around all enemy.
                        p2.first_step = true;
                        p2.check_spots_number();
                        InitStatus();
                        if (p2.level_is_completed) return;
                        //Sleep(1000);
                        //----computer is begining now----
//                        do
//                        {
//                            p2.who_is_now = 2;
                            p2.computer_move();
                            p2.moves++;

//                            do
//                            {
                                // Wait for end of spots painting
                                //p2.check_end();
                                console.log(p2.ready);
  //                              Sleep(500);
 //                               console.log(p2.ready);
 //                           }
//                            while(p2.ready != true);
console.log("after computer_move");
                            p2.check_spots_number();
                            InitStatus();
//    Sleep(2000);
//                            if (p2.player_cant_move())
//                            {
//                                p2.level_is_completed = true;
//                                p2.check_end();
//                                return;
//                            }

   //                     }
  //                      while(p2.player_cant_move());
                },500);
                return;
            }

            p2.putthis(1, p2.first_X, p2.first_Y, p2.Player.color);
            //-------gibuy for fast_draw-------
            p2.putthis(2, p2.first_X, p2.first_Y, p2.Player.color);
            //---------------------------------
            p2.first_step = true;
        }
    }
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Check if Player can to move.
// If not - computer is moving again.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.player_cant_move = function()
{
    var x, y;
    console.log("Player spots: " + p2.Player.spots);
    console.log("Computer spots: " + p2.Computer.spots);
    for (x=1; x<(Asp-1); x++)
        for (y=1; y<(Bsp-1); y++)
        {
            if (p2.data_level[x*Bsp+y] == p2.Player.color)
            {
                let i, j;
                for (i=x-2; i<=(x+2); i++)
                    for (j=y-2; j<=(y+2); j++)
                    {
                        if (i<1 || i>=(Asp-1) || j<1 || j>=(Bsp-1)) continue;
                        if ((x==i) && (y==j)) continue;
                        if (p2.data_level[i*Bsp+j] == ' ') return false;
                    }
            }
        }
        console.log("Player can't move");
    return true;
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Scan spots of Computer in all matrix and find the best place to move.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.computer_move = function()
{
    this.who_is_now = 2;
    var X_from, Y_from;
    var best = Object.create(PLACE);
    var choyse; // = Object.create(PLACE);
    var i,j;
    for (i=1; i<(Asp-1); i++)
    {
        for (j=1; j<(Bsp-1); j++)
        {
            if (this.data_level[i*Bsp+j] == this.Computer.color)
            {
                choyse = this.check_around(i, j);
                if (best.num < choyse.num)
                {
                    //best = choyse;
                    best.x = choyse.x;
                    best.y = choyse.y;
                    best.num = choyse.num;
                    best.next = choyse.next;

                    X_from = i;
                    Y_from = j;
                }
            }
        }
    }
    p2.ready = false; //to delete later
    if (best.num != -1) // If found place.
    {
    //Sleep(300);
        setTimeout(function (){
            p2.draw_computer_moving(X_from, Y_from, best); // Computer moves.
            }, 1000);
    }
    else p2.ready = true;  // to delete later
    console.log("exit from computer_move()"); // to delete later
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Draws the computer's moving.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.draw_computer_moving = function(x, y, best)
{
    PlayMySound("poper.wav");

     var str = "#tabs-2 div.board div:nth-child(" + (x*Bsp+y+1) + ")";
     var kode = this.data_level[x*Bsp+y];
     $(str).removeClass().addClass("div-spo-"+ComputerDlg.color+"big");
    //-----------------------

 //   Sleep(5000);
setTimeout(function (){
    //-----------------------
    //console.log(best);
    if (Math.abs(best.x-x) == 2 || Math.abs(best.y-y) == 2)
    {
        p2.putthis(1, x, y, ' ');
        //-------gibuy for fast_draw-------
        p2.putthis(2, x, y, ' ');
    }
    else
    {
        p2.putthis(1, x, y, p2.Computer.color);
        //-------gibuy for fast_draw-------
        p2.putthis(2, x, y, p2.Computer.color);
        //---------------------------------
    }

    //-----------------------
     str = "#tabs-2 div.board div:nth-child(" + (best.x*Bsp+best.y+1) + ")";
     kode = p2.data_level[best.x*Bsp+best.y];
     $(str).removeClass().addClass("div-spo-"+ComputerDlg.color+"big");
    //-----------------------

setTimeout(function (){
    //-----------------------
    p2.putthis(1, best.x, best.y, p2.Computer.color);
    //-------gibuy for fast_draw-------
    p2.putthis(2, best.x, best.y, p2.Computer.color);
    //-----------------------

setTimeout(function (){
    //-----------------------
    PlayMySound("move1.wav");
    p2.fill_around(best.x, best.y, p2.Player.color);

    }, 500);

    }, 500);

    }, 300);
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Find destination places. (Recursia)
//////////////////////////////////////////////////////////////////////////
Spot.prototype.check_around = function(x, y)
{
    var i, j, bonus=0, num=0;
    var scolko_odinakovux=0;

    if (this.first_time) this.best.num=-1;

    for (i=x-2; i<=x+2; i++)
        for (j=y-2; j<=y+2; j++)
        {
            if (i<1 || i>=(Asp-1) || j<1 || j>=(Bsp-1)) continue;
            if ((x==i) && (y==j)) continue;
            if ((Math.abs(x-i) <= 1) && (Math.abs(y-j) <= 1)) bonus=1;
            else bonus=0;

            if (this.data_level[i*Bsp+j] == ' ')
            {
                num = this.calculate_Players_spots_to_draw(i, j);
                num += bonus;
                if (num >= this.best.num)
                {
                    if (this.first_time)
                    {
                        if (num > this.best.num) scolko_odinakovux = 1;
                        else scolko_odinakovux++;
                        this.best.num = num;
                    }
                    else
                    {
                        if (num == this.best.num)
                        {
                            scolko_odinakovux++;
                            if (scolko_odinakovux == this.kakoe_iz_odinakovux_vubrat)
                            {
                                this.best.x = i;
                                this.best.y = j;
                                this.best.num = num;
                                this.best.next = 0;
                                this.first_time = true;
                                return this.best;
                            }
                        }
                    }
                }
            }
        }
    if (this.best.num != -1)
    {
        //randomize();
        this.kakoe_iz_odinakovux_vubrat = Math.floor(1 + (Math.random()*10 % scolko_odinakovux));
        this.first_time = false;
        this.check_around(x, y);
    }
    this.first_time = true;
    return this.best;
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Calculate number of Player's spots to draw.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.calculate_Players_spots_to_draw = function(x, y)
{
    var i, j, num=0;
    for (i=x-1; i<=x+1; i++)
        for (j=y-1; j<=y+1; j++)
        {
            if (i<1 || i>=(Asp-1) || j<1 || j>=(Bsp-1)) continue;
            if ((x==i) && (y==j)) continue;
            if (this.data_level[i*Bsp+j] == this.Player.color) num++;
        }
    return num;
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Check if able to put here spot.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.check_the_place = function(x, y, first_X, first_Y)
{
    if (this.data_level[x*Bsp+y] != ' ') return false;
    if (Math.abs(first_X-x)>2 || Math.abs(first_Y-y)>2) return false;
    return true;
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Paint all the enemy's spots.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.fill_around = function(x, y, color)
{
    var i, j;
    for (i=x-1; i<=x+1; i++)
        for (j=y-1; j<=y+1; j++)
            if (this.data_level[i*Bsp+j] == color)
            {
  //              setTimeout(function (){
                    this.putthis(1, i, j, this.data_level[x*Bsp+y]);
                    //-------gibuy for fast_draw-------
                    this.putthis(2, i, j, this.data_level[x*Bsp+y]);
                    //---------------------------------
  //              }, 1000);

            }

    p2.check_spots_number();

  // if now is step of player, check if player can to move
    if ((p2.who_is_now == 2) && p2.player_cant_move())
                                {
                                    p2.level_is_completed = true; // if no, we say that game is over
                                }

    p2.check_end();
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Calculate number of spots for Player and Computer.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.check_spots_number = function()
{
    this.Player.spots = 0;
    this.Computer.spots = 0;
    for(var x=1; x<Asp; x++)
        for(var y=1; y<Bsp; y++)
        {
            if (this.data_level[x*Bsp+y] == this.Player.color) this.Player.spots++;
            if (this.data_level[x*Bsp+y] == this.Computer.color) this.Computer.spots++;
        }
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Converting level from text-format to array.
//////////////////////////////////////////////////////////////////////////
Spot.prototype.Level_to_Array = function()
{
    //level_in_text_format_Z = level_in_text_format.replace(/ /g ,'Z');
    //level_in_text_format_Z = level_in_text_format.split(" ").join("Z");

     for(var x=0; x < (Asp*Bsp); x++) {
                this.data_level[x] = level_in_text_format[x];
            }
}
//////////////////////////////////////////////////////////////////////////


//extern cl_spot* p2;

//////////////////////////////////////////////////////////////////////////
// Change table Dialog.
//////////////////////////////////////////////////////////////////////////
//function TableDlgProc(hdwnd, message, wParam, lParam)
//{
//    static HWND hwndTT;    // handle of tooltip
//    static TOOLINFO ti;    // tool information
//    static char *szTips="Table changer";
//
//    switch(message)
//    {
//        case WM_INITDIALOG :
//            hwndTT = CreateWindow(TOOLTIPS_CLASS, (LPSTR) NULL, TTS_ALWAYSTIP,
//            CW_USEDEFAULT, CW_USEDEFAULT, CW_USEDEFAULT, CW_USEDEFAULT,
//            NULL, (HMENU) NULL, hInst, NULL);
//
//            if (hwndTT == (HWND) NULL) return 0;
//
//            ti.cbSize = sizeof(TOOLINFO);
//            ti.uFlags = TTF_IDISHWND | TTF_CENTERTIP | TTF_SUBCLASS;
//            ti.hwnd = hdwnd;
//            ti.hinst = 0;//hInst;
//            ti.uId = (UINT) hdwnd;
//            ti.lpszText = (LPSTR) szTips;
//            SendMessage(hwndTT, TTM_ADDTOOL, 0, (LPARAM)(LPTOOLINFO)&ti);
//
//            ti.uId = (UINT)GetDlgItem(hdwnd, IDC_BUTTON1);
//            SendMessage(hwndTT, TTM_ADDTOOL, 0, (LPARAM)(LPTOOLINFO)&ti);
//            return 1;
//
//        case WM_COMMAND:
//            switch(LOWORD(wParam))
//            {
//                case IDC_BUTTON1:
//                    if (HIWORD(wParam) == BN_CLICKED)
//                        SendMessage(hwnd, WM_COMMAND, IDM_Table, 0);
//                    return 1;
//            }
//    }
//    return 0;
//}
//////////////////////////////////////////////////////////////////////////

