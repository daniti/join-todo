# Todo (test)
## Note
Sono partito da slim-skeleton: https://github.com/slimphp/Slim-Skeleton
Ho aggiunto:
- *Eloquent*, come ORM
- *Phinx*, per gestire le migrations

## Migrazione
Richiede un database di nominato **todoapp**, o configurabile - come gli altri dati di connessione - tramite il file *db/db-config.php*
Dopo, aver lanciato **composer update**, si può eseguire il comando
**vendor/bin/phinx migrate**

(per il rollback: *vendor/bin/phinx rollback -t 0*)

## Test
Per il test di integrazione, ho ripreso la classe all'url http://lzakrzewski.com/2016/02/integration-testing-with-slim/ e modificata:
- aggiungendo la funzione *environment*, che ritorna l'ambiente allo stesso modo di Test\Functional\BaseTestCase
- ottimizzando il controllo sul content type nel metodo assertThatResponseHasContentType 
**vendor/bin/phpunit**