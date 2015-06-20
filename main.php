<?php
/*
 * 多次元配列にしてみる
 * $answer[横ブロック][縦ブロック][横アイテム][縦アイテム]
 * $answer[$bx][$by][$x][$y]
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
for($bx = 0; $bx < BLOCK; $bx++) {
	$answer[$bx] = NULL;
	for($by = 0; $by < BLOCK; $by++) {
		$answer[$bx][$by] = NULL;
		for($x = 0; $x < ITEM; $x++) {
			$answer[$bx][$by][$x] = NULL;
			for($y = 0; $y < ITEM; $y++) {
				$answer[$bx][$by][$x][$y] = NULL;
			}
		}
	}
}
$loop = 1;
// TODO
// フォームからデータを持ってくる
// test
$answer[0][0][2][3] = '×';
$answer[1][0][1][1] = '×';
$answer[2][0][1][1] = '○';
$answer[3][0][2][2] = '○';
$answer[0][1][1][3] = '○';
$answer[1][1][0][0] = '×';
$answer[1][1][2][2] = '○';
$answer[2][1][3][2] = '×';
$answer[0][2][3][2] = '○';
$answer[1][2][3][0] = '○';
$answer[0][3][0][0] = '○';
$answer[0][3][1][1] = '×';

do {
	$tmp_maru = $maru;
	$tmp_batu = $batu;
//	// ○がついたら縦横に×をつける
//	for($bx = 0; $bx < BLOCK; $bx++) {
//		for($by = 0; $by < BLOCK; $by++) {
//			for($x = 0; $x < ITEM; $x++) {
//				for($y = 0; $y < ITEM; $y++) {
//					if($answer[$bx][$by][$x][$y] == '○') {
//						// 横に×をつける
//						for($m = 0; $m < ITEM; $m++) {
//							if($answer[$bx][$by][$x][$m] == NULL) {
//								$answer[$bx][$by][$x][$m] = '×';
//								$batu += 1;
//							}
//						}
//						// 縦に×をつける
//						for($n = 0; $n < ITEM; $n++) {
//							if($answer[$bx][$by][$n][$y] == NULL) {
//								$answer[$bx][$by][$n][$y] = '×';
//								$batu += 1;
//							}
//						}
//					}
//				}
//			}
//		}
//	}
//	// TODO
//	// ○に対応するところが×なら×
//	list ($answer, $maru, $batu) = MaruBatuCheck($answer, $maru, $batu);
//	// 縦横○なら○、それ以外なら×
//	list ($answer, $maru, $batu) = BlockCheck($answer, $maru, $batu);
//	// ×で埋まっていたら○
//	list ($answer, $maru, $batu) = AllBatuCheck($answer, $maru, $batu);
//	echo $loop.'loop<br />';
	$loop += 1;
//} while($tmp_maru != $maru || $tmp_batu != $batu);
} while($loop <= 1);
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
	for($bx = 0; $bx < ITEM; $bx++) {
		for($by = 0; $by < ITEM; $by++) {
			if($answer[$tate_block_3][$yoko_block_3][$bx][$by] == NULL) {
				if($answer[$tate_block_1][$yoko_block_1][$bx][$by] == '×' && $answer[$tate_block_2][$yoko_block_2][$bx][$by] == '×') {
					$answer[$tate_block_3][$yoko_block_3][$bx][$by] = '×';
					$batu += 1;
				}
				if($answer[$tate_block_1][$yoko_block_1][$bx][$by] == '○' && $answer[$tate_block_2][$yoko_block_2][$bx][$by] == '×') {
					$answer[$tate_block_3][$yoko_block_3][$bx][$by] = '×';
					$batu += 1;
				}
				if($answer[$tate_block_1][$yoko_block_1][$bx][$by] == '×' && $answer[$tate_block_2][$yoko_block_2][$bx][$by] == '○') {
					$answer[$tate_block_3][$yoko_block_3][$bx][$by] = '×';
					$batu += 1;
				}
				if($answer[$tate_block_1][$yoko_block_1][$bx][$by] == '○' && $answer[$tate_block_2][$yoko_block_2][$bx][$by] == '○') {
					$answer[$tate_block_3][$yoko_block_3][$bx][$by] = '○';
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
	for($bx = 0; $bx < ITEM; $bx++) {
		$tmp_i = 0;
		$tmp_j = 0;
		$tmp_k = 0;
		$tmp_l = 0;
		for($by = 0; $by < ITEM; $by++) {
			if($answer[$tate_block_1][$yoko_block_1][$bx][$by] == '○') {
				$tmp_i = $bx;
				$tmp_j = $by;
				for($x = 0; $x < ITEM; $x++) {
					for($y = 0; $y < ITEM; $y++) {
						if($answer[$tate_block_2][$yoko_block_2][$bx][$y] == '×') {
							$tmp_k = $x;
							$tmp_l = $y;
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
	for($bx = 0; $bx < BLOCK; $bx++) {
		for($by = 0; $by < BLOCK; $by++) {
			for($x = 0; $x < ITEM; $x++) {
				for($y = 0; $y < ITEM; $y++) {
					if($answer[$bx][$by][$x][$y] == NULL) {
						$tate_count = 0;
						$yoko_count = 0;
						// 横に○をつける
						for($m = 0; $m < ITEM; $m++) {
							if($answer[$bx][$by][$x][$m] != NULL) {
								$yoko_count += 1;
								if($yoko_count == ITEM - 1) {
									for($n = 0; $n < ITEM; $n++) {
										if($answer[$bx][$by][$x][$n] == NULL) {
											$answer[$bx][$by][$x][$n] = '○';
											$maru += 1;
										}
									}
								}
							}
						}
						// 縦に○をつける
						for($n = 0; $n < ITEM; $n++) {
							if($answer[$bx][$by][$n][$y] != NULL) {
								$tate_count += 1;
								if($tate_count == ITEM - 1) {
									for($n = 0; $n < ITEM; $n++) {
										if($answer[$bx][$by][$n][$y] == NULL) {
											$answer[$bx][$by][$n][$y] = '○';
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
$tmp_block = BLOCK;
for($by = 0; $by < BLOCK; $by++) {
	for($y = 0; $y < ITEM; $y++) {
		for($bx = 0; $bx < $tmp_block; $bx++) {
			for($x = 0; $x < ITEM; $x++) {
				if($answer[$bx][$by][$x][$y] == NULL) {
					echo '？';
				}
				echo $answer[$bx][$by][$x][$y];
			}
			echo '■';
		}
		echo '<br />';
	}
	for($bx = 0; $bx < ($tmp_block * ITEM) + $tmp_block; $bx++) {
		echo '■';
	}
	echo '<br />';
	$tmp_block -= 1;
}
