<?php
$P = '₹5,000 fixed fee, PDF report in 48 hours.';
$V = fn($c) => "Property Verification in $c — ₹5,000, 48-Hour Report | DSD";
$R = fn($c) => "Property Registry Help in $c — Sale Deed & Advocate | DSD";
$M = [
 'property-verification-agra' => [$V('Agra'), "Buying property in Agra? We check ADA approval, Taj Trapezium Zone limits, flood zone and registry records. $P"],
 'property-verification-ayodhya' => [$V('Ayodhya'), "Buying property in Ayodhya? We check ADA approval, Ram Mandir zone limits, khatauni and court records. $P"],
 'property-verification-gorakhpur' => [$V('Gorakhpur'), "Buying property in Gorakhpur? We check GDA approval, flood zone, khatauni, encumbrance and court records. $P"],
 'property-verification-greater-noida' => [$V('Greater Noida'), "Buying in Greater Noida? We check GNIDA builder dues, OC, farmer land disputes and registry records. $P"],
 'property-verification-noida' => [$V('Noida'), "Buying in Noida? We check Noida Authority lease status, builder dues, RERA and registry records. $P"],
 'property-verification-prayagraj' => [$V('Prayagraj'), "Buying property in Prayagraj? We check PDA approval, flood zone, khatauni, encumbrance and court records. $P"],
 'property-verification-varanasi' => [$V('Varanasi'), "Buying property in Varanasi? We check registry records, khatauni, encumbrance, court cases and RERA. $P"],
 'property-registry-lucknow' => [$R('Lucknow'), 'Registering property in Lucknow? We draft the sale deed, check circle rate and stamp duty, and our advocate attends the registry. Fixed fee.'],
 'property-registry-agra' => [$R('Agra'), 'Registering property in Agra? We draft the sale deed, run TTZ and ASI buffer checks, and our advocate attends the registry. Fixed fee.'],
 'property-registry-ayodhya' => [$R('Ayodhya'), 'Registering property in Ayodhya? We draft the sale deed, check ADA title and corridor zones, and our advocate attends the registry. Fixed fee.'],
 'property-registry-gorakhpur' => [$R('Gorakhpur'), 'Registering property in Gorakhpur? We draft the sale deed, check GDA approval and Rapti flood zones, and our advocate attends the registry. Fixed fee.'],
 'property-registry-greater-noida' => [$R('Greater Noida'), 'Registering property in Greater Noida? We draft the sale deed, verify GNIDA dues and OC, and our advocate attends the registry. Fixed fee.'],
 'property-registry-noida' => [$R('Noida'), 'Registering property in Noida? We draft the sale deed, check lease status and builder dues, and our advocate attends the registry. Fixed fee.'],
 'property-registry-prayagraj' => [$R('Prayagraj'), 'Registering property in Prayagraj? We draft the sale deed, check flood zones and Waqf Board claims, and our advocate attends the registry. Fixed fee.'],
 'property-registry-varanasi' => [$R('Varanasi'), 'Registering property in Varanasi? We draft the sale deed, check Devasthan and Waqf Board claims, and our advocate attends the registry. Fixed fee.'],
 'property-advisory' => ['Property Advisor in Lucknow — Free 30-Minute Consultation | DSD', 'Buying property in Lucknow? Get unbiased advice on location, builder and price, plus negotiation and legal support. Book a free 30-minute consultation.'],
];
$esc = fn($s) => str_replace("'", "\'", $s);
foreach ($M as $slug => [$t, $d]) {
  $f = __DIR__."/../../resources/views/pages/services/$slug.blade.php"; $s = file_get_contents($f);
  $s = preg_replace("/^@section\('title', '.*'\)\s*$/mu", "@section('title', '".$esc($t)."')", $s, 1, $a);
  $s = preg_replace("/^@section\('meta_description', '.*'\)\s*$/mu", "@section('meta_description', '".$esc($d)."')", $s, 1, $b);
  if ($a !== 1 || $b !== 1) { echo "SKIP $slug ($a,$b)\n"; continue; }
  file_put_contents($f, $s);
  printf("%-36s title %2d  desc %3d\n", $slug, mb_strlen($t), mb_strlen($d));
}
