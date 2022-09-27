var ptsd = new Audio('/sounds/points_drop.mp3');
var ptsz = new Audio('/sounds/points_to_0.mp3');

const options = {
    startVa: 0,
    useEasin: false,
    useGroupin: false,
    separator: '',
    duration: 3,
};

let playera = new CountUp('lifea', 0000, options);
let playerb = new CountUp('lifeb', 0000, options);

if (!playera.error) {
    playera.start();
}

if (!playerb.error) {
    playerb.start();
}

/** initiate toggle **/
var player = 'A';
var autorefresh = false;
var LOOP = null;

$(function() {
    $('#activeplayer').bootstrapToggle();
    $('#autorefresh').bootstrapToggle();

    $('#activeplayer').change(function() {
		player == 'A' ? player = 'B' : player = 'A';
    });

    $('#autorefresh').change(function() {
		updateRefresh();
    });
});

/** keyboard listener **/

$(document).on('keypress',function(e) {
   var key = e.keyCode;
	
    document.getElementById("lpinteract").focus();
	
    if(e.which == 13) { //enter
	
		if ($('#lifea').text() == 0 || $('#lifeb').text() == 0) {
			/** set default **/
			ptsd.play();
			playera.update(8000);
			playerb.update(8000);
			
			setLP(ref, 'A', 8000);
			setLP(ref, 'B', 8000);
		} else {
			/** calcul lp **/
			var inter = $('#lpinteract').val();
			var life = 0;
			
			if (player == 'A')
				life = $('#lifea').text();
			else
				life = $('#lifeb').text();

			if (inter == '')	    
				inter = '-'+(parseInt(life)/2);
			
			life = parseInt(life) + parseInt(inter);
			
			if (life <= 0) {
				ptsz.play();
				life = 0;
			} else {
				ptsd.play();
			}
				
			if (player == 'A')
				playera.update(life);
			else
				playerb.update(life);
			
			/** envoie ajax **/
			setLP(ref, player, life);

			/** reset champ saisie **/
			$('#lpinteract').val('');
		}
    }
	
    if(e.which == 32) {//space
		e.preventDefault();
		getLP(ref);
	}
});

function setLP(ref, player, val) {
	$.ajax({
		type: "POST",
		url: '/api/yugilp/'+ref+'/'+player+'/'+parseInt(val),
	});
}

function updateLP(lpa, lpb) {
	lifea = $('#lifea').text();
	lifeb = $('#lifeb').text();
	
	if (parseInt(lpa) != parseInt(lifea) || parseInt(lpb) != parseInt(lifeb)) {
	
		if (lpa == 0 || lpb == 0) {
			ptsz.play();
		} else {
			ptsd.play();
		}
		
		if (parseInt(lpa) != parseInt(lifea)) {
			playera.update(lpa);
		}
		
		if (parseInt(lpb) != parseInt(lifeb)) {
			playerb.update(lpb);
		}
	}
}
    
/** futur socket **/
function updateRefresh() {
	if (autorefresh) {
		autorefresh = false;
		clearInterval(LOOP);
	} else {
		autorefresh = true;
		LOOP = setInterval(getLP, 5000);
	}
}

function getLP() {
    $.ajax({
		type: 'POST',
		url: '/api/yugilp/'+ref,
		success: function(data) {
			updateLP(data["1"], data["2"]);
		}
    });
}

/*$(document).ready(function() {
    while(1) {
		setTimeout(getLp(ref), 1000);
    }
});*/