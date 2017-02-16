<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>検索結果画面</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	<script>
	</script>

	<style>
		*{font-size: 20px;}
	</style>
	<?php
		//エンドポイントのURIとフォーマットパラメータを変数に入れる
		$uri	= "https://api.gnavi.co.jp/RestSearchAPI/20150630/";
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
		$url  = sprintf("%s%s%s%s%s%s%s%s%s%s%s%s%s", $uri, "?format=", $format, "&keyid=", $acckey, "&latitude=", $lat,"&longitude=",$lon,"&range=",$range,"&offset_page=",$page);
		//API実行
		$json = file_get_contents($url);
		//取得した結果をオブジェクト化
		$obj  = json_decode($json);

		function checkString($input)
		{
			if(isset($input) && is_string($input)) {
				return true;
			}else{
				return false;
			}
			// if(!(isset($input))){
			// 	echo 'not set';
			// 	return false;
			// } else {
			// 	if(!(is_string($input))){
			// 		echo 'not string';
			// 		return false;
			// 	} else {
			// 		// echo 'success!';
			// 		return true;
			// 	}
			// }
		}

		session_start();
	?>


</head>
<body>

<?php foreach((array)$obj as $key => $val): ?>
	<?php
		if(strcmp($key, "total_hit_count") == 0){
			$total = $val;
			echo "total:".$total."<br>";
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
		<table border="1">
			<tbody>
				<?php foreach((array)$val as $restArray): ?>
					<?php $_SESSION[$restArray->{'id'}] = $restArray; ?>
					<tr>
						<td>
							<a href="RestaurantDetails.php?id=<?= $restArray->{'id'};?>" target="_blank">
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
						<td>
							<?php
								$img_url = $restArray->{'image_url'}->{'shop_image1'};
								if(checkString($img_url)){
									echo '<img src="' . $img_url. '"/>' ."\t";
								}
								$img_url = $restArray->{'image_url'}->{'shop_image2'};
								if(checkString($img_url)){
									echo '<img src="' . $img_url. '"/>' ."\t";
								}
								$img_url = $restArray->{'image_url'}->{'qrcode'};
								if(checkString($img_url)){
									echo '<img src="' . $img_url. '"/>' ."\t";
								}
							?>
						</td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	<?php endif; ?>
<?php endforeach;?>

<div style="display:inline-flex">
	<!-- 必要変数設定 -->
	<?php
		$prev = $page - 1;
		$next = $page + 1;
		$last = intval($total / $hit) + 1;
	?>

	<!-- 最初,次へ ボタン設置 -->
	<?php if($page > 1):?>
		<form action="" method="get">
			<input name="lat" type="hidden" value="<?= $lat; ?>">
			<input name="lon" type="hidden" value="<?= $lon; ?>">
			<input name="range" type="hidden" value="<?= $range; ?>">
			<input name="page" type="hidden" value="1">
			<button type="submit">最初</button>
		</form>

		<form action="" method="get">
			<input name="lat" type="hidden" value="<?= $lat; ?>">
			<input name="lon" type="hidden" value="<?= $lon; ?>">
			<input name="range" type="hidden" value="<?= $range; ?>">
			<input name="page" type="hidden" value="<?= $prev; ?>">
			<button type="submit">前ページ</button>
		</form>
	<?php endif; ?>
	<!-- 最初,次へ ボタン設置終了 -->

	<!-- 途中ページ　ボタン設置 -->
	<?php if($page > 3){ ?>
		<p>・・・</p>
	<?php } ?>

	<?php for($i = $page - 2, $cnt = 0;$cnt != 5; $i++, $cnt++){ ?>
		<?php if($i < 1){ $i = 1;} ?>
		<?php if($cnt == 0 && $i > $last - 4){ $i = $last - 4;} ?>

		<?php if($i == $page){ ?>
			<form>
				<button disabled="disabled"><?= $i; ?></button>
			</form>
		<?php } else { ?>
			<form action="" method="get">
				<input name="lat" type="hidden" value="<?= $lat; ?>">
				<input name="lon" type="hidden" value="<?= $lon; ?>">
				<input name="range" type="hidden" value="<?= $range; ?>">
				<input name="page" type="hidden" value="<?= $i; ?>">
				<button type="submit"><?= $i; ?></button>
			</form>
		<?php }; ?>
	<?php }; ?>

	<?php if($page <= $last - 3 && $page >= 3){ ?>
		<p>・・・</p>
	<?php } ?>
	<!-- 途中ページ　ボタン設置終了 -->

	<!-- 次へ,最後　ボタン設置 -->
	<?php if($page < $total / $hit): ?>
		<form action="" method="get">
			<input name="lat" type="hidden" value="<?= $lat; ?>">
			<input name="lon" type="hidden" value="<?= $lon; ?>">
			<input name="range" type="hidden" value="<?= $range; ?>">
			<input name="page" type="hidden" value="<?= $next; ?>">
			<button type="submit">次ページ</button>
		</form>

		<form action="" method="get">
			<input name="lat" type="hidden" value="<?= $lat; ?>">
			<input name="lon" type="hidden" value="<?= $lon; ?>">
			<input name="range" type="hidden" value="<?= $range; ?>">
			<input name="page" type="hidden" value="<?= $last; ?>">
			<button type="submit">最後</button>
		</form>
	<?php endif; ?>
	<!-- 次へ,最後　ボタン設置終了 -->
</div>

</body>
</html>
