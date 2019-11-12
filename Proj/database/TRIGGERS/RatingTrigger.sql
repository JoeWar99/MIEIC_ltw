CREATE TRIGGER updateRating AFTER INSERT ON Review

BEGIN

UPDATE House
SET Rating = (SELECT SUM(Rating)/COUNT(Rating) FROM (RENT JOIN REVIEW ON RENT.Id = Review.RentID) WHERE Rent.HouseId = (SELECT HOUSE.Id FROM House, Rent WHERE House.Id = (SELECT HouseId FROM Rent WHERE Rent.Id = new.RentId)))
WHERE Id = (SELECT HOUSE.Id FROM House, Rent WHERE House.Id = (SELECT HouseId FROM Rent WHERE Rent.Id = new.RentId));

END;