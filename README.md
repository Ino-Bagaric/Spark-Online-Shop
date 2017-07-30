# Spark-Online-Shop
Online Shop project for Spark

> This is an example of usage this API, with register / login system

**Install**
```shell
git clone git@github.com:Ino-Bagaric/Spark-Online-Shop.git
```

```
$composer install
```

**Login**
```php
// Default username:
user

// Default password:
123
```


**Functions**
```php
// Generate token with user class
$user = new User();
$token = $user->generateToken();
$api = new API($token);
```


```php
$api->getProduct($id = -1, $page = 'shop')
```

```php
$api->getProductData($id)
```

```php
$api->purchase($id)
```

```php
$api->cancelPurchase($id)
```

```php
$api->addToCart($id, $page = 'cart') 
```


*TODO List*
- [x] **Database (SQLite)**
- [x] **Composer**
- [x] **API**
  - [x] Implement JWT
  - [x] Get all items
  - [x] Putting the item in the cart
  - [x] Purchase
  - [x] Cancellation of purchase
  - [x] Get my last purchase
- [ ] **Managment**
   - [ ] Add product
   - [ ] Remove product
   - [ ] Edit product
- [x] **Front-End**
   - [x] HTML
   - [x] CSS
- [x] **Register**
- [x] **Login**