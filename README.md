# Pack Street: The Game, Server  
### Really just a testbed for another javascript game server thing I've been writing.  
  
## Covering my ass  

No money is made from this game, yo.  
  
## Requirements  
php-cli 7.2.5+  
composer  
ratchet 0.4.1  
  
### I don't know what I'm doing, so just install composer and do the magic stuff :v  
### beyond that, i'm lost :D  
  
## Running the server  
$ php bin/psde-server.php  
Runs on port 1029 by default  
  
## Configuring apache2 for proxypass  
ProxyPass /nickInThighHighSocks/ ws://127.0.0.1:1029/  
  
