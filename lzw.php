<?php
    /** LZW compression
* @param string data to compress
* @return string binary data
* Adapted from http://rosettacode.org/wiki/LZW_compression
* @author: colby callahan
*/
function lzw_compress($string) {
    // compression
    $dictionary = array_flip(range("\0", "\xFF"));
    $word = "";
    $codes = array();
    for ($i=0; $i < strlen($string); $i += 1) {
        $x = $string[$i];
        if (strlen($x) && isset($dictionary[$word . $x])) {
            $word .= $x;
        } elseif ($i) {
            $codes[] = $dictionary[$word];
            $dictionary[$word . $x] = count($dictionary);
            $word = $x;
        }
    }
    
    // convert codes to binary string
    $dictionary_count = 256;
    $bits = 8; // ceil(log($dictionary_count, 2))
    $return = "";
    $rest = 0;
    $rest_length = 0;
    foreach ($codes as $code) {
        $rest = ($rest << $bits) + $code;
        $rest_length += $bits;
        $dictionary_count++;
        if ($dictionary_count > (1 << $bits)) {
            $bits++;
        }
        while ($rest_length > 7) {
            $rest_length -= 8;
            $return .= chr($rest >> $rest_length);
            $rest &= (1 << $rest_length) - 1;
        }
    }
    return $return . ($rest_length ? chr($rest << (8 - $rest_length)) : "");
}

function lzw_decompress($binary) {
	// convert binary string to codes
	$dictionary_count = 256;
	$bits = 8; // ceil(log($dictionary_count, 2))
	$codes = array();
	$rest = 0;
	$rest_length = 0;
	for ($i=0; $i < strlen($binary); $i++) {
		$rest = ($rest << 8) + ord($binary[$i]);
		$rest_length += 8;
		if ($rest_length >= $bits) {
			$rest_length -= $bits;
			$codes[] = $rest >> $rest_length;
			$rest &= (1 << $rest_length) - 1;
			$dictionary_count++;
			if ($dictionary_count >> $bits) {
				$bits++;
			}
		}
        // print_r($rest);
        // echo "<br>";
	}
	
	// decompression
	$dictionary = range("\0", "\xFF");
	$return = "";
	foreach ($codes as $i => $code) {
        $word="";
		$element = $dictionary[$code];
		if (!isset($element)) {
			$element = $word . $word[0];
		}
		$return .= $element;
		if ($i) {
			$dictionary[] = $word . $element[0];
		}
		$word = $element;
	}
	return $return;
}
// function lzw_decompress($compressed) {
//     $word = ""; 
//     $dictionary = []; 
//     $entry = "";
//     $dictSize = 256;

//     for ($i = 0; $i < 256; $i += 1) {
//         $dictionary[$i] = chr($i);
//     }
//     $q = str_split($compressed);
//     // $aa = mb_ord($q);
//     // var_dump($q);
//     $w = chr($compressed[0]);
//     $result = $w;
//     // var_dump($result);
//     for ($i = 1; $i < count(str_split($compressed)); $i += 1) {
//         $k = $compressed[$i];
//         if ($dictionary[$k]) {
//             $entry = $dictionary[$k];
//         } else {
//             if ($k === $dictSize) {
//                 $entry = $w . substr($w, 0, 1);
//             } else {
//                 return $k;
//                 return null;
//             }
//         }

//         $result .= $entry;

//         // Add w+entry[0] to the dictionary.
//         $dictionary[$dictSize++] = $w . substr($entry, 0, 1);

//         $w = $entry;
//     }
//     return $result;
// }


/*This handles the compressed data*/    
// echo lzw_decompress(explode(',', $_POST['test']));die;

?>