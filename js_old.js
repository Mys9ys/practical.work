teams = [
    {id: 11101, count: 10},//Старый Дракон-Вершитель
    {id: 11112, count: 7}, //Дракон Адского Пламени
    {id: 11197, count: 9}, //Ночной Старый Дракон-Вершитель
    {id: 11206, count: 1}, //Диего

    {id: 21101, count: 12}, //Лорд-Вершитель
    {id: 21111, count: 8}, //Повелитель Инферно
    {id: 21209, count: 1}, //Светослав
    {id: 2620, count: 15}, //Горец

    {id: 31091, count: 9}, //Властительница Огня
    {id: 31101, count: 10}, //Очаровательная Госпожа
    {id: 31191, count: 3}, //Властительница Адского Огня
    {id: 31192, count: 3}, //Властительница Инферно
]

function timeoutLoop(fn, delay) {
    setTimeout(function() {
        fn();
        timeoutLoop(fn, timedelay());
    }, delay);
}

function Rand(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min; //1 10
}

function chooseTeams(){
    let rand = Math.floor((Math.random()*teams.length))

    let unit = teams[rand]

    console.log('id',unit)

    unit['count'] -= 1
    if(unit['count'] === 0)
        teams.splice(rand,1)

    console.log('test',unit['count'])

    return unit['id']
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
        var chosen_team = chooseTeams();
        window.top.loc.combat_ins.location.href = "cgi/combat_ins.php?id="+ chosen_team
            +"&show=0";
    } catch(ex){}
},timedelay());