$(function(){
	$("#sidebar #center").css({
		"margin-top":"-"+($("#sidebar #center").height()/2)+"px"
	});



	$.ajax({
		url:"../getdata.php",
		type:"get",
		data:"pass=passcode",
		dataType:"json",
		success: function (result) {
			console.log(result);
			set_profiles_chart(result.profiles.profiles,result.profiles.qts);
			set_manufacturer_chart(result.manufactures.names,result.manufactures.qts);
			set_daily_freq_chart(result.daily_freq.qts);
			set_shift_freq_chart(result.shift_freq.stamps,result.shift_freq.qts);
			set_sos_chart(result.sos.names,result.sos.qts);

			$("button").on("click",function () {
				$("button").toggleClass("selected",false);
				$(this).toggleClass("selected",true);
				if ($(this).attr("id") == "pct") {
					set_profiles_chart(result.profiles.profiles,result.profiles.pcts);
					set_manufacturer_chart(result.manufactures.names,result.manufactures.pcts);
					set_daily_freq_chart(result.daily_freq.pcts);
					set_shift_freq_chart(result.shift_freq.stamps,result.shift_freq.pcts);
					set_sos_chart(result.sos.names,result.sos.pcts);
				}
				else {
					set_profiles_chart(result.profiles.profiles,result.profiles.qts);
					set_manufacturer_chart(result.manufactures.names,result.manufactures.qts);
					set_daily_freq_chart(result.daily_freq.qts);
					set_shift_freq_chart(result.shift_freq.stamps,result.shift_freq.qts);
					set_sos_chart(result.sos.names,result.sos.qts);
				}
			});

			
		},
		error: function (e) {
			alert("Error!");
			console.log(e);
		}
	});

});


function set_profiles_chart(tags,values) {
	var ctx = $("#profiles");
	var colors = [];
	var bordercolors = [];

	for (var i = 0; i < tags.length; i++) {
		var c1 = Math.floor(Math.random() * 255);
		var c2 = Math.floor(Math.random() * 255);
		var c3 = Math.floor(Math.random() * 255);

		colors.push('rgba('+c1+','+c2+','+c3+',0.2)');
		bordercolors.push('rgba('+c1+','+c2+','+c3+',1)');
	}

	var myChart = new Chart(ctx, {
		type: 'pie',
		data: {
			labels: tags,
			datasets: [{
				data: values,
				backgroundColor: colors,
				borderColor: bordercolors,
				borderWidth: 1
			}]
		}
	});
}

function set_manufacturer_chart(tags,values) {
	var ctx = $("#manufacturer");	
	var colors = [];
	var bordercolors = [];

	new_tags = [];

	for (var i = 0; i < tags.length; i++) {
		var c1 = Math.floor(Math.random() * 255);
		var c2 = Math.floor(Math.random() * 255);
		var c3 = Math.floor(Math.random() * 255);

		colors.push('rgba('+c1+','+c2+','+c3+',0.2)');
		bordercolors.push('rgba('+c1+','+c2+','+c3+',1)');

		if (!(tags[i] in new_tags)) { new_tags[tags[i]] = parseInt(values[i]); }
		else { new_tags[tags[i]] += parseInt(values[i]); }
	}

	var keys = get_keys(new_tags);
	var vals = get_values(new_tags);
	
	var myChart = new Chart(ctx, {
		type: 'pie',
		data: {
			labels: keys,
			datasets: [{				
				data: vals,
				backgroundColor: colors,
				borderColor: bordercolors,
				borderWidth: 1
			}]
		}
	});
}


function set_sos_chart(tags,values) {
	var ctx = $("#sos");
	var colors = [];
	var bordercolors = [];

	for (var i = 0; i < tags.length; i++) {
		var c1 = Math.floor(Math.random() * 255);
		var c2 = Math.floor(Math.random() * 255);
		var c3 = Math.floor(Math.random() * 255);

		colors.push('rgba('+c1+','+c2+','+c3+',0.2)');
		bordercolors.push('rgba('+c1+','+c2+','+c3+',1)');
	}

	var myChart = new Chart(ctx, {
		type: 'pie',
		data: {
			labels: tags,
			datasets: [{
				data: values,
				backgroundColor: colors,
				borderColor: bordercolors,
				borderWidth: 1
			}]
		}
	});
}


function get_keys(arr) {
	var keys = [];
	for (var i in arr) {
		keys.push(i);
	}
	return keys;
}

function get_values(arr) {
	var values = [];
	for (var i in arr) {
		values.push(arr[i]);
	}
	return values;
}

function set_daily_freq_chart(values) {
	var ctx = $("#daily_freq");
	var colors = [];
	var bordercolors = [];

	for (var i = 0; i < values.length; i++) {
		var c1 = Math.floor(Math.random() * 255);
		var c2 = Math.floor(Math.random() * 255);
		var c3 = Math.floor(Math.random() * 255);

		colors.push('rgba('+c1+','+c2+','+c3+',0.2)');
		bordercolors.push('rgba('+c1+','+c2+','+c3+',1)');
	}

	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ["22/11","23/11","24/11","25/11","26/11"],
			datasets: [{
				label:"Qt. de aparelhos",
				data: values,
				backgroundColor: colors,
				borderColor:  bordercolors,
				borderWidth: 1
			}]
		}
	});
}

function set_shift_freq_chart(tags,values) {
	var ctx = $("#shift_freq");
	var colors = [];
	var bordercolors = [];

	for (var i = 0; i < tags.length; i++) {
		var c1 = Math.floor(Math.random() * 255);
		var c2 = Math.floor(Math.random() * 255);
		var c3 = Math.floor(Math.random() * 255);

		colors.push('rgba('+c1+','+c2+','+c3+',0.2)');
		bordercolors.push('rgba('+c1+','+c2+','+c3+',1)');
	}

	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: tags,
			datasets: [{				
				label:"Qt. de aparelhos",
				data: values,
				backgroundColor: colors,
				borderColor: bordercolors,
				borderWidth: 1
			}]
		}
	});
}
