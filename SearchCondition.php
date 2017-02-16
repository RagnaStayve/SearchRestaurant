<?php $_SESSION = array(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>検索条件入力画面</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Loading Bootstrap -->
	<link href="Flat-UI-private/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Loading Flat UI -->
	<link href="Flat-UI-private/css/flat-ui.css" rel="stylesheet">
	<link href="myCSS.css" rel="stylesheet">

	<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	<!-- Flat-UI-master -->
	<script src="Flat-UI-private/js/comma3.js"></script>
	<script src="Flat-UI-private/js/vendor/video.js"></script>
	<script src="Flat-UI-private/js/flat-ui.min.js"></script>
	<script src="Flat-UI-private/js/application.js"></script>
	<script>
		videojs.options.flash.swf = "Flat-UI-private/js/vendors/video-js.swf"
	</script>

	<script src="getLocation.js"></script>

	<style>
	</style>

</head>
<body>
<div class="container-fluid">
	<div class="col-sm-8 col-sm-offset-2">
		<table class="table table-bordered center">
				<tr>
					<td colspan="2">
						<button class="btn btn-default full" id="setLocation" onclick="location.reload();">現在位置入力</button>
					</td>
				</tr>
				<form class="" action="SearchResult.php" method="get" name="condition">
				<tr>
					<td>緯度</td>
					<td><input type="text" name="lat" id="lat" readonly="ready" class="form-control"></td>
				</tr>
				<tr>
					<td>経度</td>
					<td><input type="text" name="lon" id="lon" readonly="ready" class="form-control"></td>
				</tr>
				<tr>
					<td>検索半径</td>
					<td>
						<select name="range" class="center full">
							<?php for ($i = 1; $i <= 5; $i++): ?>
								<option value="<?= $i; ?>"><?= $i * 300; ?>m</option>
							<?php endfor; ?>
						</select>
					</td>
				</tr>
				<tr>
					<input type="hidden" value="1" name="page">
					<td colspan="2">
						<button class="btn btn-info" type="sbmit" onclick="return valueCheck();" style="width: 100%;">検索</button>
					</td>
				</tr>

			</form>
		</table>
	</div>
</div>
</body>
</html>
