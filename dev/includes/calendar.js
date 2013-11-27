$("#calendar").calendar({
startMode: 'month',
multiSelect: true
//click: function(){outputrefresh();}
});

var cal = $("#calendar").calendar();
		cal.calendar('setDate', '2013-11-21');
		cal.calendar('setDate', '2013-11-2');
