<?php

/*
 * The one business phone / WhatsApp number used across the whole site.
 *
 * To switch numbers (e.g. when one gets blocked):
 *   1. Put the new 10-digit number in $phone.
 *   2. Add the old number to $retired, so links already saved in blog posts,
 *      news stories and schema in the database are swapped too
 *      (App\Http\Middleware\SwapRetiredPhone does that on every public page).
 *   3. Deploy, then open /run-route-cache.
 *
 * Plain PHP with no env() on purpose, so non-Laravel files can require it.
 */

$phone   = '8595002933';
$retired = ['9554102933'];

return [
    'phone'   => $phone,                                                  // 8595002933
    'wa'      => '91' . $phone,                                           // 918595002933  (wa.me links)
    'tel'     => '+91' . $phone,                                          // +918595002933 (tel: links, schema)
    'display' => '+91 ' . substr($phone, 0, 5) . ' ' . substr($phone, 5), // +91 85950 02933
    'spaced'  => substr($phone, 0, 5) . ' ' . substr($phone, 5),          // 85950 02933
    'dashed'  => substr($phone, 0, 5) . '-' . substr($phone, 5),          // 85950-02933
    'retired' => $retired,
];
