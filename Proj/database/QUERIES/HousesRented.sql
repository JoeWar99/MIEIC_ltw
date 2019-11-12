.mode       columns
.headers    on
.nullvalue  NULL

--All the houses that a user rented

SELECT U.name as UserName, H.Name as HouseName
FROM User U JOIN Rent R ON U.Id = R.TouristId JOIN House H ON R.HouseId = H.Id
WHERE U.name = 'Orel';