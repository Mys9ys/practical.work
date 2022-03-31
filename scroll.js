scrollArr = [];
for(i = 0; i<8; i++){
    scrollArr.push(30+i)
}

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
        var scroll_item = scrollArr[Math.floor((Math.random()*scrollArr.length))];
        parent.combat_scroll_ins.location.href = "combat_scroll_ins.php?id="+scroll_item+"&show=0";
    } catch(ex){}
},timedelay());