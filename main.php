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

	// ○がついたら縦横を×で埋める
	list ($answer, $batu) = AllBatuCheck($answer, $batu);

	// TODO
	// ○に対応するところが×なら×
	list ($answer, $maru, $batu) = MaruBatuCheck($answer, $maru, $batu);

	// TODO
	// ×で埋まっていたら○
	//list ($answer, $maru, $batu) = AllBatuCheck($answer, $maru, $batu);

	echo '-'.$loop.'loop-<br />';
	$loop += 1;
//} while($tmp_maru != $maru || $tmp_batu != $batu);
} while($loop <= 1);
/*
 * 関数
 */

/*
 * NULL○チェック
 */
function NullMaruCheck($answer, $bx, $by, $x, $y, $maru) {

	if($answer[$bx][$by][$x][$y] == NULL) {
		$answer[$bx][$by][$x][$y] = '○';
		$maru += 1;
	}

	return array ($answer, $maru);
}

/*
 * NULL×チェック
 */
function NullBatuCheck($answer, $bx, $by, $x, $y, $batu) {

	if($answer[$bx][$by][$x][$y] == NULL) {
		$answer[$bx][$by][$x][$y] = '×';
		$batu += 1;
	}

	return array ($answer, $batu);
}

/*
 * ×埋めチェック
 */
function AllBatuCheck($answer, $batu) {
	for($bx = 0; $bx < BLOCK; $bx++) {
		for($by = 0; $by < BLOCK; $by++) {
			for($x = 0; $x < ITEM; $x++) {
				for($y = 0; $y < ITEM; $y++) {
					if($answer[$bx][$by][$x][$y] == '○') {
						// 縦に×をつける
						for($i = 0; $i < ITEM; $i++) {
							list ($answer, $batu) = NullBatuCheck($answer, $bx, $by, $x, $i, $batu);
						}
						// 横に×をつける
						for($i = 0; $i < ITEM; $i++) {
							list ($answer, $batu) = NullBatuCheck($answer, $bx, $by, $i, $y, $batu);
						}
					}
				}
			}
		}
	}

	return array ($answer, $batu);
}

// TODO
/*
 * ブロックチェック
 * 縦○横○なら○
 * それ以外なら×
 */

// TODO
/*
 * ○×チェック
 */
function MaruBatuCheck($answer, $maru, $batu) {
	$array = $answer;

	for($bx = 0; $bx < BLOCK; $bx++) {
		for($by = 0; $by < BLOCK; $by++) {
			for($x = 0; $x < ITEM; $x++) {
				for($y = 0; $y < ITEM; $y++) {
					if($answer[$bx][$by][$x][$y] == '○') {
						echo 'bx='.$bx.'<br />';
						echo 'by='.$by.'<br />';
						echo 'x='.$x.'<br />';
						echo 'y='.$y.'<br />';
						echo '<br />';
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

?>
