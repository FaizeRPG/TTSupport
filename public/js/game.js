var TURN = 0;
var TURN_TIME = 5*60; //5*60
var TEAM_PLAYING = 0; //Team B/1 suit
var START_TEAM = 0; //Team A/0 commence
var NB_TURN = 32; //32

var WARN_PRCT = 50;
var DANG_PRCT = 1000 / TURN_TIME;

var TURN_A = 1;
var TURN_B = 0;

var TURN_A_T = document.getElementById("turnA");
var TURN_B_T = document.getElementById("turnB");

var BTN_PAUSE = document.getElementById("pause");
var BTN_RMTRN = document.getElementById("loseTurn");
var BTN_ADDTRN = document.getElementById("gainTurn");
var BTN_PONE = document.getElementById("timerA");
var BTN_PTWO = document.getElementById("timerB");

var SD_HORN = document.getElementsByTagName("audio")[0];
var SD_BOOP = document.getElementsByTagName("audio")[1];
var SD_BEEP = document.getElementsByTagName("audio")[2];

var TRAD_PLAY = document.getElementById("play").innerHTML;
var TRAD_BREAK = document.getElementById("break").innerHTML;

var TIME_T = TURN_TIME;

var LOOP = null;
var RUNNER = false;
var MID_TIME = false;

window.addEventListener('load', function() {
    BTN_PONE.addEventListener("click", turnover);
    BTN_PTWO.addEventListener("click", turnover);
    BTN_PAUSE.addEventListener("click", run);
    BTN_RMTRN.addEventListener("click", loseTurn);
    BTN_ADDTRN.addEventListener("click", gainTurn);
});

function loseTurn() {
    if (TURN_A > 0 && TURN_B > 0) {
	TURN_A -= 1;
	TURN_B -= 1;
	TURN -= 2;
    
	TURN_A_T.innerHTML = TURN_A;
	TURN_B_T.innerHTML = TURN_B;
    }
}

function gainTurn() {
    if (TURN_A < 8 && TURN_B < 8) {
	TURN_A += 1;
	TURN_B += 1;
	TURN += 2;
    
	TURN_A_T.innerHTML = TURN_A;
	TURN_B_T.innerHTML = TURN_B;
    }
}

function run() {
    if (TURN == 0) {
        TURN_A_T.innerHTML = TURN_A;
	BTN_PONE.classList.remove("bg-secondary");
	BTN_PONE.classList.remove("text-dark");
	BTN_PONE.className += " bg-light";
	BTN_PONE.disabled = false;
    }

    if (TURN == 16) {
	BTN_PTWO.classList.remove("bg-secondary");
	BTN_PTWO.classList.remove("text-dark");
	BTN_PTWO.className += " bg-light";
    }
    
    playBreak();
    
    if (RUNNER) {
	RUNNER = false;
	clearInterval(LOOP);
    } else {    
        LOOP = setInterval(refreshClock, 100);
	RUNNER = true;
    }
}

function refreshClock() {
    if (midTime() || endTime()) {
	return;
    }
    
    TIME_T -= 0.1;
    v = (TIME_T/TURN_TIME)*100;

    if (TEAM_PLAYING) {
	BTN_PTWO.innerHTML = convertTime(TIME_T);
	changeProgressColor(BTN_PTWO, v);
    } else {
	BTN_PONE.innerHTML = convertTime(TIME_T);
	changeProgressColor(BTN_PONE, v);
    }
    
    if (TIME_T <= 0) {
	turnover();
    }
}

function endTime() {
    if (TURN == NB_TURN) {
	BTN_PAUSE.disabled = true;
	
	clearInterval(LOOP);
	alert("The END");

	return true;
    }

    return false;
}

function midTime() {
    if (!MID_TIME && TURN == (NB_TURN/2)) {
	clearInterval(LOOP);
	playBreak();
	
	RUNNER = false;
	MID_TIME = true;

	TEAM_PLAYING = START_TEAM ? 0 : 1;

	BTN_PONE.disabled = true;
	BTN_PTWO.disabled = true;

	BTN_PONE.classList.remove("text-success");
	BTN_PONE.classList.remove("bg-light");
	BTN_PONE.className += " bg-secondary text-dark";

	TURN_B_T.innerHTML = TURN_B = 1;
	TURN_A_T.innerHTML = TURN_A = 0;
    }
}

function turnover(horn = true) {
    if (horn)
	SD_HORN.play();

    if (endTime()) {
	return ;
    }

    TURN++;
    initTimers();

    if (TEAM_PLAYING == 0) {
	TURN_B++;
    	TURN_B_T.innerHTML = TURN_B;
	TEAM_PLAYING = 1;
	changeTeamColor(TEAM_PLAYING);
   } else {
	TURN_A++;
    	TURN_A_T.innerHTML = TURN_A;
	TEAM_PLAYING = 0;
        changeTeamColor(TEAM_PLAYING);
   }
    
    midTime();
}

function initTimers() {
    TIME_T = TURN_TIME;
    
    BTN_PONE.innerHTML = convertTime(TIME_T);
    BTN_PTWO.innerHTML = convertTime(TIME_T);
}

function changeTeamColor(turn) {
    if (turn) {
	BTN_PONE.classList.remove("text-success");
	BTN_PONE.classList.remove("text-warning");
	BTN_PONE.classList.remove("text-danger");

	BTN_PONE.classList.remove("bg-light");
	BTN_PONE.className += " bg-secondary text-dark";
	BTN_PONE.disabled = true;

	BTN_PTWO.classList.remove("bg-secondary");
	BTN_PTWO.classList.remove("text-dark");
	BTN_PTWO.className += " bg-light text-success";
	BTN_PTWO.disabled = false;
    } else {
	BTN_PONE.classList.remove("bg-secondary");
	BTN_PONE.classList.remove("text-dark");
	BTN_PONE.className += " bg-light text-success";
	BTN_PONE.disabled = false;

	BTN_PTWO.classList.remove("text-success");
	BTN_PTWO.classList.remove("text-warning");
	BTN_PTWO.classList.remove("text-danger");

	BTN_PTWO.classList.remove("bg-light");
	BTN_PTWO.className += " bg-secondary text-dark";
	BTN_PTWO.disabled = true;
    }
}

function convertTime(ms) {
    var m = Math.floor(ms / 60);
    ms -= m*60;

    return m + ":" + ms.toFixed(1);
}

function changeProgressColor(elem, prc) {
    if (prc > WARN_PRCT) {
	elem.classList.remove("text-dark");
	if (!elem.classList.contains("text-success"))
	    elem.className += " text-success";
    }

    if (prc <= WARN_PRCT) {
	elem.classList.remove("text-success");
	if (!elem.classList.contains("text-warning")) {
	    elem.className += " text-warning";
	    SD_BOOP.play();
	}
    }

    if (prc <= DANG_PRCT) {
	SD_BOOP.play();

	elem.classList.remove("text-warning");
	if (!elem.classList.contains("text-danger"))
	    elem.className += " text-danger";
    }
}

function playBreak() {
    if (BTN_PAUSE.value == TRAD_BREAK) {
	BTN_PAUSE.value = TRAD_PLAY;
	BTN_ADDTRN.disabled = false;
	BTN_RMTRN.disabled = false;
	
	BTN_PONE.disabled = true;
	BTN_PTWO.disabled = true;
    } else {
        BTN_PAUSE.value = TRAD_BREAK;
	BTN_ADDTRN.disabled = true;
	BTN_RMTRN.disabled = true;

	if (TEAM_PLAYING) {
	    BTN_PTWO.disabled = false;
	} else {
	    BTN_PONE.disabled = false;
	}
    }
}
