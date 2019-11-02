<?php
    $text = file_get_contents("file.txt"); 
    $words_array = str_word_count($text, 1);
    $long_words_array = [];
    $max = 0;
    for( $i = 0; $i < count($words_array); $i++ )
    { 
        if (strlen($words_array[$i]) > $max) {
            $max = strlen($words_array[$i]);
            $long_words_array = array($words_array[$i]);
        } elseif (strlen($words_array[$i]) == $max && !in_array($words_array[$i], $long_words_array)) {
            array_push($long_words_array, $words_array[$i]); 
        }
    } 
    echo '<h1>List of the longest words ('.$max.' letters)</h1>';
    for( $i = 0; $i < count( $long_words_array ); $i++ )
    { 
        echo ($i+1).'. <span style="display: inline-block; transform: skewX('.$i.'deg);">'.($long_words_array[$i]).'</span><br>';
    } 
?>