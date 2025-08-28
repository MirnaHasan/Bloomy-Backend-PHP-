CREATE OR REPLACE VIEW myfavorite AS
SELECT favorite.* , items.* , users.users_id FROM favorite
INNER JOIN items ON items.items_id=favorite.favorite_itemsid
INNER JOIN users ON users.users_id=favorite.favorite_usersid ;


CREATE OR REPLACE VIEW items1view AS
SELECT items.* , categories.* FROM items 
INNER JOIN categories ON items.items_cat = categories.categories_id ;



CREATE OR REPLACE VIEW cartview AS
SELECT SUM(items.items_price - items.items_price * items.items_discount/100) as itemsprice , COUNT(cart.cart_itemsid) as countitems , cart.* , items.* FROM cart 
INNER JOIN items ON items.items_id = cart.cart_itemsid
WHERE cart_orders = 0 
GROUP BY cart.cart_itemsid , cart.cart_usersid ;

