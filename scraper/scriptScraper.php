<?php
/**
 * This script scrapes all files in the raw_scripts folder and creates a newline delimited
 * unique list of words in the generator_sources folder
 */

# loop through all files in the the raw_scripts folder
$dir = new DirectoryIterator("raw_scripts");
foreach ($dir as $fileinfo )
{
    if (!$fileinfo->isDot())
    {
        $inFile = 'raw_scripts/' . $fileinfo->getFilename();
        # read the file in as a string
        $fileText = file_get_contents($inFile);

        # turn text into lowercase
        $fileText = strtolower($fileText);

        # remove html tags
        $fileText = strip_tags($fileText);

        # remove apostrophes (e.g. treat "could've" as one word "couldve")
        $fileText = preg_replace("/'/", "", $fileText);

        # replace special characters with spaces (spreads out words so they can be delimited by spaces later)
        $fileText = preg_replace("/[^\p{L}\p{N}\s]/u", " ", $fileText);

        # keep only letters and white space
        $fileText = preg_replace("/[^a-z \s]+/", "", $fileText);

        # remove single characters (probably not real words with very few exceptions)
        $fileText = preg_replace("/\b\w\b\s?/", '', $fileText);

        # split the string by white space
        $words = preg_split("/[\s]+/", $fileText, -1, PREG_SPLIT_NO_EMPTY);

        # remove duplicate words
        $uniqueWords = array_unique($words);


        # create an output file name based on the input file name
        $inFileExtension = pathinfo($inFile, PATHINFO_EXTENSION);
        $outFileName = basename($inFile, "." . $inFileExtension) . '_words.txt';


        # write each word to a file with a new line delimiter
        $uniqueWordsString = implode("\n", $uniqueWords);

        fwrite(fopen('../generator_sources/' . $outFileName, 'w'), $uniqueWordsString);
    }
}