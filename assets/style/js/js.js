/**
 * Created by Administrator on 2017/8/28.
 */
function  getsysdate() {
    var day="";
    var month="";
    var ampm="";
    var ampmhour="";
    var myweekday="";
    var year="";
    mydate=new Date();
    myweekday=mydate.getDay();
    mymonth=mydate.getMonth()+1;
    myday= mydate.getDate();
    myyear= mydate.getYear();
    myhour = mydate.getHours();
    myminu = mydate.getMinutes();
    mysec = mydate.getSeconds();
    year=(myyear > 200) ? myyear : 1900 + myyear;
    if(myweekday == 0)
        weekday=" 星期日 ";
    else if(myweekday == 1)
        weekday=" 星期一 ";
    else if(myweekday == 2)
        weekday=" 星期二 ";
    else if(myweekday == 3)
        weekday=" 星期三 ";
    else if(myweekday == 4)
        weekday=" 星期四 ";
    else if(myweekday == 5)
        weekday=" 星期五 ";
    else if(myweekday == 6)
        weekday=" 星期六 ";
    if(mymonth<10)mymonth="0"+mymonth
    if(myday<10)myday="0"+myday
    if(myhour<10)myhour="0"+myhour
    if(myminu<10)myday="0"+myminu
    if(mysec<10)mysec="0"+mysec
    document.write(year+"年"+mymonth+"月"+myday+"日 "+weekday+"<br />");
}
function fontZoom(size)
{
    document.getElementById('con').style.fontSize=size+'px';
}
