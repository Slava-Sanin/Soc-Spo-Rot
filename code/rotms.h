function Rotms() {
    this.level = 1;
    this.data_level = [];
    this.data_lev_gr = [];
    this.data_undo = [];
    this.starttime;
    this.curtime;
    this.htime;
    this.moves;
    this.score;
    this.score_undo;
    this.background;
    this.filename;
    this.curX;
    this.curY;
    this.flag_push = 0;
    this.error = 0;
    this.level_is_completed = false;
    this.is_loaded = 0;

//    public:
//    cl_rotms();
//    ~cl_rotms();
//    int init();
//    void NewGame();
//    void Undo();
//    void member_last_move();
//    void bild_ground();
//    void change_level();
//    int SaveGame(char *);
//    int LoadGame(char *);
//    void pushbutton(int ,int);
//    void movetop(char);
//    void fire_all_on_pushing(int, int);
//    void redraw();
//    void putthis(int ,int ,char);
//    double retime();
//    void check_end();
//    void My_Scrolling(WPARAM, LPARAM);
//    void change_background(char *);

    return this;
}


/////////////////////////////////////////////////////////////////////////
// Starts a game.
// Loads file of level, initializes timer, bilds background,
// member current position.
//////////////////////////////////////////////////////////////////////////
Rotms.prototype.init = function()
{
//    hwnd1=CreateWindow("STATIC", NULL, WS_CHILD | WS_DLGFRAME,
//    W1-4, W2-4, W3+35, W4+6, hTabWnd, NULL, hInst, NULL);
//    strcpy(background, "");
//    change_background(path3);

//    this.level = 1;
//    this.flag_push = 0;
//    this.change_level();
//    init();
    loadDoc(this.filename);
    this.Level_to_Array();

    this.starttime = new Date();
    this.score = 0;
    this.score_undo = 0;
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
Rotms.prototype.NewGame = function()
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
Rotms.prototype.Undo = function()
{
//    if (GetMenuState(GetMenu(hwnd), IDM_Undo, MF_BYCOMMAND) == MF_GRAYED) return;
    if (this.level_is_completed == true) return;
    for(var x=0; x<A; x++)
    {
        for(var y=0; y<B; y++)
            this.putthis(x, y, this.data_undo[x*B+y]);
    }
    this.score = this.score_undo;
    this.moves--;
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Save last moving.
//////////////////////////////////////////////////////////////////////////
Rotms.prototype.member_last_move = function()
{
    for(var x=0; x<A; x++)
        for(var y=0; y<B; y++)
            this.data_undo[x*B+y] = this.data_level[x*B+y];
    this.score_undo = this.score;
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Draws a map of level in the window.
//////////////////////////////////////////////////////////////////////////
Rotms.prototype.bild_ground = function()
{
    // find cursor and bild the ground array
    for(var x=0; x<A; x++)
        for(var y=0; y<B; y++)
        {
            switch (this.data_level[x*B+y])
            {
                case '0':
                case '1':
                case '2':
                case '3':
                case '4':
                case '5': this.data_lev_gr[x*B+y] = this.data_level[x*B+y]; break;
                default:  this.data_lev_gr[x*B+y] = ' ';
            }
            this.putthis(x, y, this.data_level[x*B+y]);
        }

    //$(".div-rot-1,.div-rot-2,.div-rot-3,.div-rot-4,.div-rot-5").click(SomeArrow);
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Changes level.
//////////////////////////////////////////////////////////////////////////
Rotms.prototype.change_level = function()
{
//    char str[8];
//    strcpy(filename, CurPath);
//    strcat(filename, "\\rotms\\lev");
//    sprintf(str, "%d.rot", level);
//    strcat(filename, str);
    this.filename = "G4W/rotms/lev" + this.level + ".rot";
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Saves current game un the disk.
//////////////////////////////////////////////////////////////////////////
Rotms.prototype.SaveGame = function(socfilename)
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
Rotms.prototype.LoadGame = function(socfilename)
{
    this.filename = socfilename;
    return this.init();
}
/////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////
// Converting mouse pressing un button to key pressing.
/////////////////////////////////////////////////////////////////////////
Rotms.prototype.pushbutton = function(x, y)
{
    if (this.data_level[x*B+y]>'0' && this.data_level[x*B+y]<'6')
    {
        this.flag_push=1;
        this.putthis(x, y, this.data_level[x*B+y]);
        this.curX=x;
        this.curY=y;
    }
    else return;
    switch (this.data_level[x*B+y])
    {
        case '1': this.member_last_move(); this.movetop('1'); break; // Left.
        case '2': this.member_last_move(); this.movetop('2'); break; // Right.
        case '3': this.member_last_move(); this.movetop('3'); break; // Up.
        case '4': this.member_last_move(); this.movetop('4'); break; // Down.
        case '5': this.member_last_move();
                  this.movetop('1'); // Left, Right, Up and Down (All).
                  this.movetop('2');
                  this.movetop('3');
                  this.movetop('4');
    }
    //Sleep(200);
    //this.fire_all_on_pushing(x, y); // Fires the rotms.
    setTimeout(function(){ p3.fire_all_on_pushing(x, y); }, 200);
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Moves the rotms un the board by mouse pressing.
//////////////////////////////////////////////////////////////////////////
Rotms.prototype.movetop = function(key)
{
    var Xtemp;
    var Ytemp;

    switch (key)
    {
        case '2': // Moving left.
            PlayMySound("move1.wav");
            for (Ytemp = this.curY - 1; ((this.data_level[this.curX * B + Ytemp] < '0')
            || (this.data_level[this.curX * B + Ytemp] > '5')) && (Ytemp > 0); Ytemp--);
            while(Ytemp != this.curY - 1)
            {
                if (this.data_level[this.curX * B + Ytemp] == ' ')
                {
                    this.putthis(this.curX, Ytemp, this.data_level[this.curX * B + Ytemp+1]);
                    this.putthis(this.curX, Ytemp+1, ' ');
                }
                Ytemp++;
            }
            //EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
            $("#btn-undo").prop('disabled',false);
            break;

        case '1': // Moving right.
            PlayMySound("move1.wav");
            for (Ytemp = this.curY + 1; ((this.data_level[this.curX * B + Ytemp] < '0')
            || (this.data_level[this.curX * B + Ytemp] > '5')) && (Ytemp < (B-1)); Ytemp++);
            while(Ytemp != this.curY + 1)
            {
                if (this.data_level[this.curX * B + Ytemp] == ' ')
                {
                    this.putthis(this.curX, Ytemp, this.data_level[this.curX * B + (Ytemp-1)]);
                    this.putthis(this.curX, Ytemp-1, ' ');
                }
                Ytemp--;
            }
            //EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
             $("#btn-undo").prop('disabled',false);
            break;

        case '3': // Moving up.
            PlayMySound("move1.wav");
            for (Xtemp = this.curX-1; ((this.data_level[Xtemp * B + this.curY] < '0')
            || (this.data_level[Xtemp * B + this.curY] > '5')) && (Xtemp > 0); Xtemp--);
            while(Xtemp != this.curX - 1)
            {
                if (this.data_level[Xtemp * B + this.curY] == ' ')
                {
                    this.putthis(Xtemp, this.curY, this.data_level[(Xtemp+1) * B + this.curY]);
                    this.putthis(Xtemp + 1, this.curY, ' ');
                }
                Xtemp++;
            }
            //EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
            $("#btn-undo").prop('disabled',false);
            break;

        case '4': // Moving down.
            PlayMySound("move1.wav");
            for (Xtemp = this.curX + 1; ((this.data_level[Xtemp * B + this.curY] < '0')
            || (this.data_level[Xtemp * B + this.curY] > '5')) && (Xtemp < (A-1)); Xtemp++);
            while(Xtemp != this.curX+1)
            {
                if (this.data_level[Xtemp * B + this.curY] == ' ')
                {
                    this.putthis(Xtemp, this.curY, this.data_level[(Xtemp-1) * B + this.curY]);
                    this.putthis(Xtemp-1, this.curY, ' ');
                }
                Xtemp--;
            }
            //EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_ENABLED);
            $("#btn-undo").prop('disabled',false);
            break;
    }
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Refreshing of board by drawing current position of the game.
//////////////////////////////////////////////////////////////////////////
Rotms.prototype.redraw = function()
{
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
Rotms.prototype.putthis = function(x, y, kode)
{
    var kode_x, kode_y;

    this.data_level[x*B+y] = kode;

    if (kode == ' ') // Draws empty place.
    {
        kode = 'Z';
    }

    var str = "#tabs-3 div.board div:nth-child(" + (x*B+y+1) + ")";
    $(str).removeClass().addClass("div-rot-" + kode);
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Time of current game.
//////////////////////////////////////////////////////////////////////////
Rotms.prototype.retime = function()
{
    this.curtime = new Date();
    this.htime = this.curtime - this.starttime;
    return this.htime/1000;
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Checks if the game is complete.
//////////////////////////////////////////////////////////////////////////
Rotms.prototype.check_end = function()
{
    for(var x=0; x<A; x++)
    {
        for(var y=0; y<B; y++)
        {
            if ((this.data_level[x*B+y]=='B') || (this.data_level[x*B+y]=='G')
             || (this.data_level[x*B+y]=='K') || (this.data_level[x*B+y]=='R')
             || (this.data_level[x*B+y]=='S') || (this.data_level[x*B+y]=='Y'))
                return;
        }
    }
    PlayMySound("winer1.wav");

    $("#btn-undo").prop('disabled',true);
    // Delay before the confirm window is shown
    setTimeout(function (){
    if (confirm("Level completed. Next level?") == true)
    {
        if (p3.level == 20) // If this is a last level.
        alert("Level completed. No more levels!");
        else
        {
            p3.level++;
            //SetScrollPos(hScroll, SB_CTL, level, 1);
            //UpdateWindow(hScroll);
            $("#tabs-3 .scroll .lev-position").css("height", 15 * p3.level + 4);
            p3.change_level();  // Load next level.
            p3.NewGame(); // Play again.
        }
    }
    }, 500);
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Changing level by scrolling bar.
//////////////////////////////////////////////////////////////////////////
Rotms.prototype.My_Scrolling = function(wParam, lParam)
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
            this.level=HIWORD(wParam);
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
Rotms.prototype.change_background = function(str)
{
   // makeBackGround(hwnd1, this, str);
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Converting level from text-format to array.
//////////////////////////////////////////////////////////////////////////
Rotms.prototype.Level_to_Array = function()
    {
        //level_in_text_format_Z = level_in_text_format.replace(/ /g ,'Z');
        //level_in_text_format_Z = level_in_text_format.split(" ").join("Z");

         for(var x=0; x < (A*B); x++) {
                 //for(var y=0; y<B; y++)
                    this.data_level[x] = level_in_text_format[x];
                }
    }
//////////////////////////////////////////////////////////////////////////


<?php require 'code/fire.h' ?>  // Defining class fire
//////////////////////////////////////////////////////////////////////////
// Searchs the board and fires all rotms that must to fire.
//////////////////////////////////////////////////////////////////////////
Rotms.prototype.fire_all_on_pushing = function(x, y)
{
    var Xtemp, Ytemp;
    switch (this.data_level[x*B+y])
    {
        case '5': this.moves-=3;
        case '2': // Search left.
            for (Ytemp=this.curY-1; ((this.data_level[this.curX*B+Ytemp] < '0')
            || (this.data_level[this.curX*B+Ytemp] > '5')) && (Ytemp>-1); Ytemp--);
            Ytemp++;
            while(Ytemp != this.curY)
            {
                if (this.data_level[x*B+Ytemp] != ' ')
                    {
                        var tempfire = new class_Fire();
                        tempfire.fire(x, Ytemp);
                    }
                Ytemp++;
            }
            this.moves++;
            this.check_end();
            if (this.data_level[x*B+y] == '2') break;

        case '1': // Search up.
            for (Ytemp=this.curY+1; ((this.data_level[this.curX*B+Ytemp] < '0')
            || (this.data_level[this.curX*B+Ytemp] > '5')) && (Ytemp<B); Ytemp++);
            Ytemp--;
            while(Ytemp != this.curY)
            {
                if (this.data_level[x*B+Ytemp] != ' ')
                    {
                        var tempfire = new class_Fire();
                        tempfire.fire(x, Ytemp);
                    }
                Ytemp--;
            }
            this.moves++;
            this.check_end();
            if (this.data_level[x*B+y] == '1') break;

        case '3': // Search left.
            for (Xtemp=this.curX-1; ((this.data_level[Xtemp*B+this.curY] < '0')
            || (this.data_level[Xtemp*B+this.curY] > '5')) && (Xtemp>-1); Xtemp--);
            Xtemp++;
            while(Xtemp != this.curX)
            {
                if (this.data_level[Xtemp*B+y] != ' ')
                    {
                        var tempfire = new class_Fire();
                        tempfire.fire(Xtemp, y);
                    }
                Xtemp++;
            }
            this.moves++;
            this.check_end();
            if (this.data_level[x*B+y] == '3') break;

        case '4': // Search down
            for (Xtemp=this.curX+1; ((this.data_level[Xtemp*B+this.curY] < '0')
            || (this.data_level[Xtemp*B+this.curY] > '5')) && (Xtemp<A); Xtemp++);
            Xtemp--;
            while(Xtemp != this.curX)
            {
                if (this.data_level[Xtemp*B+y] != ' ')
                    {
                        var tempfire = new class_Fire();
                        tempfire.fire(Xtemp, y);
                    }
                Xtemp--;
            }
            this.moves++;
            this.check_end();
            break;
    }
}
//////////////////////////////////////////////////////////////////////////


