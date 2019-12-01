.mode       columns 
.headers    on 
.nullvalue  NULL 
 
--All comments about a house 
 
SELECT H.Id as HouseId, C.Id as Comment 
FROM Comment C JOIN Review Re ON C.ReviewId = Re.Id JOIN Rent R ON Re.RentId = R.Id JOIN House H ON R.HouseId = H.Id 
Where HouseId = 8;
