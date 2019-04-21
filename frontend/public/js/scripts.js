function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        --timer;
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (timer < 0) {
            timer = duration;
        }
    }, 1000);
}

window.onload = function () {
    var display = document.querySelector('#timeLeft');
    if(display !== null)
    {
        var timeArray = display.innerHTML.split(":");
        var time = +(+timeArray[0]*60) + +timeArray[1];
        startTimer(time, display);
    }
};
