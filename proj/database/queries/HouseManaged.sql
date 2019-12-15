.mode       columns 
.headers    on 
.nullvalue  NULL 
 
--All the houses that a user manages 
 
SELECT U.name as OwnerName, H.name as HouseName 
FROM User U JOIN House H ON U.Id = H.OwnerId 
WHERE U.name = 'Rudolfo';