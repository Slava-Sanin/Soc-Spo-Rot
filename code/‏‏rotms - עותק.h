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

    level = 1;
    flag_push = 0;
    change_level();
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
            putthis(x, y, this.data_undo[x*B+y]);
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
            this.putthis(x, y, data_level[x][y]);
        }
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
    this.filename = "G4W/rotms/LEV" + this.level + ".ROT";
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

    if (write(handle, &data_level, A*B) != length)
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
    if (this.data_level[x*B+y]>'0' && data_level[x*B+y]<'6')
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
    setTimeout(this.fire_all_on_pushing(x, y), 200);
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
            for (Ytemp = this.curY - 1;((this.data_level[this.curX * B + Ytemp] < '0')
            || (this.data_level[this.curX * B + Ytemp] > '5')) && (Ytemp > 0); Ytemp--);
            while(Ytemp != this.curY - 1)
            {
                if (this.data_level[curX * B + Ytemp] == ' ')
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
            for (Ytemp = this.curY + 1; ((this.data_level[curX * B + Ytemp]<'0')
            || (this.data_level[curX * B + Ytemp] > '5')) && (Ytemp < (B-1)); Ytemp++);
            while(Ytemp != this.curY+1)
            {
                if (this.data_level[this.curX*B+Ytemp] == ' ')
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
            || (this.data_level[Xtemp * B + curY] > '5')) && (Xtemp > 0); Xtemp--);
            while(Xtemp != this.curX - 1)
            {
                if (this.data_level[Xtemp * B + curY] == ' ')
                {
                    this.putthis(Xtemp, this.curY, this.data_level[(Xtemp+1) * B + curY]);
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
        kode = 0;
    }
    else
    {
        switch (kode) // Draws other objects of level map.
        {
            case 'B': kode=6; break;
            case 'G': kode=7; break;
            case 'K': kode=8; break;
            case 'R': kode=9; break;
            case 'S': kode=10; break;
            case 'Y': kode=11; break;
            default: kode=kode-48;
        }
        kode_x=kode*25;
        kode_y=0;
        if (kode>5)
        {
            SelectObject(memdctemp, bkgrnd);
            BitBlt(hdc1, otstup + y*25, otstup + x*25, 25, 25, memdctemp,
            otstup + y*25, otstup + x*25, SRCCOPY);
            SelectObject(memdctemp, hmap);
            BitBlt(hdc1, otstup + y*25, otstup + x*25, 25, 25, memdctemp,
            kode_x, kode_y+25, SRCAND);
            BitBlt(hdc1, otstup + y*25, otstup + x*25, 25, 25, memdctemp,
            kode_x, kode_y, SRCINVERT);
        }
        else
        {
            SelectObject(memdctemp, hmap);
            if (flag_push)
            {
                BitBlt(hdc1, otstup + y*25, otstup + x*25, 25, 25, memdctemp,
                kode_x, kode_y+25, SRCCOPY);
                Sleep(60);
                flag_push=0;
            }
            BitBlt(hdc1, otstup + y*25, otstup + x*25, 25, 25, memdctemp,
            kode_x, kode_y, SRCCOPY);
        }
    }
    DeleteDC(memdctemp);
    ReleaseDC(hwnd1, hdc1);
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Time of current game.
//////////////////////////////////////////////////////////////////////////
double cl_rotms::retime()
{
    curtime=time(NULL);
    htime=difftime(curtime, starttime);
    return htime;
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Checks if the game is complete.
//////////////////////////////////////////////////////////////////////////
void cl_rotms::check_end()
{
    for(int x=0; x<A; x++)
    {
        for(int y=0; y<B; y++)
        {
            if ((data_level[x][y]=='B') || (data_level[x][y]=='G')
             || (data_level[x][y]=='K') || (data_level[x][y]=='R')
             || (data_level[x][y]=='S') || (data_level[x][y]=='Y'))
                return;
        }
    }
    PlayMySound("end1.wav");
    if (alert(hwnd, "   Next level?","Level complete.",
    MB_YESNO | MB_ICONQUESTION) == IDYES)
    {
        if (level==20) // If this is a last level.
            alert(hwnd, "No more levels!", "Level complete.",
            MB_OK | MB_ICONSTOP);
        else
        {
            level++;
            SetScrollPos(hScroll, SB_CTL, level, 1);
            UpdateWindow(hScroll);
            change_level();  // Load next level.
        }
    }
    NewGame(); // Play again.
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Changing level by scrolling bar.
//////////////////////////////////////////////////////////////////////////
void cl_rotms::My_Scrolling(WPARAM wParam, LPARAM lParam)
{
    int prevlevel=level;
    switch (LOWORD(wParam))
    {
        case SB_LINEUP:
            if (level==1)	return;
            else level--;
            break;
        case SB_LINEDOWN:
            if (level==20) return;
            else level++;
            break;
        case SB_THUMBTRACK:
            level=HIWORD(wParam);
            break;
        case SB_PAGEUP:
            level-=1;
            if (level<1) level=1;
            break;
        case SB_PAGEDOWN:
            level+=1;
            if (level>20) level=20;
            break;
        default:
            return;
    }
    if (prevlevel == level) return;
    SetScrollRange((HWND)lParam, SB_CTL, 1, 20, TRUE);
    SetScrollPos((HWND)lParam, SB_CTL, level, 1);
    PlayMySound("move.wav");
    change_level();               // Change and load level.
    init();                       // New game.
    EnableMenuItem(GetMenu(hwnd), IDM_Undo, MF_GRAYED);
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Change current background.
//////////////////////////////////////////////////////////////////////////
void cl_rotms::change_background(char *str)
{
    makeBackGround(hwnd1, this, str);
}
//////////////////////////////////////////////////////////////////////////


extern cl_rotms* p3;
#include "fire.h"  // Defining class fire
//////////////////////////////////////////////////////////////////////////
// Searchs the board and fires all rotms that must to fire.
//////////////////////////////////////////////////////////////////////////
void cl_rotms::fire_all_on_pushing(int x, int y)
{
    int Xtemp, Ytemp;
    switch (data_level[x][y])
    {
        case '5': moves-=3;
        case '2': // Search left.
            for (Ytemp=curY-1; ((data_level[curX][Ytemp] < '0')
            || (data_level[curX][Ytemp] > '5')) && (Ytemp>-1); Ytemp--);
            Ytemp++;
            while(Ytemp != curY)
            {
                if (data_level[x][Ytemp] != ' ')
                    fire tempfire(x, Ytemp);
                Ytemp++;
            }
            moves++;
            check_end();
            if (data_level[x][y] == '2') break;

        case '1': // Search up.
            for (Ytemp=curY+1; ((data_level[curX][Ytemp] < '0')
            || (data_level[curX][Ytemp] > '5')) && (Ytemp<B); Ytemp++);
            Ytemp--;
            while(Ytemp != curY)
            {
                if (data_level[x][Ytemp] != ' ')
                    fire temp(x, Ytemp);
                Ytemp--;
            }
            moves++;
            check_end();
            if (data_level[x][y] == '1') break;

        case '3': // Search left.
            for (Xtemp=curX-1; ((data_level[Xtemp][curY] < '0')
            || (data_level[Xtemp][curY] > '5')) && (Xtemp>-1); Xtemp--);
            Xtemp++;
            while(Xtemp != curX)
            {
                if (data_level[Xtemp][y] != ' ')
                    fire temp(Xtemp, y);
                Xtemp++;
            }
            moves++;
            check_end();
            if (data_level[x][y] == '3') break;

        case '4': // Search down
            for (Xtemp=curX+1; ((data_level[Xtemp][curY] < '0')
            || (data_level[Xtemp][curY] > '5')) && (Xtemp<A); Xtemp++);
            Xtemp--;
            while(Xtemp != curX)
            {
                if (data_level[Xtemp][y] != ' ')
                    fire tempfire(Xtemp, y);
                Xtemp--;
            }
            moves++;
            check_end();
            break;
    }
}
//////////////////////////////////////////////////////////////////////////


