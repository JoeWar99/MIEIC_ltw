.mode       columns 
.headers    on 
.nullvalue  NULL 
 
--All Houses in a country and city 
 
SELECT H.Id as HouseId, C.name as Country 
FROM House H JOIN City Ci ON H.CityId = Ci.Id JOIN Country C ON Ci.CountryId = C.Id 
WHERE C.name = 'Portugal' AND Ci.Name = 'Vermoim';