.mode       columns
.headers    on
.nullvalue  NULL

--When a house is available

SELECT H.Id as HouseId, A.StartDate as StarteDate, A.EndDate as EndDate
FROM House H JOIN Available A ON H.Id = A.HouseId
Where H.Id = 1;