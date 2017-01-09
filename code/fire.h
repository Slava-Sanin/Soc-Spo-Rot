var rotm = {
    x : 0, 
	y : 0
};

// Firing rotms class.
function class_Fire()
{
	this.mat = [Object.create(rotm), Object.create(rotm), Object.create(rotm), Object.create(rotm)];
    this.count = 0;
    this.points = 0;

    return this;
 }

//////////////////////////////////////////////////////////////////////////
// Searchs the board, finds rotms to fire and fires them, adds points if need.
//////////////////////////////////////////////////////////////////////////
class_Fire.prototype.fire = function(x, y)
{
    this.init();
    this.check_around(x, y); // Find more rotms around this rotm.
    if (this.count > 1)
    {
        if (glob_sound)
            {
              PlayMySound("fire.wav");
            }
        this.points = this.count * this.count * 10; // Points of player.
        p3.score += this.points;
        while(this.count) // Remove rotms from board.
        {
            p3.putthis(this.mat[this.count-1].x, this.mat[this.count-1].y, ' ');
            this.count--;
        }
    }
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Initializes "matrix-data base" of rotms that must been fired.
//////////////////////////////////////////////////////////////////////////
class_Fire.prototype.init = function()
{
    this.points = 0;
    this.count = 0;
    for(var i=1; i<4; i++)
    {
        this.mat[i].x = -1;
        this.mat[i].y = -1;
    }
}
//////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////
// Checks if this rotm already was founded and now in "matrix-data base".
//////////////////////////////////////////////////////////////////////////
class_Fire.prototype.find = function(x, y)
{
    for(var i=0; i < this.count; i++)
    {
        if ((this.mat[i].x == x) && (this.mat[i].y == y)) return 1;
    }
    return 0;
}
//////////////////////////////////////////////////////////////////////////


//fire::~fire(){} // Destructor.


//////////////////////////////////////////////////////////////////////////
// Recursia for searching rotms around rotm.
//////////////////////////////////////////////////////////////////////////
class_Fire.prototype.check_around = function(x, y)
{
    if (!this.find(x, y)) // If yet not in "matrix-data base".
    {
        this.mat[this.count].x = x; //  Put coordinates of rotm in to
        this.mat[this.count].y = y; //  "matrix-data base".
        this.count++; // Counts rotms that is found and must been fired.
        if (x-1 > -1) // Check place from left of rotm.
        {
            if (p3.data_level[(x-1)*B+y] == p3.data_level[x*B+y])
                this.check_around(x-1, y);
        }

        if ((y+1) < B)  // Check place from right of rotm.
        {
            if (p3.data_level[x*B+(y+1)] == p3.data_level[x*B+y])
                this.check_around(x, y+1);
        }

        if ((x+1) < A)  // Check place from up of rotm.
        {
            if (p3.data_level[(x+1)*B+y] == p3.data_level[x*B+y])
                this.check_around(x+1, y);
        }

        if ((y-1) > -1)  // Check place from down of rotm.
        {
            if (p3.data_level[x*B+(y-1)] == p3.data_level[x*B+y])
                this.check_around(x, y-1);
        }
    }
}
//////////////////////////////////////////////////////////////////////////
