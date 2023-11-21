<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Pole :attribute musi zostać zaakceptowane.',
    'accepted_if' => 'Pole :attribute musi być zaakceptowane gdy wartość :other to :value.',
    'active_url' => 'Pole :attribute musi być prawidłowym adresem URL.',
    'after' => 'Pole :attribute musi zawierać datę po :date.',
    'after_or_equal' => 'Pole :attribute musi zawierać datę po lub równą :date.',
    'alpha' => 'Pole :attribute musi zawierać wyłącznie litery.',
    'alpha_dash' => 'Pole :attribute musi zawierać wyłącznie litery, cyfry, kreski i podkreślenia',
    'alpha_num' => 'Pole :attribute musi zawierać wyłącznie litery i cyfry',
    'array' => 'Pole :attribute musi zawierać tablicę.',
    'ascii' => 'Pole :attribute musi zawierać wyłącznie symbole ASCII.',
    'before' => 'Pole :attribute musi zawierać datę przed :date.',
    'before_or_equal' => 'Pole :attribute musi zawierać datę przed lub równą :date.',
    'between' => [
        'array' => 'Pole :attribute musi zawierać pomiędzy :min a :max komórek.',
        'file' => 'Pole :attribute musi zawierać plik rozmiaru pomiędzy :min a :max kilobajtów.',
        'numeric' => 'Pole :attribute musi zawierać wartość pomiędzy :min a :max.',
        'string' => 'Pole :attribute musi zawierać pomiędzy :min a :max znaków.',
    ],
    'boolean' => 'Pole :attribute musi zawierać wartość logiczną.',
    'can' => 'Pole :attribute ma niedozwoloną wartość.',
    'confirmed' => 'Pole :attribute nie zostało potwierdzone.',
    'current_password' => 'Błędne hasło.',
    'date' => 'Pole :attribute musi zawierać prawidłowo sformatowaną datę.',
    'date_equals' => 'Pole :attribute musi zawierać datę równą :date.',
    'date_format' => 'Pole :attribute musi spełniać format :format.',
    'decimal' => 'Pole :attribute musi zawierać liczbę z :decimal miejsc po przecinku.',
    'declined' => 'Pole :attribute nie może być zaakceptowane.',
    'declined_if' => 'Pole :attribute nie może być zaakceptowane gdy wartość :other to :value.',
    'different' => 'Polea :attribute i :other muszą się różnić.',
    'digits' => 'Pole :attribute musi zawierać liczbę mającą :digits cyfr.',
    'digits_between' => 'Pole :attribute musi zawierać liczbę mającą pomiędzy :min a :max cyfr.',
    'dimensions' => 'Pole :attribute zawiera obrazek o niewłaściwej rozdzielczości',
    'distinct' => 'Wartość pola :attribute nie może się powtarzać.',
    'doesnt_end_with' => 'Wartość pola :attribute nie może kończyć się na: :values.',
    'doesnt_start_with' => 'Wartość pola :attribute nie może zaczynać się na: :values.',
    'email' => 'Pole :attribute musi zawierać prawidłowy adres e-mail.',
    'ends_with' => 'Wartość pola :attribute musi kończyć się na: :values.',
    'enum' => 'Wartość pola wyboru :attribute jest niepoprawna.',
    'exists' => 'Pole :attribute nie istnieje.',
    'file' => 'Pole :attribute musi zawierać plik.',
    'filled' => 'Pole :attribute nie może być puste.',
    'gt' => [
        'array' => 'Pole :attribute musi zawierać powyżej :value komórek.',
        'file' => 'Pole :attribute musi zawierać plik rozmiaru powyżej :value kilobajtów.',
        'numeric' => 'Pole :attribute musi zawierać wartość powyżej :value.',
        'string' => 'Pole :attribute musi zawierać powyżej :value znaków.',
    ],
    'gte' => [
        'array' => 'Pole :attribute musi zawierać co najmniej :value komórek.',
        'file' => 'Pole :attribute musi zawierać plik rozmiaru co najmniej :value kilobajtów.',
        'numeric' => 'Pole :attribute musi zawierać wartość co najmniej :value.',
        'string' => 'Pole :attribute musi zawierać co najmniej :value znaków.',
    ],
    'image' => 'Pole :attribute musi zawierać obrazek.',
    'in' => 'Wartość pola wyboru :attribute jest niepoprawna.',
    'in_array' => 'Wartość pola :attribute musi występować w :other.',
    'integer' => 'Pole :attribute musi zawierać liczbę całkowitą.',
    'ip' => 'Pole :attribute musi zawierać adres IP.',
    'ipv4' => 'Pole :attribute musi zawierać adres IPv4.',
    'ipv6' => 'Pole :attribute musi zawierać adres IPv6.',
    'json' => 'Pole :attribute musi zawierać dokument JSON.',
    'lowercase' => 'Pole :attribute musi zawierać wyłącznie małe litery.',
    'lt' => [
        'array' => 'Pole :attribute musi zawierać poniżej :value komórek.',
        'file' => 'Pole :attribute musi zawierać plik rozmiaru poniżej :value kilobajtów.',
        'numeric' => 'Pole :attribute musi zawierać wartość poniżej :value.',
        'string' => 'Pole :attribute musi zawierać poniżej :value znaków.',
    ],
    'lte' => [
        'array' => 'Pole :attribute musi zawierać co najwyżej :value komórek.',
        'file' => 'Pole :attribute musi zawierać plik rozmiaru co najwyżej :value kilobajtów.',
        'numeric' => 'Pole :attribute musi zawierać wartość co najwyżej :value.',
        'string' => 'Pole :attribute musi zawierać co najwyżej :value znaków.',
    ],
    'mac_address' => 'Pole :attribute musi zawierać adres MAC.',
    'max' => [
        'array' => 'Pole :attribute musi zawierać co najwyżej :value komórek.',
        'file' => 'Pole :attribute musi zawierać plik rozmiaru co najwyżej :value kilobajtów.',
        'numeric' => 'Pole :attribute musi zawierać wartość co najwyżej :value.',
        'string' => 'Pole :attribute musi zawierać co najwyżej :value znaków.',
    ],
    'max_digits' => 'Pole :attribute musi zawierać liczbę mającą co najwyżej :value cyfr.',
    'mimes' => 'Pole :attribute musi zawierać plik o podanym typie MIME :values.',
    'mimetypes' => 'Pole :attribute musi zawierać plik o podanym typie MIME :values.',
    'min' => [
        'array' => 'Pole :attribute musi zawierać co najmniej :value komórek.',
        'file' => 'Pole :attribute musi zawierać plik rozmiaru co najmniej :value kilobajtów.',
        'numeric' => 'Pole :attribute musi zawierać wartość co najmniej :value.',
        'string' => 'Pole :attribute musi zawierać co najmniej :value znaków.',
    ],
    'min_digits' => 'Pole :attribute musi zawierać liczbę mającą co najmniej :value cyfr.',
    'missing' => 'Pole :attribute nie może istnieć.',
    'missing_if' => 'Pole :attribute nie może istnieć gdy wartość :other to :value.',
    'missing_unless' => 'Pole :attribute może istnieć tylko gdy wartość :other to :value.',
    'missing_with' => 'Pole :attribute nie może istnieć gdy wartość istnieje :values.',
    'missing_with_all' => 'Pole :attribute nie może istnieć gdy wartość istnieją :values.',
    'multiple_of' => 'Pole :attribute musi zawierać wielokrotność :value.',
    'not_in' => 'Wartość pola wyboru :attribute jest niepoprawna.',
    'not_regex' => 'Format pola :attribute jest błędny.',
    'numeric' => 'Pole :attribute musi zawierać liczbę.',
    'password' => [
        'letters' => 'Pole :attribute musi zawierać co najmniej :value znaków.',
        'mixed' => 'Pole :attribute musi zawierać co najmniej jedną wielką i małą literę.',
        'numbers' => 'Pole :attribute musi zawierać co najmniej jedną cyfrę.',
        'symbols' => 'Pole :attribute musi zawierać co najmniej jeden znak specjalny.',
        'uncompromised' => 'Ta wartość pojawiła się w wycieku danych. Zmień :attribute.',
    ],
    'present' => 'Pole :attribute musi istnieć.',
    'prohibited' => 'Pole :attribute jest zabronione.',
    'prohibited_if' => 'Pole :attribute jest zabronione gdy wartość :other to :value.',
    'prohibited_unless' => 'Pole :attribute może istnieć tylko gdy wartość :other to :values.',
    'prohibits' => 'Pole :attribute zabrania istnienia :other.',
    'regex' => 'Format pola :attribute jest błędny.',
    'required' => 'Pole :attribute jest wymagane.',
    'required_array_keys' => 'Pole :attribute musi zawierać wartość dla :values.',
    'required_if' => 'Pole :attribute jest wymagane gdy wartość :other to :value.',
    'required_if_accepted' => 'Pole :attribute jest wymagane gdy zaakceptowano :other.',
    'required_unless' => 'Pole :attribute nie jest wymagane tylko gdy wartość :other to :values.',
    'required_with' => 'Pole :attribute jest wymagane gdy istnieje :values.',
    'required_with_all' => 'Pole :attribute jest wymagane gdy istnieją :values.',
    'required_without' => 'Pole :attribute jest wymagane gdy nie istnieje :values.',
    'required_without_all' => 'Pole :attribute jest wymagane gdy nie istnieją :values.',
    'same' => 'Wartości pól :attribute i :other muszą być takie same.',
    'size' => [
        'array' => 'Pole :attribute musi zawierać :value komórek.',
        'file' => 'Pole :attribute musi zawierać plik rozmiaru :value kilobajtów.',
        'numeric' => 'Pole :attribute musi zawierać wartość :value.',
        'string' => 'Pole :attribute musi zawierać :value znaków.',
    ],
    'starts_with' => 'Pole :attribute musi zaczynać się na :values.',
    'string' => 'Pole :attribute musi zawierać wartość tekstową.',
    'timezone' => 'Pole :attribute musi zawierać strefę czasową.',
    'unique' => 'Ta wartość :attribute jest zajęta.',
    'uploaded' => 'Nie udało się wgrać :attribute.',
    'uppercase' => 'Pole :attribute musi zawierać wyłącznie wielkie litery.',
    'url' => 'Pole :attribute musi zawierać adres URL.',
    'ulid' => 'Pole :attribute musi zawierać identyfikator ULID.',
    'uuid' => 'Pole :attribute musi zawierać identyfikator UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'emailAddress' => 'adres e-mail',
        'password' => 'hasło',
        'repeatPassword' => 'powtórz hasło',
        'shippingData.firstName' => 'imię',
        'shippingData.lastName' => 'nazwisko',
        'shippingData.emailAddress' => 'adres e-mail',
        'shippingData.phoneNumber' => 'numer telefonu',
        'shippingData.address.country' => 'państwo',
        'shippingData.address.city' => 'miasto',
        'shippingData.address.postalCode' => 'kod pocztowy',
        'shippingData.address.street' => 'ulica',
        'shippingData.address.building' => 'nr budynku',
        'shippingData.address.apartment' => 'nr lokalu',
        'shippingMethod' => 'metoda wysyłki',
        'paymentMethod' => 'metoda płatności'
    ],

];
