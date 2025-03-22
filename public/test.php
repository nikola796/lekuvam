<?php
var_dump(time());
$path = realpath('../'.FILES_FOLDER) . DIRECTORY_SEPARATOR;
var_dump(FILES_FOLDER);
var_dump(file_exists($path.'597edd38f38b5.doc')) . "\n";
//$path = realpath('../core'.DIRECTORY_SEPARATOR.'files') . DIRECTORY_SEPARATOR;
//var_dump('../core'.DIRECTORY_SEPARATOR.'files'. DIRECTORY_SEPARATOR.'59a02369c8f72.png');
//echo $path.'59a02369c8f72.png';
//var_dump(file_exists('../core'.DIRECTORY_SEPARATOR.'files'. DIRECTORY_SEPARATOR.'59a02369c8f72.png'));

die();
$a = 2;

if($a == 1){
    echo 'a = 1';
} elseif ($a > 0){
    echo '<br> a > 0';
} else{
    echo 'a is not = 1 and is not > 1';
}


function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

//echo randomPassword();

//$acc = array(0 => 2, 1 =>15);
//$ar = array(
//    0 => array( 0 => array(
//                                'category_id' => 2, 'name' => 'Аида'
//                             ),
//                 1 => array(
//                                'category_id' => 5, 'name' => 'Техническо задание'
//                             )
//                ),
//    1 => array(0 => array('category_id' => 5, 'name' => 'Техническо задание')));

//echo '<pre>' . print_r($ar, true) . '</pre>';

//foreach ($ar as $a){
//    $key[] = array_search(2, $a);
//}
//echo '<pre>' . print_r($key, true) . '</pre>';

//$pr = array('Пространство едно' => array('num' => 4),'Пространство две' => array('num' => 3));
//
//$post = array('Пост едно' => array('num' => 2),'Пост две' => array('num' => 1));
//
//$files = array('Файл едно' => array('num' => 6),'Файл две' => array('num' => 5));
//
//$mergeArr = array_merge($pr, $post, $files);
//
//$res[] = usort($mergeArr, function($a, $b) {
//    return $a['num'] - $b['num'].'<br>';
//});
//
//
//$arr = Array
//(
//    0 => Array
//    (
//        'hashtag' => 'a7e87329b5eab8578f4f1098a152d6f4',
//        'title' => 'Flower',
//        'order' => 3
//    ),
//
//    1 => Array
//    (
//        'hashtag' => 'b24ce0cd392a5b0b8dedc66c25213594',
//        'title' => 'Free',
//        'order' => 2
//    ),
//
//    2 => Array
//    (
//        'hashtag' => 'e7d31fc0602fb2ede144d18cdffd816b',
//        'title' => 'Ready',
//        'order' => 1
//    )
//);
//
//echo '<pre>' . print_r($arr, true) . '</pre>';
//usort($arr, function($a, $b) {
//    return $a['order'] - $b['order'];
//});
//echo '<pre>' . print_r($arr, true) . '</pre>';
//
//
