/* Movie_rating queries from Hwk2.2
	Jeff Olson
	10/23/18

*/

--1
Select title from Movie where director = "Steven Spielberg";

--2
Select distinct year from Rating JOIN Movie where stars >= 4 AND Movie.mID = Rating.mID;


