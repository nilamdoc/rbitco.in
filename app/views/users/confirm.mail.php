Hi <?=$name?>,

Please confirm your email address associated at rbitco.in by clicking the following link:

https://<?=$_SERVER['HTTP_HOST'];?>/users/confirm/<?=$email?>/<?=$verification?>

Or use this confirmation code: <?=$verification?> for your email address: <?=$email?> on the page https://<?=$_SERVER['HTTP_HOST'];?>/users/email

Once you confirm your email address, you can send all your bitcoins to <?=$bitcoinaddress?>. 
You will see the balance of this on the server after sign in on https://<?=$_SERVER['HTTP_HOST'];?>/users/accounts
Your account has also been credited with <?=number_format($registerSelf,7);?> BTC.
You can make purchases from this on any website which supports bitcoin purchase.

Thanks
No-reply rBitcoin

P.S. Please do not reply to this email. 
This email was sent to you as you tried to register on rBitco.in with the email address. If you did not register, then you can delete this email.
We do not spam. 
