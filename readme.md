KatPHP
=====

A lightweight PHP PDO wrapper 


Usage
=====

Include the class in your project

```php
require_once('db.php');
```

A typical set-up might look something like this

```php
require_once('db.php');

DB::Connect( 'mysql:host=localhost;dbname=db','user','password');
 
$result = DB::QueryValue("SELECT id FROM Accounts WHERE username = :username OR email = :email", ['username'=>$username, 'email'=>$email]);
 
if($result){
    echo("Username or E-Mail is already in use");
} else{
    DB::Insert('accounts', ['username'=>$username, 'password'=>$hash, 'salt'=>$salt, 'email'=>$email]);
    echo("New account created successfully");
}
