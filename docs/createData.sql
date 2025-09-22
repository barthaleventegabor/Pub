UPDATE types SET created = "2024-02-14" WHERE id = 1;
UPDATE types SET created = "2023-05-20" WHERE id = 2;
UPDATE types SET created = "2025-10-15" WHERE id = 3;
UPDATE types SET created = "2021-08-06" WHERE id = 4;
UPDATE types SET created = "2020-01-28" WHERE id = 5;

SELECT * FROM drinks
INNER JOIN types ON drinks.type_id = types.id
INNER JOIN packages ON drinks.package_id = packages.id
