<?php

namespace App\Entity;

enum CatalogState: string
{
    case INITIALIZED = 'initialized';
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case FAILED = 'failed';
    case SUCCESS = 'success';
    case PUBLISHED = 'published';
}