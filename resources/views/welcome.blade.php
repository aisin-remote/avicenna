<html>
	<head>
		<title>Laravel</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	  	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				display: table;
				font-weight: 100;
				font-family: 'Lato';
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: text-top;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 120px;
				font-style: bold;
				margin-top: 40px;
				color: #ffffff ;
			}

			.quote {
				font-size: 20px;
				color: #ffffff ;
			}
			.rectangle {
			 	height: 300px;
			 	width: 450px;
			 	/*background-color: rgba(255,255,255,0.2);*/
			 	border-style: groove;
			 	border-color: #ffffff;
			}
			.plant {
				font-size: 80px;
				color: #ffffff;
				margin-top: 90px;
			}
			.mon {
				font-size: 80px;
				color: #ffffff;
				margin-top: 90px;
			}
		</style>
	</head>
	<body background="images/2.jpg">
		<div class="container" >
			<div class="content">
				<div class="title">AVICENNA</div>
				<div class="quote">Please Choose Dashboard First</div>
				<div class="panel-body">
					<div class="col-md-12" >
						<div class="row">
							<div class="col-md-4">
								<a href="trace/view/listout" style="text-decoration:none">
								<div class="rectangle" >
									<div class="plant">
										Traceability
									</div>
								</div>
								</a>
							</div>
							<div class="col-md-4">
								<a href="direct/andon2" style="text-decoration:none">
								<div class="rectangle">
									<div class="plant">
										Andon
										<div class="quote">Monitoring</div>

									</div>
								</div>
								</a>
							</div>
							<div class="col-md-4">
								<a href="avicenna/stock/mutation" style="text-decoration:none">
								<div class="rectangle">
									<div class="plant">
										Stock
										<div class="quote">Monitoring</div>

									</div>
								</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="col-md-12" >
						<div class="row">
							<div class="col-md-4">
								<a href="direct/line" style="text-decoration:none">
								<div class="rectangle">
									<div class="plant">
										All Line
										<div class="quote">Monitoring</div>

									</div>
								</div>
								</a>
							</div>
							<div class="col-md-4">
								<a href="http://10.80.254.72:8009/Pages/GiGs001/GiGs001Page.aspx" style="text-decoration:none">
								<div class="rectangle">
									<div class="plant">
										Alcolla
										<div class="quote">IOT Monitoring</div>

									</div>
								</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br><br><br><br><br>
				<div class="quote"> <a href="login" style="text-decoration:none">Login</a></div>
			</div>
		</div>
	</body>
</html>