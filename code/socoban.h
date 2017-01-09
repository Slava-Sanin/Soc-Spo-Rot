function Socoban() {
    this.level = 1;
    this.data_level = [];
    this.data_lev_gr = [];
    this.data_undo = [];
    this.starttime;
    this.curtime;
    this.htime;
    this.moves;
    this.background;
    this.filename;
    this.curX;
    this.curY;
    this.error = 0;
    this.level_is_completed = false;
    this.is_loaded = 0;
//   public:
//////////////////////////////////////////////////////////////////////////
// Constructor bilds a window, background and fills a map of level.
//////////////////////////////////////////////////////////////////////////
//constructor()
//{
   //     strcpy(background, "");
   //     change_background(path1);

//        this.level=1;
//        change_level();
//        init();
    return this;
}
//////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////
// Starts a game.
// Loads file of level, initializes timer, bilds background,
// member current position.
//////////////////////////////////////////////////////////////////////////
Socoban.prototype.init = function()
{
    //var handle;
    this.error = 0;

//    if ((handle = open(this.filename, O_RDONLY | O_TEXT, S_IREAD)) == -1)
//    {
//        this.error=1;
//        alert("Can't open file!", "ERROR!!!", MB_OK | MB_ICONERROR);
//        return -1;
//    }
//    if (read(handle, data_level,A*B) == -1)
//    {
//        close(handle);
//        this.error=1;
//        alert(hwnd, "Can't read file!", "ERROR!!!", MB_OK | MB_ICONERROR);
//        return -1;
//    }
//    close(handle);

    loadDoc(this.filename);
    this.Level_to_Array();

//    $("#tabs-1 div.board").html(level_in_text_format);

    this.starttime = new Date();
    this.moves = 0;
    this.bild_ground();
    this.member_last_move();
    this.level_is_completed = false;
    $("#btn-undo").prop('disabled',true);
    return 0;
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Starts current game from the begining.
//////////////////////////////////////////////////////////////////////////
Socoban.prototype.NewGame = function()
{
    if (this.moves)
    {
        PlayMySound("changepage.wav");

        this.init();
//        EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_GRAYED);

    }
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Do moving back.
//////////////////////////////////////////////////////////////////////////
Socoban.prototype.Undo = function()
{
   //if (GetMenuState(GetMenu(hwnd), IDM_Undo, MF_BYCOMMAND) == MF_GRAYED) return;
   if (this.level_is_completed == true) return;
    for(var x=0; x<A; x++)
    {
        for(var y=0; y<B; y++)
        {
            this.data_level[x*B+y] = this.data_undo[x*B+y];
            if (this.data_level[x*B+y] == '2') {this.curX=x; this.curY=y;}
            this.putthis(x, y, this.data_level[x*B+y]);
        }
    }
    this.moves--;
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Save last moving.
//////////////////////////////////////////////////////////////////////////
Socoban.prototype.member_last_move = function()
{
    for(var x=0; x<A; x++)
        for(var y=0; y<B; y++)
            this.data_undo[x*B+y] = this.data_level[x*B+y];
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Draws a map of level in the window.
//////////////////////////////////////////////////////////////////////////
Socoban.prototype.bild_ground = function()
{
    // find cursor and bild the ground array
    for(var x=0; x<A; x++)
        for(var y=0; y<B; y++)
        {
            switch (this.data_level[x*B+y])
            {
                case '1':
                case '3': this.data_lev_gr[x*B+y] = this.data_level[x*B+y]; break;
                case '2': this.curX = x; this.curY = y;
                case '4':
                case ' ': this.data_lev_gr[x*B+y] = ' '; break;
                case '5': this.data_lev_gr[x*B+y] = '3';
            }
            this.putthis(x, y, this.data_level[x*B+y]);
        }
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Changes level.
//////////////////////////////////////////////////////////////////////////
Socoban.prototype.change_level = function()
{
//    var str;
//    strcpy(this.filename, this.CurPath);
//    strcat(this.filename, "\\socoban\\lev");
//    sprintf(str, "%d.soc", this.level);
//    strcat(this.filename, str);
//this.level
    this.filename = "G4W/socoban/LEV" + this.level + ".SOC";
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Saves current game on the disk.
//////////////////////////////////////////////////////////////////////////
Socoban.prototype.SaveGame = function(socfilename)
{
    var handle;
    var length = A*B;
    var filename;

    if (Save_as_Flag) filename = socfilename;
    else filename = "G4W/save/" + socfilename;

    if ((handle = open(filename, O_WRONLY | O_CREAT | O_TRUNC, S_IREAD | S_IWRITE)) == -1)
    {
        alert(hwnd, "Can't create file!","ERROR!!!", MB_OK | MB_ICONERROR);
        return -1;
    }

    if (write(handle, this.data_level, A*B) != length)
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
Socoban.prototype.LoadGame = function(socfilename)
{
    this.filename = socfilename;
    return this.init();
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Moves the object on the display by key or mouse pressing.
//////////////////////////////////////////////////////////////////////////
Socoban.prototype.movetop = function(key)
{
    switch (key)
    {
        case 75: // Moving left.
            if (this.data_level[this.curX*B+this.curY-1]==' ' || this.data_level[this.curX*B+this.curY-1]=='3')
            {
                this.member_last_move();
               // EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
               $("#btn-undo").prop('disabled',false);
                PlayMySound("move1.wav");
                this.putthis(this.curX, this.curY-1, '2');
                this.putthis(this.curX, this.curY, this.data_lev_gr[this.curX*B+this.curY]);
                this.curY--;
                this.moves++;
                this.check_end();
                break;
            }
            if ((this.data_level[this.curX*B+this.curY-1]=='4' || this.data_level[this.curX*B+this.curY-1]=='5')
            && (this.data_level[this.curX*B+this.curY-2]==' ' || this.data_level[this.curX*B+this.curY-2]=='3'))
            {
                this.member_last_move();
                // EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
                $("#btn-undo").prop('disabled',false);
                PlayMySound("move_push.wav");
                if (this.data_level[this.curX*B+this.curY-2] == ' ')
                    this.putthis(this.curX, this.curY-2, '4');
                else
                    this.putthis(this.curX, this.curY-2, '5');
                this.putthis(this.curX, this.curY-1, '2');
                this.putthis(this.curX, this.curY, this.data_lev_gr[this.curX*B+this.curY]);
                this.curY--;
                this.moves++;
                this.check_end();
                break;
            }
            break;
        case 77: // Moving right.
            if (this.data_level[this.curX*B+this.curY+1]==' ' || this.data_level[this.curX*B+this.curY+1]=='3')
            {
                this.member_last_move();
                // EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
                $("#btn-undo").prop('disabled',false);
                PlayMySound("move1.wav");
                this.putthis(this.curX, this.curY+1, '2');
                this.putthis(this.curX, this.curY, this.data_lev_gr[this.curX*B+this.curY]);
                this.curY++;
                this.moves++;
                this.check_end();
                break;
            }
            if ((this.data_level[this.curX*B+this.curY+1]=='4' || this.data_level[this.curX*B+this.curY+1]=='5')
            && (this.data_level[this.curX*B+this.curY+2]==' ' || this.data_level[this.curX*B+this.curY+2]=='3'))
            {
                this.member_last_move();
                // EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
                $("#btn-undo").prop('disabled',false);
                PlayMySound("move_push.wav");
                if (this.data_level[this.curX*B+this.curY+2] == ' ')
                    this.putthis(this.curX, this.curY+2, '4');
                else
                    this.putthis(this.curX, this.curY+2, '5');
                this.putthis(this.curX, this.curY+1, '2');
                this.putthis(this.curX, this.curY, this.data_lev_gr[this.curX*B+this.curY]);
                this.curY++;
                this.moves++;
                this.check_end();
                break;
            }
            break;
        case 72: // Moving up.
            if (this.data_level[(this.curX-1)*B+this.curY]==' ' || this.data_level[(this.curX-1)*B+this.curY]=='3')
            {
                this.member_last_move();
                // EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
                $("#btn-undo").prop('disabled',false);
                PlayMySound("move1.wav");
                this.putthis(this.curX-1, this.curY, '2');
                this.putthis(this.curX, this.curY, this.data_lev_gr[this.curX*B+this.curY]);
                this.curX--;
                this.moves++;
                this.check_end();
                break;
            }
            if ((this.data_level[(this.curX-1)*B+this.curY]=='4' || this.data_level[(this.curX-1)*B+this.curY]=='5')
            && (this.data_level[(this.curX-2)*B+this.curY]==' ' || this.data_level[(this.curX-2)*B+this.curY]=='3'))
            {
                this.member_last_move();
                // EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
                $("#btn-undo").prop('disabled',false);
                PlayMySound("move_push.wav");
                if (this.data_level[(this.curX-2)*B+this.curY] == ' ')
                    this.putthis(this.curX-2, this.curY, '4');
                else
                    this.putthis(this.curX-2, this.curY, '5');
                this.putthis(this.curX-1, this.curY, '2');
                this.putthis(this.curX, this.curY, this.data_lev_gr[this.curX*B+this.curY]);
                this.curX--;
                this.moves++;
                this.check_end();
                break;
            }
            break;
        case 80: // Moving down.
            if (this.data_level[(this.curX+1)*B+this.curY]==' ' || this.data_level[(this.curX+1)*B+this.curY]=='3')
            {
                this.member_last_move();
                // EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
                $("#btn-undo").prop('disabled',false);
                PlayMySound("move1.wav");
                this.putthis(this.curX+1, this.curY, '2');
                this.putthis(this.curX, this.curY, this.data_lev_gr[this.curX*B+this.curY]);
                this.curX++;
                this.moves++;
                this.check_end();
                break;
            }
            if ((this.data_level[(this.curX+1)*B+this.curY]=='4' || this.data_level[(this.curX+1)*B+this.curY]=='5')
            && (this.data_level[(this.curX+2)*B+this.curY]==' ' || this.data_level[(this.curX+2)*B+this.curY]=='3'))
            {
                this.member_last_move();
                // EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
                $("#btn-undo").prop('disabled',false);
                PlayMySound("move_push.wav");
                if (this.data_level[(this.curX+2)*B+this.curY] == ' ')
                    this.putthis(this.curX+2, this.curY, '4');
                else
                    this.putthis(this.curX+2, this.curY, '5');
                this.putthis(this.curX+1, this.curY, '2');
                this.putthis(this.curX, this.curY, this.data_lev_gr[this.curX*B+this.curY]);
                this.curX++;
                this.moves++;
                this.check_end();
                break;
            }
    }
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Refreshing of board by drawing current position of the game.
//////////////////////////////////////////////////////////////////////////
Socoban.prototype.redraw = function()
{
    // Drawing a map of current level.
    for(var x=0; x<A; x++)
    {
        for(var y=0; y<B; y++)
        {
            this.putthis(x, y, this.data_level[x*B+y]);

        }
    }
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Draws needed sprite in window.
//////////////////////////////////////////////////////////////////////////
Socoban.prototype.putthis = function(x, y, kode)
{
    var kode_x, kode_y;

    this.data_level[x*B+y] = kode;

    if (kode == ' ') // Draws empty place.
    {
        kode = 'Z';
    }
//    else // Draws other objects of level map.
//    {
//        kode = kode-48;
//        kode_x = kode*25;
//        kode_y=0;
//
//    }
     var str = "#tabs-1 div.board div:nth-child(" + (x*B+y+1) + ")";
     $(str).removeClass().addClass("div-soc-"+kode);
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Time of current game.
//////////////////////////////////////////////////////////////////////////
Socoban.prototype.retime = function()
{
    this.curtime = new Date();
    this.htime = this.curtime - this.starttime;
    return this.htime/1000;
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Checks if the game is complete.
//////////////////////////////////////////////////////////////////////////
Socoban.prototype.check_end = function()
{
    for(var x=0; x<A; x++)
    {
        for(var y=0; y<B; y++)
        {
            if (this.data_lev_gr[x*B+y]=='3' && this.data_level[x*B+y]!='5')
                return;
        }
    }

    PlayMySound("winer1.wav");

    $("#btn-undo").prop('disabled',true);
    // Delay before the confirm window is shown
    setTimeout(function (){
    if (confirm("Level completed. Next level?") == true)
    {
        if (p1.level == 20) // If this is a last level.
            alert("Level completed. No more levels!");
        else
        {
            p1.level++;
            //SetScrollPos(hScroll, SB_CTL, level, 1);
            //UpdateWindow(hScroll);
            $("#tabs-1 .scroll .lev-position").css("height", 15 * p1.level + 4);
            p1.change_level();  // Load next level.
            p1.NewGame(); // Play again.
        }
    }
    }, 500);
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Changing level by scrolling bar.
//////////////////////////////////////////////////////////////////////////
Socoban.prototype.My_Scrolling = function(wParam, lParam)
{
    var prevlevel = this.level;
    switch (LOWORD(wParam))
    {
        case SB_LINEUP:
            if (this.level == 1)	return;
            else this.level--;
            break;
        case SB_LINEDOWN:
            if (this.level == 20) return;
            else this.level++;
            break;
        case SB_THUMBTRACK:
            this.level = HIWORD(wParam);
            break;
        case SB_PAGEUP:
            this.level-=1;
            if (this.level < 1) this.level=1;
            break;
        case SB_PAGEDOWN:
            this.level+=1;
            if (this.level > 20) this.level=20;
            break;
        default:
            return;
    }
    if (prevlevel == this.level) return;
  //  SetScrollRange((HWND)lParam, SB_CTL, 1, 20, TRUE);
   // SetScrollPos((HWND)lParam, SB_CTL, level, 1);
    PlayMySound("move.wav");
    this.change_level();               // Change and load level.
    this.init();                       // New game.
   // EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_GRAYED);
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Change current background.
//////////////////////////////////////////////////////////////////////////
Socoban.prototype.change_background = function(str)
{
   // makeBackGround(hwnd1, me, str);
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Converting level from text-format to array.
//////////////////////////////////////////////////////////////////////////
Socoban.prototype.Level_to_Array = function()
    {
        //level_in_text_format_Z = level_in_text_format.replace(/ /g ,'Z');
        //level_in_text_format_Z = level_in_text_format.split(" ").join("Z");

         for(var x=0; x < (A*B); x++) {
                 //for(var y=0; y<B; y++)
                    this.data_level[x] = level_in_text_format[x];
                }
    }
//////////////////////////////////////////////////////////////////////////
