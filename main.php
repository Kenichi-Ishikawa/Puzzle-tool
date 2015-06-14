<?php
/*
 * 多次元配列にしてみる
 * $answer[縦ブロック][横ブロック][縦アイテム][横アイテム]
 * $answer[$i][$j][$k][$l]
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
	$answer[$i] = NULL;
	for($j = 0; $j < BLOCK; $j++) {
		$answer[$i][$j] = NULL;
		for($k = 0; $k < ITEM; $k++) {
			$answer[$i][$j][$k] = NULL;
			for($l = 0; $l < ITEM; $l++) {
				$answer[$i][$j][$k][$l] = NULL;
			}
		}
	}
}
$loop = 1;

// TODO
// フォームからデータを持ってくる
// test
$answer[0][0][3][2] = '×';
$answer[0][1][1][1] = '×';
$answer[0][2][1][1] = '○';
$answer[0][3][2][2] = '○';

$answer[1][0][3][1] = '○';
$answer[1][1][0][0] = '×';
$answer[1][1][2][2] = '○';
$answer[1][2][2][3] = '×';

$answer[2][0][2][3] = '○';
$answer[2][1][0][3] = '○';

$answer[3][0][0][0] = '○';
$answer[3][0][1][1] = '×';


do {
	$tmp_maru = $maru;
	$tmp_batu = $batu;

	// ○がついたら縦横に×をつける
	for($i = 0; $i < BLOCK; $i++) {
		for($j = 0; $j < BLOCK; $j++) {
			for($k = 0; $k < ITEM; $k++) {
				for($l = 0; $l < ITEM; $l++) {
					if($answer[$i][$j][$k][$l] == '○') {
						// 横に×をつける
						for($m = 0; $m < ITEM; $m++) {
							if($answer[$i][$j][$k][$m] == NULL) {
								$answer[$i][$j][$k][$m] = '×';
								$batu += 1;
							}
						}
						// 縦に×をつける
						for($n = 0; $n < ITEM; $n++) {
							if($answer[$i][$j][$n][$l] == NULL) {
								$answer[$i][$j][$n][$l] = '×';
								$batu += 1;
							}
						}
					}
				}
			}
		}
	}

	// TODO
	// ○に対応するところが×なら×
	list ($answer, $maru, $batu) = MaruBatuCheck($answer, $maru, $batu);

	// 縦横○なら○、それ以外なら×
	list ($answer, $maru, $batu) = BlockCheck($answer, $maru, $batu);

	// ×で埋まっていたら○
	list ($answer, $maru, $batu) = AllBatuCheck($answer, $maru, $batu);

	echo $loop.'loop<br />';
	$loop += 1;

} while($tmp_maru != $maru || $tmp_batu != $batu);
//} while($loop <= 2);


/*
 * 関数
 */

/*
 * ブロックチェック
 * 縦○横○なら○
 * それ以外なら×
 */
function BlockCheck($answer, $maru, $batu) {
	switch (BLOCK) {
	case 4:
		list ($answer, $maru, $batu) = BlockCheckDetail($answer, $maru, $batu, 0, 1, 0, 0, 3, 0);
		list ($answer, $maru, $batu) = BlockCheckDetail($answer, $maru, $batu, 0, 1, 3, 0, 0, 0);
		list ($answer, $maru, $batu) = BlockCheckDetail($answer, $maru, $batu, 0, 2, 0, 0, 2, 0);
		list ($answer, $maru, $batu) = BlockCheckDetail($answer, $maru, $batu, 0, 3, 0, 0, 1, 0);
		list ($answer, $maru, $batu) = BlockCheckDetail($answer, $maru, $batu, 0, 3, 1, 1, 0, 1);
		list ($answer, $maru, $batu) = BlockCheckDetail($answer, $maru, $batu, 1, 2, 2, 1, 1, 1);

		return array ($answer, $maru, $batu);
		break;
	default:
		// 何もしない
		break;
	}
}

function BlockCheckDetail($answer, $maru, $batu, $tate_block_1, $yoko_block_1, $tate_block_2, $yoko_block_2, $tate_block_3, $yoko_block_3) {
	for($i = 0; $i < ITEM; $i++) {
		for($j = 0; $j < ITEM; $j++) {
			if($answer[$tate_block_3][$yoko_block_3][$i][$j] == NULL) {
				if($answer[$tate_block_1][$yoko_block_1][$i][$j] == '×' && $answer[$tate_block_2][$yoko_block_2][$i][$j] == '×') {
					$answer[$tate_block_3][$yoko_block_3][$i][$j] = '×';
					$batu += 1;
				}
				if($answer[$tate_block_1][$yoko_block_1][$i][$j] == '○' && $answer[$tate_block_2][$yoko_block_2][$i][$j] == '×') {
					$answer[$tate_block_3][$yoko_block_3][$i][$j] = '×';
					$batu += 1;
				}
				if($answer[$tate_block_1][$yoko_block_1][$i][$j] == '×' && $answer[$tate_block_2][$yoko_block_2][$i][$j] == '○') {
					$answer[$tate_block_3][$yoko_block_3][$i][$j] = '×';
					$batu += 1;
				}
				if($answer[$tate_block_1][$yoko_block_1][$i][$j] == '○' && $answer[$tate_block_2][$yoko_block_2][$i][$j] == '○') {
					$answer[$tate_block_3][$yoko_block_3][$i][$j] = '○';
					$maru += 1;
				}
			}
		}
	}
	return array ($answer, $maru, $batu);
}


/*
 * ○×チェック
 */
function MaruBatuCheck($answer, $maru, $batu) {
	switch (BLOCK) {
	case 4:
		list ($answer, $maru, $batu) = MaruBatuCheckDetail($answer, $maru, $batu, 1, 0, 0, 0, 0, 3);
		list ($answer, $maru, $batu) = MaruBatuCheckDetail($answer, $maru, $batu, 2, 0, 0, 0, 0, 2);
		list ($answer, $maru, $batu) = MaruBatuCheckDetail($answer, $maru, $batu, 3, 0, 0, 0, 0, 1);
		list ($answer, $maru, $batu) = MaruBatuCheckDetail($answer, $maru, $batu, 1, 2, 1, 1, 2, 1);
		list ($answer, $maru, $batu) = MaruBatuCheckDetail($answer, $maru, $batu, 2, 1, 1, 1, 1, 2);
		list ($answer, $maru, $batu) = MaruBatuCheckDetail($answer, $maru, $batu, 0, 2, 0, 3, 1, 2);

		return array ($answer, $maru, $batu);
		break;
	default:
		// 何もしない
		break;
	}
}

function MaruBatuCheckDetail($answer, $maru, $batu, $tate_block_1, $yoko_block_1, $tate_block_2, $yoko_block_2, $tate_block_3, $yoko_block_3) {
	for($i = 0; $i < ITEM; $i++) {
		$tmp_i = 0;
		$tmp_j = 0;
		$tmp_k = 0;
		$tmp_l = 0;
		for($j = 0; $j < ITEM; $j++) {
			if($answer[$tate_block_1][$yoko_block_1][$i][$j] == '○') {
				$tmp_i = $i;
				$tmp_j = $j;
				for($k = 0; $k < ITEM; $k++) {
					for($l = 0; $l < ITEM; $l++) {
						if($answer[$tate_block_2][$yoko_block_2][$i][$l] == '×') {
							$tmp_k = $k;
							$tmp_l = $l;
						}
					}
				}
			}
		}
		/*
		if($tmp_i || $tmp_j || $tmp_k || $tmp_l) {
			echo '<br />';
			echo 'tmp_i='.$tmp_i.'<br />';
			echo 'tmp_j='.$tmp_j.'<br />';
			echo 'tmp_k='.$tmp_k.'<br />';
			echo 'tmp_l='.$tmp_l.'<br />';
			echo '<br />';
		}
		 */
		if($answer[$tate_block_3][$yoko_block_3][$tmp_l][$tmp_i] == NULL) {
			$answer[$tate_block_3][$yoko_block_3][$tmp_l][$tmp_i] = '×';
			$batu += 1;
		}
	}
	return array ($answer, $maru, $batu);
}


/*
 * ALL×チェック
 */
function AllBatuCheck($answer, $maru, $batu) {
	for($i = 0; $i < BLOCK; $i++) {
		for($j = 0; $j < BLOCK; $j++) {
			for($k = 0; $k < ITEM; $k++) {
				for($l = 0; $l < ITEM; $l++) {
					if($answer[$i][$j][$k][$l] == NULL) {
						$tate_count = 0;
						$yoko_count = 0;
						// 横に○をつける
						for($m = 0; $m < ITEM; $m++) {
							if($answer[$i][$j][$k][$m] != NULL) {
								$yoko_count += 1;
								if($yoko_count == ITEM - 1) {
									for($n = 0; $n < ITEM; $n++) {
										if($answer[$i][$j][$k][$n] == NULL) {
											$answer[$i][$j][$k][$n] = '○';
											$maru += 1;
										}
									}
								}
							}
						}
						// 縦に○をつける
						for($n = 0; $n < ITEM; $n++) {
							if($answer[$i][$j][$n][$l] != NULL) {
								$tate_count += 1;
								if($tate_count == ITEM - 1) {
									for($n = 0; $n < ITEM; $n++) {
										if($answer[$i][$j][$n][$l] == NULL) {
											$answer[$i][$j][$n][$l] = '○';
											$maru += 1;
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
	return array ($answer, $maru, $batu);
}








/*
 * 出力
 */
/*
echo "<pre>";
print_r($answer); //今度は<pre>タグで囲ってます。
echo "</pre>";
 */

echo '<br />';
$tem_block = BLOCK;
for($l = 0; $l < BLOCK; $l++) {
	for($k = 0; $k < ITEM; $k++) {
		for($i = 0; $i < $tem_block; $i++) {
			for($j = 0; $j < ITEM; $j++) {
				if($answer[$l][$i][$k][$j] == NULL) {
					echo '？';
				}
				echo $answer[$l][$i][$k][$j];
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



