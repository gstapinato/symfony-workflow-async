<?php

namespace App\Entity;

enum CatalogTransition: string
{
    case TO_PROCESSING  = 'to Processing';
    case TO_SUCCESS   = 'to success';
    case TO_FAILED    = 'to failed';
    case TO_PUBLISHED   = 'to published';
}
