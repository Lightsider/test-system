window.onload = function () {
    var dt = new Date();
    var date = dt.getFullYear() + "-" + String(dt.getMonth() + 1).padStart(2, '0') + "-" + String(dt.getDate()).padStart(2, '0');
    var deadline =  document.querySelector('#endtime').value;
    initializeClock('timeLeft', deadline);
};

$("li[role=presentation]").click(function () {
    $("li[role=presentation]").removeClass("active");
    $(this).addClass("active");
});


function initializeClock(id, endtime){
    var clock = document.getElementById(id);
    function updateClock(){
        var t = getTimeRemaining(endtime);
        clock.innerHTML =
            t.hours + ':' + t.minutes + ':' + t.seconds;
        if(t.total<=0){
            clearInterval(timeinterval);
        }
    }
    updateClock();
    var timeinterval = setInterval(updateClock,1000);
}



function getTimeRemaining(endtime){
    var t = Date.parse(endtime) - Date.parse(new Date());
    var seconds = Math.floor( (t/1000) % 60 ).toString().padStart(2,0);
    var minutes = Math.floor( (t/1000/60) % 60 ).toString().padStart(2,0);
    var hours = Math.floor( (t/(1000*60*60)) % 24 ).toString().padStart(2,0);
    var days = Math.floor( t/(1000*60*60*24) );
    return {
        'total': t,
        'days': days,
        'hours': hours,
        'minutes': minutes,
        'seconds': seconds
    };
}