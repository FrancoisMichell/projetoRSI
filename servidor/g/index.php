<!DOCTYPE html>
<html>
<head>
	<title>RSI - 2016.2</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>

	<div id="sidebar">
		<div id="center">
			<p id="title">Redes e Sistemas de Internet</p>
			<p>2016.2</p>

			<p id="pname">Monitoramento Comportamental de Usuários Utilizando Raspberry Pi</p>

			<ul id="students">
				<li style="font-weight: bold; border-bottom: 1px solid black;">Alunos</li>
				<li>François Michell</li>
				<li>Guilherme Araújo</li>
				<li>Matheus Uehara</li>				
				<li style="font-weight: bold; border-bottom: 1px solid black;"><br/>Orientador</li>
				<li>Glauco Gonçalves</li>
			</ul>
		</div>
	</div>
	<div id="content">
		<button id="pct">Valor Percentual</button>
		<button id="qt" class="selected">Valor Quantitativo</button>
		<br/><br/><br/>
		<div class="wrapchart">
			<h2>Quantidade de registros por Perfil</h2>
			<canvas id="profiles"></canvas>
		</div>
		<div class="wrapchart">
			<h2>Quantidade de registros por Fabricante de Placa</h2>
			<canvas id="manufacturer"></canvas>
		</div>
		<br/>
		<div class="wrapchart">
			<h2>Quantidade média de registros diários</h2>
			<canvas id="daily_freq"></canvas>
		</div>
		<div class="wrapchart">
			<h2>Quantidade de registros por turno</h2>
			<canvas id="shift_freq"></canvas>
		</div>
		<div class="wrapchart">
			<h2>Quantidade de registros por SO</h2>
			<canvas id="sos"></canvas>
		</div>
	</div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script type="text/javascript" src="main.js"></script>
</html>