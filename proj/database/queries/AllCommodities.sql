.mode       columns 
.headers    on 
.nullvalue  NULL 
 
--All the commodities of a house 
 
SELECT H.Id as HouseId, C.Type as CommodityType 
FROM House H JOIN Commodity C ON H.Id = C.HouseId 
WHERE H.Id = 5; 
