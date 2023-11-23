## Sklep z elementami elektronicznymi

Prosty projekt na systemy baz danych, mający przy okazji na celu zapoznanie z Vue.js i poteżnym ekosystemem Laravela.

![shrek dla uwagi](https://static.android.com.pl/uploads/2022/11/Shrek-animacja-bajka.jpg)

### Wymagania

- PHP w wersji ≥8.1,
- Composer,
- Node.js i NPM,
- MySQL w wersji ≥8 albo MariaDB w wersji ≥10,
- Pusta baza danych o dowolnej nazwie.

### Stawianie projektu

1. Sklonuj repozytorium, oczywiście,
2. W dowolnej kolejności zainstaluj zależności:
    - `npm install`,
    - `composer update`;
3. Skopiuj plik `.env.example` jako `.env`,
4. W pliku `.env` ustaw poświadczenia do bazy danych (serwer, użytkownik, hasło, baza),
5. W konsoli uruchom polecenia:
    - `php artisan key:generate`,
    - `php artisan migrate:fresh`,
    - `php artisan db:seed`.

### Środowisko produkcyjne

1. W pliku `.env` ustaw następujące właściwości:
    - `APP_ENV = production`,
    - `APP_DEBUG = false`;
2. Zbuduj frontend komendą `npm run build`,
3. Zmapuj backend komendą `composer install --optimize-autoloader --no-dev`,
4. Zapisz aktualny stan backendu komendami:
    - `php artisan config:cache`,
    - `php artisan route:cache`.

### Uruchamianie aplikacji

Domyślnie aplikacja serwowana jest na `http://localhost:8000` – oczywiście do ustawienia w `.env`.

#### Środowisko deweloperskie

Należy uruchomić dwa procesy (okna) konsoli i wykonać polecenia:
- `php artisan serve` (backend),
- `npm run dev` (frontend).

#### Środowisko produkcyjne

W tym przypadku wystarczy uruchomić backend, ponieważ front jest już skompilowany do zwykłego JavaScript i CSS. Wystarczy zatem komenda `php artisan serve`.