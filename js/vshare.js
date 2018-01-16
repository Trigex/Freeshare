
function createNewList() 
{
    var name = prompt("Enter a name for a new contact group.", "");
    if(name)
    {
    	document.location.href="friends.php?add_list="+name;
    }
}
function doAction(action) 
{
    if(action)
    {	
        document.getElementById('action_name').value = action;
        document.friendsForm.submit();
    }
}

function invite_mem_addall() 
{
    var x=document.getElementById("myfriends");
    var y=document.getElementById("invitefriends");
    var i;
    i= x.options.length;
    
    if(i!=0)
    {
        y.options.length=i;
        for(var j=0;j<i;j++)
        {
                y.options[j]=new Option(x.options[j].text,x.options[j].value);
        }
        for(j=0;j<i;j++)
        {
                x.remove(0);
        }
    }
}

function invite_mem_add() 
{
    var x=document.getElementById("myfriends");
    var y=document.getElementById("invitefriends");
    var i;
    i = x.selectedIndex;
    if(i>=0)
    {
		y.options[y.options.length]=new Option(x.options[i].text,x.options[i].value);
		x.remove(x.selectedIndex);
    }
}

function invite_mem_removeall() 
{
    var x=document.getElementById("invitefriends");
    var y=document.getElementById("myfriends");
    var i;
    i= x.options.length;
    if(i!=0)
    {
        y.options.length=i;
        for(var j=0;j<i;j++)
        {
            y.options[j]=new Option(x.options[j].text,x.options[j].value);
        }
        for(j=0;j<i;j++)
        {
            x.remove(0);
        }
    }
}

function invite_mem_remove() 
{
    var x=document.getElementById("invitefriends");
    var y=document.getElementById("myfriends");
    var i;
    i = x.selectedIndex;
    if(i>=0)
    {
        y.options[y.options.length]=new Option(x.options[i].text,x.options[i].value);
        x.remove(x.selectedIndex);
    }
}

function invite_mem_send() 
{
    var i,out;
    var x=document.getElementById("invitefriends");
    out = '';
    for(i=0; i<x.options.length; i++)
    {
        out = out + "<input type=hidden name=flist[] value="+x.options[i].text+" >";
    }

    document.getElementById('friends_div').innerHTML=out;
    document.getElementById('invite-members-forum').submit();
}

function approve_post(id,idHlinkAprove) 
{
    alert("This posting will be approved. Refresh the page.");
    var y="apostform"+id;
    var x = document.getElementById(y);
    return x.submit();
}

function unapprove_post(id,idHlinkAprove) 
{
	var t= confirm('Are you sure you want to delete this topics?');
	if (t==true)
	{
		var y = "unapostform" + id;
		var x = document.getElementById(y);
		return x.submit();
	}
}

/* User menu drop-down */

$("#user-drop-down .arrow").click(function(){
	$("#user-menues").toggle().css({'width':$("#user-drop-down").width() - 8 + 'px' });
	$("#user-drop-down").toggleClass('highlights');
	$(".arrow").toggleClass('highlights');
});
