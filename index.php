<?php
    require('passwordGenerator.php');

    $passwordGenerator = new PasswordGenerator("generator_sources");

    # validate input, if not valid set to a default value
    if(!isset($_POST["numberOfWords"]) || !$passwordGenerator->validNumber($_POST["numberOfWords"]))
    {
        $_POST["numberOfWords"] = 4;
    }


    if(!isset($_POST["numberOfNumbers"]) || !$passwordGenerator->validNumber($_POST["numberOfNumbers"]))
    {
        $_POST["numberOfNumbers"] = 1;
    }

    if(!isset($_POST["numberOfSymbols"]) || !$passwordGenerator->validNumber($_POST["numberOfSymbols"]))
    {
        $_POST["numberOfSymbols"] = 1;
    }

    if(!isset($_POST["separator"]) || ($_POST["separator"]!= Separator::camelCase && $_POST["separator"] != Separator::hyphen && $_POST["separator"]!= Separator::space)){
        $_POST["separator"]= Separator::hyphen;
    }

    if (!isset($_POST["source"]) || !in_array($_POST["source"], $passwordGenerator->getSourceFiles()))
    {
        $_POST["source"] = "random";
    }

    $password = $passwordGenerator->generatePassword($_POST["source"],$_POST["numberOfWords"],$_POST["numberOfNumbers"],$_POST["numberOfSymbols"], $_POST["separator"]);

    $imageName = str_replace("_words.txt","",$_POST["source"]).".jpg";

?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <title>Nolan Password Generator</title>
    </head>
    <body>
    <div class="container">
        <h1 class="text-center">XKCD Nolan Password Generator </h1>
        <div class="row text-center"><p>An <a href="http://xkcd.com/936/">xkcd style</a> password generator using words from <a href="https://en.wikipedia.org/wiki/Christopher_Nolan"> Christopher Nolan's</a> movies</p></div>
        <div id="movieImage" class="text-center ">
            <img class="img-circle" src="images/<?php echo $imageName ?>"/>
        </div>

        <div id = "password-text" class="text-center alert alert-info" role="alert"><?php echo $password; ?></div>


            <form method="post">
                <div class="row">
                <div class="form-group col-md-2">
                    <label for="numberOfWords">Number of words</label>
                    <select class="form-control" id="numberOfWords" name="numberOfWords">
                        <?php
                        # create an options list and keep the previously selected value
                        for($i = 1; $i < 10; $i++){
                            if($_POST["numberOfWords"] == $i){
                                echo "<option selected>".$i."</option>";
                            }
                            else{
                                echo "<option>".$i."</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="numberOfNumbers">Number of Digits</label>
                    <select class="form-control" id="numberOfNumbers" name="numberOfNumbers">
                        <?php
                        # create an options list and keep the previously selected value
                        for($i = 0; $i < 10; $i++){
                            if($_POST["numberOfNumbers"] == $i){
                                echo "<option selected>".$i."</option>";
                            }
                            else{
                                echo "<option>".$i."</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="numberOfSymbols">Number of Symbols</label>
                    <select class="form-control" id="numberOfSymbols" name="numberOfSymbols">
                        <?php
                        # create an options list and keep the previously selected value
                        for($i = 0; $i < 10; $i++){
                            if($_POST["numberOfSymbols"] == $i){
                                echo "<option selected>".$i."</option>";
                            }
                            else{
                                echo "<option>".$i."</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="separator">Separator</label>
                    <select class="form-control" id="separator" name="separator">
                        <option <?php if($_POST["separator"] == Separator::space) echo "selected"; ?> value = " ">space</option>
                        <option <?php if($_POST["separator"] == Separator::hyphen) echo "selected"; ?> value = "-">hyphen</option>
                        <option <?php if($_POST["separator"] == Separator::camelCase) echo "selected"; ?> value = "camel">camelCase</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label for="source">Source Script</label>
                    <select class="form-control" id="source" name="source">
                        <option <?php if($_POST["source"] == "batman_begins_words.txt") echo "selected"; ?> value="batman_begins_words.txt">Batman Begins</option>
                        <option <?php if($_POST["source"] == "inception_words.txt") echo "selected"; ?> value="inception_words.txt">Inception</option>
                        <option <?php if($_POST["source"] == "interstellar_words.txt") echo "selected"; ?> value="interstellar_words.txt">Interstellar</option>
                        <option <?php if($_POST["source"] == "memento_words.txt") echo "selected"; ?> value="memento_words.txt">Memento</option>
                        <option <?php if($_POST["source"] == "the_prestige_words.txt") echo "selected"; ?> value="the_prestige_words.txt">The Prestige</option>
                        <option <?php if($_POST["source"] == "random") echo "selected"; ?> value="random">Random Script</option>
                    </select>
                </div>

            </div>
            <div class="row text-center">
            <button type="submit" class="btn btn-lg">Generate Password</button>
            </div>
        </form>

    </div>
    </body>
</html>