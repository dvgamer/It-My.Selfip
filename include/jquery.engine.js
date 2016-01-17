// JavaScript Document HaKkoMEw
var oldState;
var myState;
var myQuery;

$(function(){
	var urlString = document.location.toString();
	var urlSplit = urlString.split('/');
	if(urlSplit[3]=='' || (urlSplit[3]!='store' && urlSplit[3]!='info')) urlSplit[3] = 'home';
	myState = urlSplit[3];
	urlState('.nav_'+myState, 1, '')
});

function urlState(me, lv, change)
{
	$(oldState).removeClass('selected_' + $(oldState).attr('level'));
	$(me).addClass('selected_' + $(me).attr('level'));
	if(oldState!=me) history.pushState({level:lv}, 'HaKko', change);
	oldState = me;
	
	var urlString = document.location.toString();
	var urlSplit = urlString.split('/');
	if(urlSplit[3]=='' || (urlSplit[3]!='store' && urlSplit[3]!='info')) urlSplit[3] = 'home';
	myState = urlSplit[3];
	myQuery = urlSplit[urlSplit.length-1];
	
	$.ajax({ url:'index.php?ajax=module',
		data: ({ name: myState, query: myQuery }),
		dataType: 'html',
		error: function(){ },
		success: function(data){			
			$('#main_body').html(data);
		},
	});
}
