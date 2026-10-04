DELETE FROM activities WHERE id IN (1, 2, 3, 4);
UPDATE activities SET name = 'Boating', slug = 'boating', image = 'https://chestnuttravel.net/wp-content/uploads/2024/03/1-820x490.png' WHERE id = 7;
UPDATE activities SET name = 'Food Tour', slug = 'foodtour', image = 'https://chestnuttravel.net/wp-content/uploads/2024/03/1-1.png' WHERE id = 9;
UPDATE activities SET name = 'Motorbike tour', slug = 'motorbiketour', image = 'https://chestnuttravel.net/wp-content/uploads/2024/03/1-2.png' WHERE id = 5;
UPDATE activities SET name = 'Trekking', slug = 'trekking', image = 'https://chestnuttravel.net/wp-content/uploads/2023/02/42b025303519e547bc08-1024x813.jpg' WHERE id = 6;
UPDATE activities SET name = 'Caves Exploring', slug = 'caves-exploring', image = 'https://chestnuttravel.net/wp-content/uploads/2023/02/z4294142951127_fb2887915831a97244f74a671e398a8e-1024x768.jpg' WHERE id = 8;
UPDATE activities SET name = 'Sightseeing', slug = 'sightseeing', image = 'https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=800&q=80' WHERE id = 10;
INSERT IGNORE INTO activity_tour (activity_id, tour_id) VALUES (9, 4), (9, 5), (9, 1);
