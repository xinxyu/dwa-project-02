# CSCI E-15 Project 2:  XKCD Nolan Password Generator

## Live URL
<http://p2.xinxiongyu.com/>

## Description
A password generator described by this [xkcd comic](http://xkcd.com/936/)

This password generator uses words from Christopher Nolan's movies.
The list of words was retrieved by running a PHP scraper (scraper/scriptScraper.php)
through the following movie scripts:
* Batman Begins
* Inception
* Interstellar
* Memento
* The Prestige

The scriptScraper.php file runs through a list of raw movie script text files in scraper/raw_scripts and outputs
a list of words for each file in the generator_sources directory.

The index.php page validates input while the passwordGenerator.php contains a PasswordGenerator class for producing password strings.



## Demo
http://screencast.com/t/AkfNFcS7FaV

## Outside code and resources
* Bootstrap
  * <http://getbootstrap.com/>
* Movie Scripts 
  * <http://www.screenplaylists.com/top-screenplays-by-christopher-nolan/>
  * <http://www.imsdb.com/>
* Images
  * <http://www.impawards.com>
  * <http://www.digitalspy.com/>
