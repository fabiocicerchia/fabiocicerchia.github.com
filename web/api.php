<?php

/**
 *
 * FABIO CICERCHIA - WEBSITE
 * Copyright (C) 2012. All Rights reserved.
 *
 */

// -----------------------------------------------------------------------------
// INIT APPLICATION
// -----------------------------------------------------------------------------
$app = require_once __DIR__ . '/../apps/api/logic/app.php';

// -----------------------------------------------------------------------------
// RUN IT ----------------------------------------------------------------------
// -----------------------------------------------------------------------------
$app->run();
//$app['http_cache']->run();
