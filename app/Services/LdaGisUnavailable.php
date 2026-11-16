<?php

namespace App\Services;

/** LDA's GIS server did not answer (down, slow or changed). The tool shows a "try again" message, never stale data. */
class LdaGisUnavailable extends \RuntimeException
{
}
