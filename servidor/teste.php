<!DOCTYPE html>
<html>
	<head>
		<title>TESTE</title>
		<meta charset="utf-8">
	</head>
	<body>

		<button onclick="test();">Testar</button>
		<br/>
		<div id="retorno"></div>

	</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript">
		function test() {
			//var time_stamp = new Date().toMysqlFormat();
			var d = {
				mac:"ghi2345",
				timestamp: new Date().toMysqlFormat(),
				forcaSinal : "100"
			};

			console.log(d);

			$.ajax({
				url: "index.php",
				type: "POST",
				data: d,
				dataType: "json",
				//dataType: "jsonp",
				success: function (ret) {					
					if (ret.sts) {
						$("#retorno").html("<p>Insertion WORKED!</p>");
					}
					else {
						$("#retorno").html("<p>Insertion FAILED:</p>");
						$("#retorno").append("<p>"+ret.msg+"</p>");
					}
					console.log(ret);

				},
				error: function (e) {
					console.log("Insertion FAILED!");
					console.log(e);
				}				
			});
		}

		function twoDigits(d) {
			if(0 <= d && d < 10) return "0" + d.toString();
			if(-10 < d && d < 0) return "-0" + (-1*d).toString();
			return d.toString();
		}

		Date.prototype.toMysqlFormat = function() {
			return this.getUTCFullYear() + "-" + twoDigits(1 + this.getUTCMonth()) + "-" + twoDigits(this.getUTCDate()) + " " + twoDigits(this.getUTCHours()) + ":" + twoDigits(this.getUTCMinutes()) + ":" + twoDigits(this.getUTCSeconds());
		};
	</script>
</html>
