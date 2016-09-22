<?php

/**
 * Class Separator
 *
 * A helper class which defines what kind of separators a password should have
 */
abstract class Separator
{
	const space = " ";
	const hyphen = "-";
	const camelCase = "camel";
}

/**
 * Class PasswordGenerator
 *
 * This password generator takes in a folder of text files each filled with words
 * separated by newline characters as sources.
 *
 */
class PasswordGenerator
{
    protected $sourceDirectory;
    protected $sourceFiles;

    /**
     * PasswordGenerator constructor.
     * @string $sourceDirectory a directory with text file(s) for password generation
     */
    function __construct($sourceDirectory)
    {
        $this->sourceDirectory = $sourceDirectory;
    }

    function generateTokens($dictionary, $symbols, $numWords, $numNumbers, $numSymbols, $separator)
    {
        $wordsArray = [];
        $passwordString = "";

        # pick random words in the dictionary
        for ($i = 0; $i < $numWords; $i++)
        {
            $pick = rand(0, count($dictionary) - 1);
            $word = $dictionary[$pick];
            #remove white space
            $word = trim($word, " \t\n\r");

            #upper case first character of all subsequent words if camelCase option is chosen
            if ($i > 0 && $separator == Separator::camelCase)
            {
                $word = ucfirst($word);
            }
            array_push($wordsArray, $word);
        }

        # concatenate the words
        if ($separator == Separator::camelCase)
        {
            $passwordString = implode($wordsArray, "");
        } else
        {
            $passwordString = implode($wordsArray, $separator);
        }

        # add numbers
        for ($i = 0; $i < $numNumbers; $i++)
        {

            $passwordString .= strval(rand(0, 9));
        }

        # add symbols
        for ($i = 0; $i < $numSymbols; $i++)
        {
            $passwordString .= trim($symbols[rand(0, count($symbols) - 1)]," \t\n\r");;
        }


        return $passwordString;
    }

    function pickRandomDictionary()
    {
        # picks a random source file as a dictionary
        $sourceFileNames = $this->getSourceFiles();
        $pick = rand(0, count($sourceFileNames) - 1);
        return $sourceFileNames[$pick];
    }

    function getSourceFiles()
    {
        if ($this->sourceFiles)
        {
            return $this->sourceFiles;
        } else
        {
            $dictionaryDirectory = new DirectoryIterator($this->sourceDirectory);
            $sourceFileNames = [];

            # loop through the source directory and add all file names to an array
            # leave out symbols.txt
            # leave out child and parent "files" aka folders
            foreach ($dictionaryDirectory as $fileinfo)
            {
                if (!$fileinfo->isDot() && $fileinfo->getFilename() != "symbols.txt")
                {
                    array_push($sourceFileNames, $fileinfo->getFilename());
                }
            }

            $this->sourceFiles = $sourceFileNames;
            return $sourceFileNames;
        }
    }

    function validNumber($variable)
    {
        return is_numeric($variable) && is_int((int)$variable) && (int)$variable >= 0;
    }


    public function generatePassword($dictionaryPick, $numWords, $numNumbers, $numSymbols, $separator)
    {

        if ($dictionaryPick == "random")
        {
            $randomDictionary = $this->pickRandomDictionary();
            $dictionary = file($this->sourceDirectory . "/" . $randomDictionary);
        } else
        {
            $dictionary = file($this->sourceDirectory . "/" . $dictionaryPick);
        }


        $symbols = file($this->sourceDirectory . "/symbols.txt");


        $password = $this->generateTokens($dictionary, $symbols, $numWords, $numNumbers, $numSymbols, $separator);


        return $password;
    }

}

