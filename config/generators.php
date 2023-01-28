<?php

return [
    'short_code' => [
        /**
         * What is the max length of our short code we wish to create.
         */
        'max_length' => env('GENERATOR_SHORT_CODE_MAX_LENGTH', 5),

        /**
         * Creating a randomly shuffled character set for our base62 conversion
         * will help hide our auto-increment ID value.
         *
         * You can generate a new value using the following line of code in tinker:
         * ```
         * str_shuffle(implode([...range('a', 'z'), ...range('A', 'Z'), ...range(0, 9)]))
         * ```
         */
        'character_set' => env('GENERATOR_SHORT_CODE_CHARACTER_SET', 'iAw2uy6ZmR0UrWgGcNBPfSzqHIFbda5789hLXvTpoECeVjQ4tD1nxOJs3MKYlk'),
    ],
];
