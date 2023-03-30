<?php 
include "./language/language.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizz</title>
    <link rel="stylesheet" href="css/qstyle.css">
    <link src="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- FontAweome CDN Link for Icons -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/> -->
</head>
<body>
    <!-- start Quiz button -->
    <div class='parent'>
        <div class='child'><a href="quizone.php"><?php echo $language['quiz_round1']; ?></a></div>
        <div class='child'><a href="quiztwo.php"><?php echo $language['quiz_round2']; ?></a></div>
    </div>
</body>
</html>
</html>