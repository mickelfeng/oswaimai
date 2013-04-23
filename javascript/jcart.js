function scall(){
x=371;//x=354;
if(getScrollTop()>x&&document.getElementById("jcart").offsetHeight<document.documentElement.clientHeight)
{
document.getElementById("jcart").style.top=(document.documentElement.scrollTop)+32+"px";//26
}else if(document.getElementById("jcart").offsetHeight>document.documentElement.clientHeight&&getScrollTop()>x) 
{
 document.getElementById("jcart").style.top=(document.documentElement.scrollTop+document.documentElement.clientHeight-document.getElementById("jcart").offsetHeight)+"px";

}else
{
document.getElementById("jcart").style.top=(document.documentElement.scrollTop)+x-getScrollTop()+"px";

}


}

function getScrollTop()
{
    var scrollTop=0;
    if(document.documentElement&&document.documentElement.scrollTop)
    {
        scrollTop=document.documentElement.scrollTop;
    }
    else if(document.body)
    {
        scrollTop=document.body.scrollTop;
    }
    return scrollTop;
}
window.onscroll=scall;
window.onresize=scall;
window.onload=scall;

