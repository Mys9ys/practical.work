x=window.top.loc.your_army.allinfo;
var teams = x[2]
console.log(teams)

function timeoutLoop(fn, delay) {
    setTimeout(function() {
        fn();
        timeoutLoop(fn, timedelay());
    }, delay);
}

function Rand(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min; //1 10
}

function unitReload(){
    x=window.top.loc.your_army.allinfo
    return x[2]
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
        var teams =  unitReload()
        var chosen_team = teams[Math.floor((Math.random()*teams.length))];
        window.top.loc.combat_ins.location.href = "cgi/combat_ins.php?id="+ chosen_team[0]
            +"&show=0";
    } catch(ex){}
},timedelay());

parent.getElementById('scrollsDiv');
getElementById('elem');

console.log(window.top.loc)

window.top.loc.combat_scroll_ins.location.href = "combat_scroll_ins.php?id="+35+"&show=0";// нажатие на кальтоп
parent.combat_scroll_ins.location.href = "combat_scroll_ins.php?id="+35+"&show=0";// нажатие на кальтоп
n.prepend('<div style="height: 25px; background-color: aqua"></div>')
'<div style="height: 25px; background-color: aqua"></div>'

parent.combat_scroll_ins.location.href = "combat_scroll_ins.php?id=35&show=1";

x=window.top.loc.your_army.allinfo
console.log(x)

window.top.loc.combat_ins.location.href = "cgi/combat_ins.php?id=1101&show=0";

// <![CDATA

// ]]>
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

window.top.loc.combat_ins.location.href = "cgi/combat_ins.php?id="+ arrUnit[0]['id']
    +"&show=0";
    [
    31091, //  Властительница Огня
        9,
        3
    ],
    [
        31101, // Очаровательная Госпожа
        10,
        3
    ],
    [
        31191, //Властительница Адского Огня
        3,
        3
    ],
    [
        31192, // Властительница Инферно
        3,
        3
    ]

    [
    [
        2620, // Горец
        15,
        2
    ],
        [
            11101, //Старый Дракон-Вершитель
            10,
            1
        ],
        [
            11112, //Дракон Адского Пламени
            7,
            1
        ],
        [
            11197, //Ночной Старый Дракон-Вершитель
            9,
            1
        ],
        [
            11206, // Диего
            1,
            1
        ],
        [
            21101, // Лорд-Вершитель
            12,
            2
        ],
        [
            21111, // Повелитель Инферно
            8,
            2
        ],
        [
            21209, // Светослав
            1,
            2
        ],
        [
            31091, //  Властительница Огня
            9,
            3
        ],
        [
            31101, // Очаровательная Госпожа
            10,
            3
        ],
        [
            31191, //Властительница Адского Огня
            3,
            3
        ],
        [
            31192, // Властительница Инферно
            3,
            3
        ]
    ]



x=window.top.loc.enemy_army.allinfo
console.log(x)

x=window.top.loc
console.log(x)