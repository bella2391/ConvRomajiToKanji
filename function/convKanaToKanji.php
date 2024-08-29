<?php
function getConvKanaToKanjiList($kana) {
    $curl = curl_init();
    $encodeWord = urlencode($kana);
    $http = "http://www.google.com/transliterate?langpair=ja-Hira|ja&text=".$encodeWord;
    curl_setopt($curl, CURLOPT_URL, $http);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $trans_list = json_decode($response, true);
    return $trans_list;
}