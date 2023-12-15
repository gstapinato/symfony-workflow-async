<?php

namespace App\Entity;
enum CatalogTransition: string
{
    case TO_PENDING  = 'pending';
    case TO_PROCESSING  = 'processing';
    case TO_SUCCESS   = 'success';
    case TO_FAILED    = 'failed';
    case TO_PUBLISHED   = 'published';
}