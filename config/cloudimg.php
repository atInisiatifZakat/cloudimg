<?php

return [
    'models' => [
        /**
         * Model must be instanceof `FromHome\Cloudimg\Contract\Models\SourceInterface`
         */
        'source' => FromHome\Cloudimg\Models\Source::class,
    ],

    'repositories' => [
        /**
         * Model must be instanceof `FromHome\Cloudimg\Contract\Repositories\SourceRepositoryInterface`
         */
        'source' => FromHome\Cloudimg\Repositories\SourceRepository::class,
    ],

    'error' => [
        /**
         * Default image when not found (404) error
         */
        'not_found' => 'undraw_page_not_found_su7k.svg',
    ],
];
