<?php

const ERROR_REQUIRED = 'Veuillez renseigner une todo';
const ERROR_TOO_SHORT = 'Veuillez entrer au moins 5 caractères';

$filename = __DIR__ . '/data/todos.json';

$error = '';

$todos = [];

if (file_exists($filename)){
    $data = file_get_contents($filename);
    $todos = json_decode($data, true) ?? [];
}



if($_SERVER['REQUEST_METHOD'] === "POST"){
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    $todo = $_POST['todo'] ?? '';

    if (!$todo){
        $error = ERROR_REQUIRED;
    }elseif(mb_strlen($todo) < 5) {
        $error = ERROR_TOO_SHORT;
    }
}

    if (!$error){
        $todos = [...$todos, [
        'name' => $todo,
        'done' => false,
        'id' => time(),
        ]];
        file_put_contents($filename, json_encode($todos));
    
    }




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'includes/head.php'?>
    <title>To do</title>
</head>

<body>

    <div class="container">
        <?php require_once 'includes/header.php'?>
    <div class="content">

        <div class="todo-container">

            <h1>To do</h1>

                <form action ="/" method = "POST" class="todo-form">
                    <input name ="todo" type="text">
                    <button class="btn btn-primary">Ajouter</button>
                </form>

                <?php if($error): ?>
                    <p class="text-danger">
                        <?= $error ?></p>
                        <?php endif;?>
            
            <div class="todo list">

            </div>

        </div>

    </div>

        <?php require_once 'includes/footer.php'?>

</div>


    
</body>
</html>