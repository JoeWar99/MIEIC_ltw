SELECT Path as path FROM House H join Photo P on H.Id = P.HouseId WHERE H.Id = ?;