x=window.top.loc.your_army.allinfo;
var teams = x[2]

function timeoutLoop(fn, delay) {
setTimeout(function() {
fn();
timeoutLoop(fn, timedelay());
}, delay);
}

function Rand(min, max) {
return Math.floor(Math.random() * (max - min + 1)) + min; //1 10
}

function timedelay() {
if(Rand(1,100)>5) {
return Rand(5000,20000);
} else {
return Rand(30000,200000);
}
}

timeoutLoop(function() {
try{
var chosen_team = teams[Math.floor((Math.random()*teams.length))];
window.top.loc.combat_ins.location.href = "cgi/combat_ins.php?id="+ chosen_team[0]
+"&show=0";
} catch(ex){}
},timedelay());