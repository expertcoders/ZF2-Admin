ZF2-Admin
========================================================================

ZF2 Admin and User Module



Installation
========================================================================
Import zend.sql into you database server, You can find /data/zend.sql

Configuration the credentials according to your database into
```php
config/autoload/local.php.dist
'db' => array(
        'username' => 'DATABASE_USER_NAME',
        'password' => 'DATABASE_PASSWORD',
),
```    
    
Change these setting
```php
"DATABASE_USER_NAME" to "YOUR_DATABASE_USER_NAME" and
"DATABASE_PASSWORD" to "YOUR_DATABASE_USER_PASSWORD"
```

If your database hosted in "localhost" and MYSQL, then there is no need 
to change into host section, 


Configure DATABASE name, if your databae name is change, You can find these

```php
/config/autoload/global.php
urn array(
    'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=zend;host=localhost',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
```
You can change according to your setting, here you can see database is
"zend"


Run   
========================================================================

```
http://localhost/yourprojectname/public/admin

Username: pradeep
Password: 123456
```

Remove public from URL	
========================================================================
If you want to remove public from URl, then follow these steps
Copy all the files and directory from /public deirectory

Paste all the copied files and directory in root directory

Open index.php and edit the line number 6 and comment like this

```php

//chdir(dirname(__DIR__));

```

done!!

Now you can access
```php

http://localhost/yourprojectname/

```


