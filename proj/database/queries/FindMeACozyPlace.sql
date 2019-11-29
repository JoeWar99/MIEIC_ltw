SELECT Id, Name, Rating, PricePerDay
FROM House
WHERE (House.CityId = 2 AND House.Id IN (SELECT Id FROM Available WHERE StartDate <= '2020-10-22' AND EndDate >= '2020-11-15'));