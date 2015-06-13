<?php
/*
 * 多次元配列にしてみる
 * $anser[縦ブロック][横ブロック][縦アイテム][横アイテム]
 * $anser[$i][$j][$k][$l]
 */
// TODO
// この定義もいずれフォームから取ってくる？
define('BLOCK',4);
define('ITEM',4);

// 初期化
$tmp_maru = 0;
$tmp_batu = 0;
$maru = 0;
$batu = 0;
for($i = 0; $i < BLOCK; $i++) {
	$anser[$i] = NULL;
	for($j = 0; $j < BLOCK; $j++) {
		$anser[$i][$j] = NULL;
		for($k = 0; $k < ITEM; $k++) {
			$anser[$i][$j][$k] = NULL;
			for($l = 0; $l < ITEM; $l++) {
				$anser[$i][$j][$k][$l] = NULL;
			}
		}
	}
}

// TODO
// フォームからデータを持ってくる
// test
$anser[0][0][3][2] = '×';
$anser[0][1][1][1] = '×';
$anser[0][2][1][1] = '○';
$anser[0][3][2][2] = '○';

$anser[1][0][3][1] = '○';
$anser[1][1][0][0] = '×';
$anser[1][1][2][2] = '○';
$anser[1][2][2][3] = '×';

$anser[2][0][2][3] = '○';
$anser[2][1][0][3] = '○';

$anser[3][0][0][0] = '○';
$anser[3][0][1][1] = '×';


do {
	$tmp_batu = $batu;
	$tmp_maru = $maru;

	// ○がついたら縦横に×をつける
	for($i = 0; $i < BLOCK; $i++) {
		for($j = 0; $j < BLOCK; $j++) {
			for($k = 0; $k < ITEM; $k++) {
				for($l = 0; $l < ITEM; $l++) {
					if($anser[$i][$j][$k][$l] == '○') {
						// 横に×をつける
						for($m = 0; $m < ITEM; $m++) {
							if($anser[$i][$j][$k][$m] == NULL) {
								$anser[$i][$j][$k][$m] = '×';
								$batu += 1;
							}
						}
						// 縦に×をつける
						for($n = 0; $n < ITEM; $n++) {
							if($anser[$i][$j][$n][$l] == NULL) {
								$anser[$i][$j][$n][$l] = '×';
								$batu += 1;
							}
						}
					}
				}
			}
		}
	}

	// TODO
	// 縦横○なら○、それ以外なら×


	// TODO
	// ×で埋まっていたら○



//} while($tmp_maru != $maru && $tmp_batu != $batu);
} while($tmp_batu != $batu);

/*
 * 出力
 */
$tem_block = BLOCK;
for($l = 0; $l < BLOCK; $l++) {
	for($k = 0; $k < ITEM; $k++) {
		for($i = 0; $i < $tem_block; $i++) {
			for($j = 0; $j < ITEM; $j++) {
				if($anser[$l][$i][$k][$j] == NULL) {
					echo '？';
				}
				echo $anser[$l][$i][$k][$j];
			}
			echo '■';
		}
		echo '<br />';
	}

	for($i = 0; $i < ($tem_block * ITEM) + $tem_block; $i++) {
		echo '■';
	}
	echo '<br />';

	$tem_block -= 1;
}



