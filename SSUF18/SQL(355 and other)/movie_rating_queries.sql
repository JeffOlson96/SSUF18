/*
In class moveie_rating exercise

1.
*/
select title from Movie where director = "Steven Speilberg";

-- 2.

select distinct Movie.year 
from Movie 
join Rating using(mID) 
where Rating.stars = 4 or Rating.stars = 5
order by Movie.year;


-- 3.

select name, title, stars, ratingDate
from Reviewer join Rating using(rID)
	join Movie using (mID)

order by name, title, stars;


-- 9.
select Reviewer.name
from Reviewer join Rating using(rID);
having count(distinct)