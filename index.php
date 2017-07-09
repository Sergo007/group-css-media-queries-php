<?php
require "./lib/group.css.media.queries.php";
function printing($test)
{
    echo "<pre>".$test."</pre>";
}

function minifyCss($css)
{
    return str_replace(array("\n"," "), "", $css);
}
function test_groupCssMediaQueries($testName)
{
    $mixed = minifyCss(groupCssMediaQueries(file_get_contents('./test_examples/'.$testName.'.css')));
    $mixedSort = minifyCss(file_get_contents('./test_examples/'.$testName.'.sorted.css'));
    if(strcasecmp($mixed, $mixedSort) == 0){
        return 'true';
    }
    return 'false';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>test</title>
</head>
<body>
    <h1>Tests</h1>
    <?php
    echo "<pre>".'mixed: ' . test_groupCssMediaQueries('mixed')."</pre>";
    echo "<pre>".'only-max: ' . test_groupCssMediaQueries('only-max')."</pre>";
    echo "<pre>".'only-min: ' . test_groupCssMediaQueries('only-min')."</pre>";
    echo "<pre>".'readme-example: ' . test_groupCssMediaQueries('readme-example')."</pre>";
    ?>
</body>
</html>