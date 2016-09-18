<?php
abstract class Separator
{
	const space = " ";
	const hyphen = "-";
	const camel = "camel";
}


function generatePassword($dictionary, $symbols, $numWords = 4, $numNumbers = 1, $numSymbols = 1, $separator = Separator::space)
{
    $wordsArray = [];
    $passwordString = "";
    # pick random words in the dictionary
    for ($i = 0; $i < $numWords; $i++)
    {
        $pick = rand(0, count($dictionary) - 1);
        $word = $dictionary[$pick];
        if ($i > 0 && $separator == Separator::camel)
        {
            $word = ucfirst($word);
        }
        array_push($wordsArray, $word);
    }

    # concatenate random words
    if ($separator == Separator::camel)
    {
        $passwordString = implode($wordsArray, "");
    }
    else{
        $passwordString = implode($wordsArray, $separator);
    }

    # add symbols
    for($i = 0; $i < $numSymbols; $i++){
        $passwordString .= $symbols[rand(0,count($symbols) -1 )];
    }

    # add numbers
    for($i = 0; $i < $numNumbers; $i++){

        $passwordString .= strval(rand(0,9));
    }

    return $passwordString;
}

$dictionary = file("generator_sources/google-10000-english-usa.txt");
$symbols = file("generator_sources/symbols.txt");





$password = generatePassword($dictionary, $symbols);

