<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>検索結果詳細画面</title>
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

	<style>
	</style>
	<?php
		//エンドポイントのURIとフォーマットパラメータを変数に入れる
		$uri = "https://api.gnavi.co.jp/RestSearchAPI/20150630/";
		//APIアクセスキーを変数に入れる
		$acckey= "66ad3d3a76e51a78f6c004b93cac0a4e";
		//返却値のフォーマットを変数に入れる
		$format= "json";
		$id = $_GET['id'];

		//URL組み立て
		$url  = sprintf("%s?format=%s&keyid=%s&id=%s", $uri, $format, $acckey, $id);
		//API実行
		$json = file_get_contents($url);
		//取得した結果をオブジェクト化
		$obj  = json_decode($json);

		$details = $obj->rest;

		if(checkString($details->{'name'})){
			$name = $details->{'name'};
		}
		if(checkString($details->{'address'})){
			$address = $details->{'address'};
		}
		if(checkString($details->{'tel'})){
			$tel = $details->{'tel'};
		}
		if(checkString($details->{'opentime'})){
			$opentime = $details->{'opentime'};
		}
		if(checkString($details->{'image_url'}->{'shop_image1'})){
			$image1 = $details->{'image_url'}->{'shop_image1'};
		} else {
			$image1 = 'Flat-UI-private/img/non_image.png';
		}
		if(checkString($details->{'image_url'}->{'shop_image2'})){
			$image2 = $details->{'image_url'}->{'shop_image2'};
		}
		if(checkString($details->{'image_url'}->{'qrcode'})){
			$image3 = $details->{'image_url'}->{'qrcode'};
		}
		if(checkString($details->{'holiday'})){
			$holiday = $details->{'holiday'};
		}

		//文字列であるかをチェック
		function checkString($input)
		{
			if(isset($input) && is_string($input)) {
				return true;
			}else{
				return false;
			}
		}

	?>
</head>
<body>
<div class="container-fluid">
<div class="col-sm-10 col-sm-offset-1">
	<table class="container-fluid table table-bordered" id="detail">
		<tbody>
			<tr>
				<td rowspan=""><h5><?= $name;?></h5></td>
			</tr>
			<tr>
				<td colspan=""><img src="<?= $image1;?>"></td>
				<td><?= $address;?></td>
				<td><?= $tel;?></td>
				<td><?= $opentime;?></td>
				<td><?= $holiday;?></td>
			</tr>

		</tbody>
	</table>
</div>
</div>


<div class="center">
	Powered by <a href="https://www.gnavi.co.jp/">ぐるなび</a>
</div>
</body>
</html>
