x=window.top.loc.your_army.allinfo;
var teams = x[2]

function timeoutLoop(fn, delay) {
    setTimeout(function() {
        fn();
        timeoutLoop(fn, Rand(10500,16000));
    }, delay);
}
function timeoutLoop2(fn, delay) {
    setTimeout(function() {
        fn();
        timeoutLoop2(fn, Rand(3000,4500));
    }, delay);
}
function Rand(min, max)
{
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
timeoutLoop2(function() {try{
    var chosen_team = teams[Math.floor((Math.random()*teams.length))];
    window.top.loc.combat_scroll_ins.location.href = "cgi/combat_scroll_ins.php?id="+ Rand(30,37)
        +"&show=0";
} catch(ex){}
},Rand(3000,4500));

timeoutLoop(function() {try{
    var chosen_team = teams[Math.floor((Math.random()*teams.length))];
    window.top.loc.combat_ins.location.href = "cgi/combat_ins.php?id="+ chosen_team[0]
        +"&show=0";
} catch(ex){}
},Rand(10500,16000));