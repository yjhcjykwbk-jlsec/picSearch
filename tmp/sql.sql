use pics;
create table imgs(
	tags char(00), -- like a,b,c,d
	id int  increment not null primary key, 
	date date,  --the upload time of this pic
	pref char(100), --this is the reference page url of this image
	size int(2), --the width and height
	people char(100), -- may be a people's name or so "章子怡"
	desp char (100), --may be
	star float, -- the score from all people and get the average
	click int, --the click time of this pic
);
create table peoples(
	id int increment not null primary key,
	name char(40) not null primary key,
	tags char (200) , --a,b,c,d..
);	

