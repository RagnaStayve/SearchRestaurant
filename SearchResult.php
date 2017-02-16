<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>検索結果画面</title>
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

	<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>

	<style>
	</style>

	<?php
		//エンドポイントのURIとフォーマットパラメータを変数に入れる
		$uri = "https://api.gnavi.co.jp/RestSearchAPI/20150630/";
		//APIアクセスキーを変数に入れる
		$acckey= "66ad3d3a76e51a78f6c004b93cac0a4e";
		//返却値のフォーマットを変数に入れる
		$format= "json";
		//データの受取
		$lat = 35.670083;
		$lon = 139.763267;
		// $lat = floatval($_GET['lat']);
		// $lon = floatval($_GET['lon']);
		$range = intval($_GET['range']);
		$page = intval($_GET['page']);

		//URL組み立て
		$url = sprintf("%s%s%s%s%s%s%s%s%s%s%s%s%s", $uri, "?format=", $format, "&keyid=", $acckey, "&latitude=", $lat,"&longitude=",$lon,"&range=",$range,"&offset_page=",$page);
		//API実行
		$json = file_get_contents($url);
		//取得した結果をオブジェクト化
		$obj = json_decode($json);

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
<div class="col-sm-10 col-sm-offset-1">
<div class="container-fluid">
	<?php foreach((array)$obj as $key => $val): ?>
		<?php
			if(strcmp($key, "total_hit_count") == 0){
				$total = $val;
				// echo "total:".$total."<br>";
				if($total == 1){
					echo 'ヒットなし';
					break;
				}
			}
			if(strcmp($key, "hit_per_page" ) == 0 ){
				$hit = $val;
			}
		?>

		<?php if(strcmp($key, "rest") == 0): ?>
			<p>画像提供：ぐるなび</p>
			<table class="container-fluid table table-bordered links">
				<tbody>
					<?php foreach((array)$val as $restArray): ?>
						<?php
							$detailurl= 'RestaurantDetails.php?id='.$restArray->{'id'};
							$img_url = $restArray->{'image_url'}->{'shop_image1'};
						?>
						<tr>
							<td class="center">
								<a href="<?= $detailurl; ?>" target="_blank">
									<?php if(checkString($img_url)): ?>
										<img src="<?= $img_url; ?>" class="image img-rounded"/>
									<?php else: ?>
										<img src="Flat-UI-private/img/non_image.png" class="image img-rounded"/>
									<?php endif; ?>
								</a>
							</td>
							<td class="col-sm-5">
								<a href="<?= $detailurl; ?>" target="_blank">
									<?php
										if(checkString($restArray->{'name'})){
											echo $restArray->{'name'}."\t";
										}
									?>
								</a>
							</td>
							<td>
								<?php
									if(checkString($restArray->{'access'}->{'line'})){
										echo (string)$restArray->{'access'}->{'line'}."\t";
									}
									if(checkString($restArray->{'access'}->{'station'})){
										echo (string)$restArray->{'access'}->{'station'}."\t";
									}
									if(checkString($restArray->{'access'}->{'walk'})){
										echo (string)$restArray->{'access'}->{'walk'}."分\t";
									}
								?>
							</td>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		<?php endif; ?>
	<?php endforeach;?>

	<!-- 必要変数設定 -->
	<?php
		$prev = $page - 1;
		$next = $page + 1;
		$last = intval($total / $hit) + intval($total % $hit);

		$pagiurl='SearchResult.php?lat='.$lat.'&lon='.$lon.'&range='.$range.'&page=';
	?>

	<div class="center">
		<p><?= $last; ?>ページ中<?= $page;?>ページ目</p>
		<ul class="pagination">
			<?php if($total > 10): ?>
				<!-- 最初,次へ ボタン設置 -->
				<?php if($page > 1):?>
					<li class="previous">
						<a href="<?= $pagiurl;?>1" type="submit" class="fui-arrow-left">最初</a>
					</li>
					<li>
						<a href="<?php echo $pagiurl.$prev;?>" type="submit" class="fui-arrow-left"></a>
					</li>
				<?php endif; ?>
				<!-- 最初,次へ ボタン設置終了 -->

				<!-- 途中ページ　ボタン設置 -->
				<?php for($i = $page - 2, $cnt = 0;$cnt != 5 && $i <= $last; $i++, $cnt++): ?>
					<?php if($cnt == 0 && $i > $last - 4){ $i = $last - 4;} ?>
					<?php if($i < 1){ $i = 1;} ?>

					<?php if($i == $page): ?>
						<li class="active">
							<a href=""><?= $i; ?></a>
						</li>
					<?php else: ?>
						<li>
							<a href="<?php echo $pagiurl.$i;?>"><?= $i; ?></a>
						</li>
					<?php endif; ?>
				<?php endfor; ?>
				<!-- 途中ページ　ボタン設置終了 -->

				<!-- 次へ,最後　ボタン設置 -->
				<?php if($page < $total / $hit): ?>
					<li>
						<a href="<?php echo $pagiurl.$next;?>" class="fui-arrow-right"></a>
					</li>
					<li class="next">
						<a href="<?php echo $pagiurl.$last;?>" class="fui-arrow-right">最後</a>
					</li>
				<?php endif; ?>
				<!-- 次へ,最後　ボタン設置終了 -->
			<?php endif; ?>
		</ul>
	</div>
	<br>
</div>

<div class="center">
	Powered by <a href="https://www.gnavi.co.jp/">ぐるなび</a>
</div>
</div>
</body>
</html>
